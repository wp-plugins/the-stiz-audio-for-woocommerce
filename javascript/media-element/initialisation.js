(function($, options) {

    options = $.extend({}, {
        plugins: [
            'flash',
            'silverlight'
        ]
    }, options);

    /**
     * @type {Object} Options specific to preview audio elements
     */
    var previewOptions = $.extend({}, options, {
        'audioWidth': options['the-stiz-preview-width'],
        'audioHeight': options['the-stiz-preview-height']
    });

    /**
     * @type {Object} Options specific to individual product page audio elements
     */
    var individualOptions = $.extend({}, options, {
        'audioWidth': options['the-stiz-individual-width'],
        'audioHeight': options['the-stiz-individual-height']
    });

	if ($('audio.wcjd-audio-preview').length) $('audio.wcjd-audio-preview').mediaelementplayer(previewOptions);
    if ($('audio.wcjd-audio-individual').length) $('audio.wcjd-audio-individual').mediaelementplayer(individualOptions);
})(jQuery, wcjdAudioPreviewOptions);
