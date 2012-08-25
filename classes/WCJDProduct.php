<?php
class WCJDProduct {

    public $options;

    public function __construct($options) {
        $this->options = $options;
    }

    public function addAudioPreviewResources() {

        // Media Element JavaScript
        wp_enqueue_script('media-element', plugins_url('mediaelement-default/mediaelement-and-player.min.js', dirname(__FILE__)), 'jquery', '2.9.1');
        wp_enqueue_script('media-element-initialisation', plugins_url('javascript/media-element/initialisation.js', dirname(__FILE__)), 'media-element', '2.9.1', true);
        wp_localize_script('media-element-initialisation', 'wcjdAudioPreviewOptions',
            array(
                WCJDOptions::PREVIEW_PLAYER_WIDTH => $this->options->previewPlayerWidth(),
                WCJDOptions::PREVIEW_PLAYER_HEIGHT => $this->options->previewPlayerHeight(),
                WCJDOptions::INDIVIDUAL_PLAYER_WIDTH => $this->options->individualPlayerWidth(),
                WCJDOptions::INDIVIDUAL_PLAYER_HEIGHT => $this->options->individualPlayerHeight(),
                'pluginPath' => plugins_url('mediaelement-default/', dirname(__FILE__))
            ));

        // Media Element CSS

        if (is_single()) {
            // If the user has not chosen to use custom media element CSS,
            // or they have but haven't actually modified the CSS, output the default style.
            $useCustomMediaElementCss = $this->options->individualPlayerUseCustomMediaElementCss() && ($this->options->defaultMediaElementCss() !== $this->options->individualPlayerCustomMediaElementCss());
            if ($useCustomMediaElementCss) {
                add_action('wp_head', array(&$this, 'outputIndividualPlayerCustomMediaElementCss'));
            } else {
                wp_register_style('media-element-style', plugins_url('mediaelement-default/mediaelementplayer.css', dirname(__FILE__)), false, '2.9.1');
                wp_enqueue_style('media-element-style');
            }
        } else {
            // If the user has not chosen to use custom media element CSS,
            // or they have but haven't actually modified the CSS, output the default style.
            $useCustomMediaElementCss = $this->options->previewPlayerUseCustomMediaElementCss() && ($this->options->defaultMediaElementCss() !== $this->options->previewPlayerCustomMediaElementCss());
            if ($useCustomMediaElementCss) {
                add_action('wp_head', array(&$this, 'outputPreviewPlayerCustomMediaElementCss'));
            } else {
                wp_register_style('media-element-style', plugins_url('mediaelement-default/mediaelementplayer.css', dirname(__FILE__)), false, '2.9.1');
                wp_enqueue_style('media-element-style');
            }
            // Custom CSS
            $useCustomCss = $this->options->useCustomCss();
            if ($useCustomCss) {
                add_action('wp_head', array(&$this, 'outputCustomCss'));
            }
        }


        // Add common me overrides
        wp_register_style('media-element-style-common', plugins_url('css/common.css', dirname(__FILE__)), false, '1.0.0');
        wp_enqueue_style('media-element-style-common');
    }

    public function outputPreviewPlayerCustomMediaElementCss() {
        $css = WCJDCSS::minify($this->options->previewPlayerCustomMediaElementCss());
        include WCJD_ROOT.'/views/head/css/custom-media-element.php';
    }

    public function outputIndividualPlayerCustomMediaElementCss() {
        $css = WCJDCSS::minify($this->options->individualPlayerCustomMediaElementCss());
        include WCJD_ROOT.'/views/head/css/custom-media-element.php';
    }

    public function outputCustomCss() {
        $useCustom = $this->options->defaultCss() !== $this->options->customCss();
        $css = $this->options->defaultCss();
        if ($useCustom) {
            $css = $this->options->customCss();
        }
        $css = WCJDCSS::minify($css);
        include WCJD_ROOT.'/views/head/css/custom.php';
    }

    public function displayPlayer($className) {
        global $product;
        $previewUrl = get_post_meta($product->id, WCJDWooCommerceAdminAdditions::PREVIEW_URL_KEY, true);
        include WCJD_ROOT.'/views/product/audio-preview.php';
    }

    /* Individual player */

    public function displayIndividualPlayer() {
        return $this->displayPlayer($this->options->individualPlayerClass());
    }

    /* Preview player */

    public function displayPreviewPlayer() {
        return $this->displayPlayer($this->options->previewPlayerClass());
    }

    public function addProductsWrapOpen() {
        echo '<div class="wcjd-products">';
    }

    public function addProductsWrapClose() {
        echo '</div>';
    }

    /**
     * Output HTML for product footer, replacing tokens if present.
     */
    public function displayFooter() {
        global $product;

        $view = $this->options->footerHtml();

        // Author
        if (strpos($view, '{{producer}}') !== false) {

            $authorID = $product->get_post_data()->post_author;
            $authorDisplayName = get_the_author_meta('display_name', $authorID);
            $authorUsername = get_the_author_meta('user_login', $authorID);
            $authorNickname = get_the_author_meta('nickname', $authorID);

            $authorName = $authorDisplayName ? $authorDisplayName : $authorNickname ? $authorNickname : $authorUsername;
            $view = str_replace('{{producer}}', $authorName, $view);
        }
        // Categories
        if (strpos($view, '{{categories}}') !== false) {
            $categories = $product->get_categories();
            $view = str_replace('{{categories}}', $categories, $view);
        }
        // Information button
        if (strpos($view, '{{product-url}}')) {
            $view = str_replace('{{product-url}}', get_permalink($product->id), $view);
        }

        echo $view;
    }
}
