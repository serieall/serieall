$('.ui.modal.reaction').modal('attach events', '.writeReaction', 'show');
CKEDITOR.plugins.addExternal('spoiler', '/js/ckeditor/plugins/spoiler/plugin.js');
CKEDITOR.plugins.addExternal('wordcount', '/js/ckeditor/plugins/wordcount/plugin.js');
CKEDITOR.replace('reaction',
    {
        extraPlugins: 'spoiler,wordcount',
        customConfig: '/js/ckeditor/config.js',
        wordcount: {
            showCharCount: true,
            showWordCount: false,
            showParagraphs: false
        }
    });

// Submission
$(document).on('submit', '#formReaction', function (e) {
    e.preventDefault();

    var messageLength = CKEDITOR.instances['reaction'].getData().replace(/<[^>]*>|\n|&nbsp;/g, '').length;
    var nombreCaracAvis = '20';

    if (messageLength < nombreCaracAvis) {
        $('.nombreCarac').removeClass("hidden");
    }
    else {
        $('.submit').addClass("loading");

        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json"
        })
            .done(function () {
                window.location.reload(false);
            })
            .fail(function (data) {
                $('.submit').removeClass("loading");

                $.each(data.responseJSON.errors, function (key, value) {
                    var input = 'input[class="' + key + '"]';

                    $(input + '+div').text(value);
                    $(input + '+div').removeClass("hidden");
                    $(input).parent().addClass('error');
                });
            });
    }
});
