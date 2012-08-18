(function($, options) {
    options = $.extend({}, {
        plugins: [
            'flash',
            'silverlight'
        ]
    }, options);
	if ($('audio.wcjd-audio-preview').length) $('audio.wcjd-audio-preview').mediaelementplayer(options);
})(jQuery, wcjdAudioPreviewOptions);
