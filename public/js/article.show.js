$(document).ready(function() {
    $('.ui.sticky')
        .sticky({
            context: "#segmentLeft",
            offset: 60
        });

    //Listener for reaction show/hide button
    $('#LastComments').on('click', '.showReactions',function() {
        $(this).parent().next('.divReactions').slideToggle("fast");
        $(this).toggleText(
            '<div class="visible content">Voir les réponses</div><div class="hidden content"><i class="down arrow icon"></i></div>',
            '<div class="visible content">Cacher les réponses</div><div class="hidden content"><i class="up arrow icon"></i></div>'
        );
    });

    $("a#goToComments").click(function(){
        $('html, body').animate({
            scrollTop: $( $(this).attr('href') ).offset().top
        }, 1000);
    });
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();

    getCommentsFiche($(this).attr('href').split('page=')[1]);
    $('#LastComments').addClass('loading');
});

$.fn.extend({
    toggleText: function(a, b){
        return this.html(this.html() === b ? a : b);
    }
});

function getCommentsFiche(page) {
    var lastComments = '#divLastComments';
    $.ajax({
        url : '?page=' + page,
        dataType: 'json'
    }).done(function (data) {
        // On insére le HTML
        $(lastComments).html(data);

        // On recharge les spoilers et on remonte en haut de la page.
        $('html, body').animate({scrollTop:$('#ListAvis').offset().top}, 'slow');

        // $.getScript('/js/article.show.js');
        $.getScript('/js/spoiler/spoiler.js');

        $(lastComments).removeClass('loading');
    }).fail(function () {
        alert('Les commentaires n\'ont pas été chargés.');
        $(lastComments).removeClass('loading');
    });
}

$('.ui.modal.avis').modal('attach events', '.ui.button.WriteAvis', 'show');
$('.ui.fluid.selection.dropdown').dropdown({forceSelection: true});
var editorAvis = CKEDITOR.instances.avis;
if (editorAvis) {
    editorAvis.destroy(true);
}
CKEDITOR.plugins.addExternal( 'spoiler', '/js/ckeditor/plugins/spoiler/plugin.js' );
CKEDITOR.plugins.addExternal( 'wordcount', '/js/ckeditor/plugins/wordcount/plugin.js' );
CKEDITOR.replace( 'avis' ,
    {
        extraPlugins: 'spoiler,wordcount',
        customConfig:'/js/ckeditor/config.js',
        wordcount: {
            showCharCount: true,
            showWordCount: false,
            showParagraphs: false
        }
    });


var editorReaction = CKEDITOR.instances.reaction;
if (editorReaction) {
    editorReaction.destroy(true);
}

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

$('.ui.button.writeReaction').click(function (e) {
    e.preventDefault();
    IDButton = $(this).attr('id');
    username = $(this).attr('username');
    $('.object_parent_id').val(IDButton);
    $('.answerUsername').text(username);
});
