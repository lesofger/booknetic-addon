(function ($) {
    const $document = $(document);

    $document.ready(function () {
        const $eventColor = $('#event-color');
        const $saveButton = $('.settings-save-btn');
        const $eventContent = $('#event-content');
        const defaultStyle = $('#defaultCalendar');

        booknetic.summernote(
            $eventContent,
            [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['codeview']],
                ['height', ['height']],
            ],
            eventContentShortCodesObject
        );

        if (defaultStyle.is(':checked')) {
            $eventContent.summernote('disable');
        };

        $eventColor.select2({
            theme: 'bootstrap',
            placeholder: booknetic.__('Select color'),
        });

        $saveButton.on('click', function () {
            const eventContent = booknetic.summernoteReplace($eventContent, true);

            const plainText = $('<div>').html(eventContent).text().trim();

            if (plainText.length === 0 && !defaultStyle.is(':checked')) {
                booknetic.toast(booknetic.__('Please enter event content'), 'unsuccess');
                return;
            }

            const params = {
                appointmentCardColor: $eventColor.val(),
                eventContent,
                shouldUseDefaultStyling: defaultStyle.is(':checked') ? 'on' : 'off',
            }

            booknetic.ajax('save_calendar_settings', params, function () {
                booknetic.toast(booknetic.__('saved_successfully'), 'success');
            });
        });

        defaultStyle.on('change', function () {
            if ($(this).is(':checked')) {
                $eventContent.summernote('disable');
            } else {
                $eventContent.summernote('enable');
            }
        });
    });

})(jQuery);