let lastComments = $('#LastComments');

//Pagination
lastComments.on('click', '.pagination a', function (e) {
    e.preventDefault();

    getComments($(this).attr('href').split('page=')[1]);
    $('#ListAvis').addClass('loading');
});

//Toggle affichage des réactions
lastComments.on('click', '.showReactions',function() {
    $(this).parent().next('.divReactions').slideToggle("fast");
    $(this).toggleText(
        '<div class="visible content">Voir les réponses</div><div class="hidden content"><i class="down arrow icon"></i></div>',
        '<div class="visible content">Cacher les réponses</div><div class="hidden content"><i class="up arrow icon"></i></div>'
    );
});

//Ecriture des avis
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


//Ecriture des reactions
var editorReaction = CKEDITOR.instances.reaction;
if (editorReaction) {
    editorReaction.destroy(true);
}


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

$('.ui.modal.reaction').modal('attach events', '.writeReaction', 'show');
lastComments.on('click', '.writeReaction', function (e) {
    e.preventDefault();
    IDButton = $(this).attr('id');
    username = $(this).attr('username');
    $('.object_parent_id').val(IDButton);
    $('.answerUsername').text(username);
});


//Utils functions
function getComments(page) {
    $.ajax({
        url : '?page=' + page,
        dataType: 'json'
    }).done(function (data) {
        // On insére le HTML
        let lastComments = $('#LastComments');
        lastComments.html(data);

        // On recharge les spoilers
        $.getScript('/js/spoiler/spoiler.js');

        //Rechargement des réactions
        $('.ui.modal.reaction').modal('attach events', '.writeReaction', 'show');

        location.hash = page;
        $('#ListAvis').removeClass('loading');
    }).fail(function () {
        alert('Les commentaires n\'ont pas été chargés.');
        $('#LastComments').removeClass('loading');
    });
}