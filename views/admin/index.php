<div class="wrap wcjd-wrap">
    <div class="wcjd-settings-form">
        <h2>The Stiz - Audio for WooCommerce Options</h2>

        <form method="post" action="" autocomplete="off">

            <?php $this->options->save(); ?>
            <?php settings_fields(WCJDOptions::OPTIONS); ?>

            <div id="wcjd-options-tabs">
                <ul>
                    <li><a href="#wcjd-options-product-preview">Product Preview</a></li>
                    <li><a href="#wcjd-options-individual-product">Individual Product</a></li>
                    <li><a href="#wcjd-options-general-styling">Product list Styling</a></li>
                    <li><a href="#wcjd-options-audio-preview-styling">Audio Styling</a></li>
                </ul>

                <!-- Product Preview -->
                <div id="wcjd-options-product-preview">
                    <label for="wcjd-hide-preview-thumbnails">
                        <input autocomplete="off" id="wcjd-hide-preview-thumbnails" type="checkbox" value="1" name="<?php echo WCJDOptions::HIDE_THUMBNAILS; ?>" <?php if ($this->options->hideThumbnails()) echo 'checked="checked"'; ?> />
                        Hide preview thumbnails
                    </label>
                    <br/>

                    <hr/>

                    <h3>Product Previews</h3>
                    <label for="wcjd-display-preview-player">
                        <input autocomplete="off" id="wcjd-display-preview-player" type="checkbox" value="<?php echo WCJDOptions::DISPLAY_FOR_PREVIEWS; ?>" name="<?php echo WCJDOptions::DISPLAY_FOR_PREVIEWS; ?>" <?php if ($this->options->displayForPreviews() === WCJDOptions::DISPLAY_FOR_PREVIEWS) echo 'checked="checked"'; ?>/>
                        Display player on preview items
                    </label>
                    <div class="wcjd-nested-elements" id="wcjd-display-preview-player-position-wrap">
                        <label for="wcjd-position-above">
                            <input autocomplete="off" id="wcjd-position-above" type="radio" value="<?php echo WCJDOptions::DISPLAY_PREVIEW_ABOVE_HEADING; ?>" name="<?php echo WCJDOptions::PREVIEW_PLAYER_POSITION; ?>" <?php if ($this->options->previewPlayerPosition() === WCJDOptions::DISPLAY_PREVIEW_ABOVE_HEADING) echo 'checked="checked"'; ?>/>
                            Above product heading
                        </label>
                        <br/>
                        <label for="wcjd-position-below">
                            <input autocomplete="off" id="wcjd-position-below" type="radio" value="<?php echo WCJDOptions::DISPLAY_PREVIEW_BELOW_HEADING; ?>" name="<?php echo WCJDOptions::PREVIEW_PLAYER_POSITION; ?>" <?php if ($this->options->previewPlayerPosition() === WCJDOptions::DISPLAY_PREVIEW_BELOW_HEADING) echo 'checked="checked"'; ?>/>
                            Below product heading
                        </label>
                        <br/>
                        <br/>
                        <label for="wcjd-width">Width</label>
                        <input autocomplete="off" id="wcjd-width" type="text" value="<?php echo $this->options->previewPlayerWidth(); ?>" name="<?php echo WCJDOptions::PREVIEW_PLAYER_WIDTH; ?>" />
                        <label for="wcjd-height">Height</label>
                        <input autocomplete="off" id="wcjd-height" type="text" value="<?php echo $this->options->previewPlayerHeight(); ?>" name="<?php echo WCJDOptions::PREVIEW_PLAYER_HEIGHT; ?>" />
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-display-preview-player').change(function() {
                                $('#wcjd-display-preview-player-position-wrap').toggle($(this).is(':checked'));
                            }).trigger('change');
                        })(jQuery);
                    </script>

                    <hr/>

                    <div>
                        <label for="wcjd-footer-html">Product Preview Footer HTML</label>
                        <textarea id="wcjd-footer-html" name="<?php echo WCJDOptions::FOOTER_HTML; ?>"><?php echo $this->options->footerHtml(); ?></textarea>
                        <p class="submit">
                            <input id="wcjd-reset-footer-html" type="button" class="button-primary" value="<?php _e('Reset Footer HTML') ?>" />
                        </p>
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-reset-footer-html').click(function() {
                                $('#wcjd-footer-html').html(<?php echo json_encode($this->options->defaultFooterHtml()); ?>);
                            });
                        })(jQuery);
                    </script>
                </div>

                <!-- Individual Products -->
                <div id="wcjd-options-individual-product">

                    <label for="wcjd-display-individual-player">
                        <input autocomplete="off" id="wcjd-display-individual-player" type="checkbox" value="<?php echo WCJDOptions::DISPLAY_FOR_INDIVIDUAL_PRODUCTS; ?>" name="<?php echo WCJDOptions::DISPLAY_FOR_INDIVIDUAL_PRODUCTS; ?>" <?php if ($this->options->displayForIndividualProducts() === WCJDOptions::DISPLAY_FOR_INDIVIDUAL_PRODUCTS) echo 'checked="checked"'; ?>/>
                        Display player on product pages
                    </label>
                    <div class="wcjd-nested-elements" id="wcjd-display-individual-player-position-wrap">
                        <label for="wcjd-individual-position-above">
                            <input autocomplete="off" id="wcjd-individual-position-above" type="radio" value="<?php echo WCJDOptions::DISPLAY_INDIVIDUAL_ABOVE; ?>"  name="<?php echo WCJDOptions::INDIVIDUAL_PLAYER_POSITION; ?>" <?php if ($this->options->individualPlayerPosition() === WCJDOptions::DISPLAY_INDIVIDUAL_ABOVE) echo 'checked="checked"'; ?>/>
                            Above product
                        </label>
                        <br/>
                        <label for="wcjd-individual-position-in">
                            <input autocomplete="off" id="wcjd-individual-position-in" type="radio" value="<?php echo WCJDOptions::DISPLAY_INDIVIDUAL_IN_SUMMARY; ?>" name="<?php echo WCJDOptions::INDIVIDUAL_PLAYER_POSITION; ?>" <?php if ($this->options->individualPlayerPosition() === WCJDOptions::DISPLAY_INDIVIDUAL_IN_SUMMARY) echo 'checked="checked"'; ?>/>
                            Inside product summary
                        </label>
                        <br/>
                        <label for="wcjd-individual-position-below">
                            <input autocomplete="off" id="wcjd-individual-position-below" type="radio" value="<?php echo WCJDOptions::DISPLAY_INDIVIDUAL_BELOW; ?>" name="<?php echo WCJDOptions::INDIVIDUAL_PLAYER_POSITION; ?>" <?php if ($this->options->individualPlayerPosition() === WCJDOptions::DISPLAY_INDIVIDUAL_BELOW) echo 'checked="checked"'; ?>/>
                            Below product
                        </label>
                        <br/>
                        <br/>
                        <label for="wcjd-individual-width">Width</label>
                        <input autocomplete="off" id="wcjd-individual-width" type="text" value="<?php echo $this->options->individualPlayerWidth(); ?>" name="<?php echo WCJDOptions::INDIVIDUAL_PLAYER_WIDTH; ?>" />
                        <label for="wcjd-individual-height">Height</label>
                        <input autocomplete="off" id="wcjd-individual-height" type="text" value="<?php echo $this->options->individualPlayerHeight(); ?>" name="<?php echo WCJDOptions::INDIVIDUAL_PLAYER_HEIGHT; ?>" />
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-display-individual-player').change(function() {
                                $('#wcjd-display-individual-player-position-wrap').toggle($(this).is(':checked'));
                            }).trigger('change');
                        })(jQuery);
                    </script>

                    <?php /*<div>
                         <label for="wcjd-footer-html">Individual Product Footer HTML</label>
                        <textarea id="wcjd-footer-html" name="<?php echo WCJDOptions::FOOTER_HTML; ?>"><?php echo $this->options->footerHtml(); ?></textarea>
                        <p class="submit">
                            <input id="wcjd-reset-footer-html" type="button" class="button-primary" value="<?php _e('Reset Footer HTML') ?>" />
                        </p>
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-reset-footer-html').click(function() {
                                $('#wcjd-footer-html').html(<?php echo json_encode($this->options->defaultFooterHtml()); ?>);
                            });
                        })(jQuery);
                    </script> */ ?>
                </div>
                <!-- Styling -->
                <div id="wcjd-options-general-styling">
                    <label for="wcjd-use-custom-css">
                        <input autocomplete="off" id="wcjd-use-custom-css" type="checkbox" value="1" name="<?php echo WCJDOptions::USE_CUSTOM_CSS; ?>" <?php if ($this->options->useCustomCss()) echo 'checked="checked"'; ?> />
                        Use custom CSS
                    </label>
                    <div class="wcjd-nested-elements" id="wcjd-custom-css-wrap" <?php if (!$this->options->useCustomCss()) 'style="display:none"'; ?> >
                        <textarea id="wcjd-custom-css" name="<?php echo WCJDOptions::CUSTOM_CSS; ?>"><?php echo $this->options->customCss(); ?></textarea>
                        <p class="submit">
                            <input id="wcjd-reset-custom-css" type="button" class="button-primary" value="<?php _e('Reset Custom CSS') ?>" />
                        </p>
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-use-custom-css').change(function() {
                                $('#wcjd-custom-css-wrap').toggle($(this).is(':checked'));
                            });
                            $('#wcjd-reset-custom-css').click(function() {
                                $('#wcjd-custom-css').html(<?php echo json_encode($this->options->defaultCss()); ?>);
                            });
                        })(jQuery);
                    </script>
                </div>

                <!-- Media Element Styling -->
                <div id="wcjd-options-audio-preview-styling">
                    <label for="wcjd-use-custom-media-element-css">
                        <input autocomplete="off" id="wcjd-use-custom-media-element-css" type="checkbox" value="1" name="<?php echo WCJDOptions::USE_CUSTOM_MEDIA_ELEMENT_CSS; ?>" <?php if ($this->options->useCustomMediaElementCss()) echo 'checked="checked"'; ?> />
                        Use custom Media Element CSS
                    </label>
                    <div class="wcjd-nested-elements" id="wcjd-custom-media-element-css-wrap" <?php if (!$this->options->useCustomMediaElementCss()) 'style="display:none"'; ?> >
                        <textarea id="wcjd-custom-media-element-css" name="<?php echo WCJDOptions::CUSTOM_MEDIA_ELEMENT_CSS; ?>"><?php echo $this->options->customMediaElementCss(); ?></textarea>
                        <p class="submit">
                            Use default:
                            <input id="wcjd-reset-custom-media-element-css" type="button" class="button-primary" value="<?php _e('Standard Media Element CSS') ?>" />
                            <input id="wcjd-reset-custom-media-element-single-button-css" type="button" class="button-primary" value="<?php _e('Single Button Media Element CSS') ?>" />
                        </p>
                    </div>
                    <script type="text/javascript">
                        (function($) {
                            $('#wcjd-use-custom-media-element-css').change(function() {
                                $('#wcjd-custom-media-element-css-wrap').toggle($(this).is(':checked'));
                            });
                            $('#wcjd-reset-custom-media-element-css').click(function() {
                                $('#wcjd-custom-media-element-css').html(<?php echo json_encode($this->options->defaultMediaElementCss()); ?>);
                            });
                            $('#wcjd-reset-custom-media-element-single-button-css').click(function() {
                                $('#wcjd-custom-media-element-css').html(<?php echo json_encode($this->options->defaultMediaElementSingleButtonCss()); ?>);
                            });
                        })(jQuery);
                    </script>
                </div>
            </div>

            <script type="text/javascript">
                jQuery(function() {
                    jQuery('#wcjd-options-tabs').tabs({
                        cookie: {
                            expires: 10
                        }
                    });
                });
            </script>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                <input id="wcjd-cancel" type="reset" class="button-secondary" value="Cancel" />
                <script type="text/javascript">
                    jQuery('#wcjd-cancel').click(function() {
                        window.location.reload(true);
                    })
                </script>
            </p>
        </form>
    </div>

    <div class="wcjd-settings-information">
        <a href="http://www.thestiz.com/?utm_source=wp-wcjd&utm_medium=admin-index&utm_content=stiz-logo&utm_campaign=wcjd" target="_blank" title="New Jersey's premier recording studio for hip-hop, rap and mixtape recording">
            <img src="<?php echo plugins_url('css/admin/logo-the-stiz.png', __FILE__.'/../../../../'); ?>" />
        </a>
        <h2>The Stiz - Audio for WooCommerce</h2>
        <p>
            The Stiz - Audio for WooCommerce is the brainchild of Mike Hemberger, who lives at <a target="_blank" href="http://thestiz.com//?utm_source=wcjd&utm_medium=admin-index&utm_content=thestiz&utm_campaign=wcjd">thestiz.com</a> and <a target="_blank" href="http://jivedigdesign.com//?utm_source=wcjd&utm_medium=admin-index&utm_content=jivedigdesign&utm_campaign=wcjd">jivedigdesign.com</a>, and uses Twitter.
            <br/>
            <br/>
            <a href="https://twitter.com/JiveDig" class="twitter-follow-button" data-show-count="false">Follow @JiveDig</a>
        </p>
        <hr/>
        <p>
            Plugin programming by by Michael Robinson, who lives at <a target="_blank" href="http://pagesofinterest.net/?utm_source=wp-wcjd&utm_medium=admin-index&utm_content=michael-robinson&utm_campaign=wcjd" title="Michael Robinson!">pagesofinterest.net</a>, and uses Twitter.
            <br/>
            <br/>
            <a href="https://twitter.com/pagesofinterest" class="twitter-follow-button" data-show-count="false">Follow @pagesofinterest</a>
        </p>
        <hr/>
        <p>
            The Stiz - Audio for WooCommerce uses <a target="_blank" href="http://mediaelementjs.com/">MediaElement</a>, created by John Dyer.
            <blockquote>
                <strong>MediaElement</strong>
                <br/>
                HTML5 &lt;video&gt; and &lt;audio&gt; made easy.
                <br/>
                One file. Any browser. Same UI.
            </blockquote>
            <br/>
            <a href="https://twitter.com/johndyer" class="twitter-follow-button" data-show-count="false">Follow @johndyer</a>
        </p>
    </div>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</div>


















