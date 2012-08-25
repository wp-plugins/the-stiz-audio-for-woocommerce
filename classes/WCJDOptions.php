<?php

class WCJDOptions {

    const OPTIONS = 'wcjd-options';
    const HIDE_THUMBNAILS = 'wcjd-options-hide-thumbnails';
    const FOOTER_HTML = 'wcjd-options-footer-html';
    const USE_CUSTOM_CSS = 'wcjd-options-use-custom-css';
    const CUSTOM_CSS = 'wcjd-options-custom-css';

    const PREVIEW_PLAYER_USE_CUSTOM_MEDIA_ELEMENT_CSS = 'wcjd-options-use-custom-media-element-css';
    const PREVIEW_PLAYER_CUSTOM_MEDIA_ELEMENT_CSS = 'wcjd-options-custom-media-element-css';

    const INDIVIDUAL_PLAYER_USE_CUSTOM_MEDIA_ELEMENT_CSS = 'wcjd-options-individual-use-custom-media-element-css';
    const INDIVIDUAL_PLAYER_CUSTOM_MEDIA_ELEMENT_CSS = 'wcjd-options-individual-custom-media-element-css';

    const INDIVIDUAL_PLAYER_CLASS = 'wcjd-audio-individual';
    const PREVIEW_PLAYER_CLASS = 'wcjd-audio-preview';

    // Player initialistion options

    // Single product values
    const DISPLAY_FOR_INDIVIDUAL_PRODUCTS = 'the-stiz-individual-display';
    const DISPLAY_INDIVIDUAL_ABOVE = 'the-stiz-individual-display-above';
    const DISPLAY_INDIVIDUAL_BELOW = 'the-stiz-individual-display-below';
    const DISPLAY_INDIVIDUAL_IN_SUMMARY = 'the-stiz-individual-display-in-summary';

    const INDIVIDUAL_PLAYER_WIDTH = 'the-stiz-individual-width';
    const INDIVIDUAL_PLAYER_HEIGHT = 'thi-stiz-individual-height';
    const INDIVIDUAL_PLAYER_POSITION = 'thi-stiz-individual-player-position';

    // Preview product
    const DISPLAY_FOR_PREVIEWS = 'the-stiz-preview-display';
    const DISPLAY_PREVIEW_ABOVE_HEADING = 'wcjd-player-above-heading';
    const DISPLAY_PREVIEW_BELOW_HEADING = 'wcjd-player-below-heading';

    const PREVIEW_PLAYER_WIDTH = 'the-stiz-preview-width';
    const PREVIEW_PLAYER_HEIGHT = 'the-stiz-preview-height';
    const PREVIEW_PLAYER_POSITION = 'wcjd-options-player-position';

    const UPLOAD_DIRECTORY_PATH_SEGMENT = 'the-stiz-audio-preview-for-woocommerce';

    private $options = false;

    public function __construct() {
        $this->load();
    }

    public static function downloadDirectory($file = null) {
        $uploadDirectory = wp_upload_dir();
        return $uploadDirectory['basedir'] . '/' . self::UPLOAD_DIRECTORY_PATH_SEGMENT . '/' . $file;
    }

