const defaultHtml = $('#article').html();
const dropdownArticle = '#dropdownArticle';

$(document).ready(function() {
    initDropdownArticle();
});

function getArticle(val) {
    const article = '#article';
    $(article).addClass('loading');

    if(val) {
        $.ajax({
            url : '/admin/articles/index/' + val,
            dataType: 'json'
        }).done(function (data) {
            // On insére le HTML
            $(article).html(data);
            $(article).removeClass('loading');
        }).fail(function () {
            alert('L\'article n\'a pas été chargé.');
            $(article).removeClass('loading');
        });
    } else {
        $(article).html(defaultHtml);
        $(article).removeClass('loading');
    }
}

function initDropdownArticle() {
    $(dropdownArticle)
        .dropdown({
            apiSettings: {
                url: '/api/articles/list?name-lk={query}&_limit=10'
            },
            fields: {
                remoteValues: "data",
                value: "id"
            },
            clearable: true,
            onChange: function(valArticle) {
            if (valArticle) {
                    getArticle(valArticle);
                } else {
                    getArticle(null)
                }
            }
        });
}