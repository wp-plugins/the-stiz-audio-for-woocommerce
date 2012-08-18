<?php
class WCJDServeAudio {

    private $request;
    private $file = null;

    const KEY = 'vMfMDP2o4G56Q7m';

    public function __construct($request) {
        $this->request = $request;
        $this->uri = $_SERVER['REQUEST_URI'];
    }

    /**
     * Encode audio file into the URL to be used as the src for the <audio> element
     * @param  {String} $url The actual URL for the audio file.
     * @return {String} The encoded URL
     */
    public static function encode($url) {

        $nonce = wp_create_nonce(__FILE__);
        $audioFile = WCJDEncryption::encrypt($url, self::KEY);
        $baseUrl = plugins_url("server/preview.mp3", dirname(__FILE__));
        // $baseUrl = plugins_url("server/{$audioFile}.mp3", dirname(__FILE__));

        return "{$baseUrl}?nonce={$nonce}&audio={$audioFile}";
    }

    /**
     * Converts a URI like /wordpress/wp-content/uploads/woocommerce-jive-dig-audio-preview-uploads/2012/06/Damn-It-Feels-Good-To-Be-A-Gangsta.mp3
     * to something like: /var/www/site.co.nz/public/wordpress/wp-content/uploads/woocommerce-jive-dig-audio-preview-uploads/2012/06/Damn-It-Feels-Good-To-Be-A-Gangsta.mp3
     * @param  {String} $file The public URI to be converted.
     * @return {String} The private path to the URI's file.
     */
    private static function convertPublicPathToPrivate($file) {
        $publicPathPortion = str_replace('http://'.$_SERVER['SERVER_NAME'], '', home_url());
        $privatePathPortion = substr(ABSPATH, 0, strpos(ABSPATH, $publicPathPortion));
        return $privatePathPortion.$file;
    }

    public function validRequest() {

        if (!isset($this->request['nonce'])) {
            return false;
        }

        if (!wp_verify_nonce($this->request['nonce'], __FILE__)) {
            return false;
        }

        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
        $apple = isset($_SERVER['HTTP_USER_AGENT']) ? preg_match('/^(QuickTime|AppleCoreMedia)/', $_SERVER['HTTP_USER_AGENT']) : false;

        if (!$referer && !$apple) {
            return false;
        }

        // If the referer is present, test to ensure it is valid
        if ($referer) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https://' : 'http://';
            if (strpos($referer, $protocol.$_SERVER['SERVER_NAME']) !== 0) {
                return false;
            }
        }
        // If there is no referer present, only allow request to proceed if requester is Quicktime
        else if (!$apple) {
            return false;
        }

        // if (!isset($this->request['audio'])) {
        //     return false;
        // }

        // $audioFile = WCJDEncryption::decrypt(pathinfo($this->uri, PATHINFO_FILENAME), self::KEY);
        $audioFile = WCJDEncryption::decrypt($this->request['audio'], self::KEY);
        if (!$audioFile) {
            return false;
        }

        $this->file = $this->convertPublicPathToPrivate($audioFile);

        if (!is_file($this->file)) {
            return false;
        }

        return true;
    }

    public function output() {
        // Session locking prevents multiple files from buffering simultaneously,
        // closing session write prevents this
        if (session_id()) {
            session_write_close();
        }

        if (!file_exists($this->file)) {
            header ('HTTP/1.1 404 Not Found');
            return;
        }

        header("Content-type: audio/mpeg");

        // http://forums.phpfreaks.com/index.php?topic=198274.0
        $size   = filesize($this->file); // File size
        if (!isset($_SERVER['HTTP_RANGE'])) {
            header("Content-Length: {$file}");
            readfile($this->file);
            exit;
        }

        $fp = @fopen($this->file, 'rb');

        $length = $size;           // Content length
        $start  = 0;               // Start byte
        $end    = $size - 1;       // End byte
        // Now that we've gotten so far without errors we send the accept range header
        /* At the moment we only support single ranges.
         * Multiple ranges requires some more work to ensure it works correctly
         * and comply with the spesifications: http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
         *
         * Multirange support annouces itself with:
         * header('Accept-Ranges: bytes');
         *
         * Multirange content must be sent with multipart/byteranges mediatype,
         * (mediatype = mimetype)
         * as well as a boundry header to indicate the various chunks of data.
         */
        header("Accept-Ranges: 0-{$length}");
        // header('Accept-Ranges: bytes');
        // multipart/byteranges
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
        $c_start = $start;
        $c_end   = $end;
        // Extract the range string
        list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
        // Make sure the client hasn't sent us a multibyte range
        if (strpos($range, ',') !== false) {
            // (?) Shoud this be issued here, or should the first
            // range be used? Or should the header be ignored and
            // we output the whole content?
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes {$start}-{$end}/{$size}");
            // (?) Echo some info to the client?
            exit;
        }
        // If the range starts with an '-' we start from the beginning
        // If not, we forward the file pointer
        // And make sure to get the end byte if spesified
        if ($range{0} == '-') {
            // The n-number of the last bytes is requested
            $c_start = $size - substr($range, 1);
        } else {
            $range  = explode('-', $range);
            $c_start = $range[0];
            $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
        }
        /* Check the range and make sure it's treated according to the specs.
         * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
         */
        // End bytes can not be larger than $end.
        $c_end = ($c_end > $end) ? $end : $c_end;
        // Validate the requested range and return an error if it's not correct.
        if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes {$start}-{$end}/{$size}");
            // (?) Echo some info to the client?
            exit;
        }
        $start  = $c_start;
        $end    = $c_end;
        $length = $end - $start + 1; // Calculate new content length
        fseek($fp, $start);
        header('HTTP/1.1 206 Partial Content');

        // Notify the client the byte range we'll be outputting
        header("Content-Range: bytes {$start}-{$end}/{$size}");
        header("Content-Length: {$length}");

        // Start buffered download
        $buffer = 1024 * 8;
        while(!feof($fp) && ($p = ftell($fp)) <= $end) {
            if ($p + $buffer > $end) {
                // In case we're only outputtin a chunk, make sure we don't
                // read past the length
                $buffer = $end - $p + 1;
            }
            set_time_limit(0); // Reset time limit for big files
            echo fread($fp, $buffer);
            flush(); // Free up memory. Otherwise large files will trigger PHP's memory limit.
        }

        fclose($fp);

    }

}