    private function load() {
        $this->options = get_option(self::OPTIONS);
        if(!is_array($this->options)) {
            $this->options = array(
                self::HIDE_THUMBNAILS => '1',
                self::FOOTER_HTML => $this->defaultFooterHtml(),
                self::USE_CUSTOM_CSS => '1',
                self::CUSTOM_CSS => $this->defaultCss(),

                self::PREVIEW_PLAYER_USE_CUSTOM_MEDIA_ELEMENT_CSS => '1',
                self::PREVIEW_PLAYER_CUSTOM_MEDIA_ELEMENT_CSS => $this->defaultMediaElementCss(),

                self::INDIVIDUAL_PLAYER_CLASS => $this->individualPlayerClass(),
                self::PREVIEW_PLAYER_CLASS => $this->previewPlayerClass(),

                self::DISPLAY_FOR_PREVIEWS => true,

                self::PREVIEW_PLAYER_HEIGHT => 30,
                self::PREVIEW_PLAYER_WIDTH => 400,
                self::PREVIEW_PLAYER_POSITION => self::DISPLAY_PREVIEW_ABOVE_HEADING,

                self::DISPLAY_FOR_INDIVIDUAL_PRODUCTS => true,

                self::INDIVIDUAL_PLAYER_HEIGHT => 30,
                self::INDIVIDUAL_PLAYER_WIDTH => 400,
                self::INDIVIDUAL_PLAYER_POSITION => self::DISPLAY_INDIVIDUAL_IN_SUMMARY,
            );
            update_option(self::OPTIONS, $this->options);
        }
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            update_option(self::OPTIONS, $_POST);
            $this->load();
        }
    }

    public function getOption($key) {
        if (!isset($this->options[$key])) {
            return null;
        }
        return $this->options[$key];
    }

    public function hideThumbnails() {
        return $this->getOption(self::HIDE_THUMBNAILS);
    }

    public function footerHtml() {
        return stripslashes($this->getOption(self::FOOTER_HTML));
    }

    public function defaultFooterHtml() {
        return file_get_contents(WCJD_ROOT.'/views/product/default-footer.html');
    }

    public function previewPlayerUseCustomMediaElementCss() {
        return $this->getOption(self::PREVIEW_PLAYER_USE_CUSTOM_MEDIA_ELEMENT_CSS);
    }

    public function previewPlayerCustomMediaElementCss() {
        return $this->getOption(self::PREVIEW_PLAYER_CUSTOM_MEDIA_ELEMENT_CSS);
    }

    public function individualPlayerUseCustomMediaElementCss() {
        return $this->getOption(self::INDIVIDUAL_PLAYER_USE_CUSTOM_MEDIA_ELEMENT_CSS);
    }

    public function individualPlayerCustomMediaElementCss() {
        return $this->getOption(self::INDIVIDUAL_PLAYER_CUSTOM_MEDIA_ELEMENT_CSS);
    }

    public function defaultMediaElementCss() {
        return file_get_contents(WCJD_ROOT.'/mediaelement-default/mediaelementplayer.css');
    }

    public function defaultMediaElementSingleButtonCss () {
        return file_get_contents(WCJD_ROOT.'/mediaelement-single-button/style.css');
    }

    public function useCustomCss() {
        return $this->getOption(self::USE_CUSTOM_CSS);
    }

    public function customCss() {
        return $this->getOption(self::CUSTOM_CSS);
    }

    public function defaultCss() {
        return file_get_contents(WCJD_ROOT.'/css/custom.css');
    }

    public function previewPlayerHeight() {
        return $this->getOption(self::PREVIEW_PLAYER_HEIGHT);
    }

    public function previewPlayerWidth() {
        return $this->getOption(self::PREVIEW_PLAYER_WIDTH);
    }

    public function previewPlayerPosition() {
        return $this->getOption(self::PREVIEW_PLAYER_POSITION);
    }

    public function displayForPreviews() {
        return $this->getOption(self::DISPLAY_FOR_PREVIEWS);
    }

    public function displayForIndividualProducts() {
        return $this->getOption(self::DISPLAY_FOR_INDIVIDUAL_PRODUCTS);
    }

    public function individualPlayerHeight() {
        return $this->getOption(self::INDIVIDUAL_PLAYER_HEIGHT);
    }

    public function individualPlayerWidth() {
        return $this->getOption(self::INDIVIDUAL_PLAYER_WIDTH);
    }

    public function individualPlayerPosition() {
        return $this->getOption(self::INDIVIDUAL_PLAYER_POSITION);
    }

    public function individualPlayerClass() {
        return self::INDIVIDUAL_PLAYER_CLASS;
    }

    public function previewPlayerClass() {
        return self::PREVIEW_PLAYER_CLASS;
    }


}
