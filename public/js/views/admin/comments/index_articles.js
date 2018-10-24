const defaultHtml = $('#comment').html();
const dropdownArticle = '#dropdownArticle';

$(document).ready(function() {
    initDropdownArticle();
});

function getComment(type, val) {
    const comment = '#comment';
    $(comment).addClass('loading');

    if(val) {
        $.ajax({
            url : '/admin/comments/' + type +'/'+ val,
            dataType: 'json'
        }).done(function (data) {
            // On insére le HTML
            $(comment).html(data);
            $(comment).removeClass('loading');
        }).fail(function () {
            alert('Le commentaire n\'a pas été chargé.');
            $(comment).removeClass('loading');
        });
    } else {
        $(comment).html(defaultHtml);
        $(comment).removeClass('loading');
    }
}

function initDropdownArticle() {
    $(dropdownArticle)
        .dropdown({
            apiSettings: {
                url: '/api/articles/list?name-lk=*{query}*'
            },
            fields: {
                remoteValues: "data",
                value: "id"
            },
            clearable: true,
            onChange: function(valShow) {
                if (valShow) {
                    getComment("Show", valShow);
                } else {
                    getComment("Show", null)
                }

                initDropdownSeason(valShow);
            }
        });
}