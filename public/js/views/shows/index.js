$('.special.cards .image').dimmer({
    on: 'hover'
});

$(document).one('click', '.PaginateRow .pagination a', function (e) {
    e.preventDefault();

    let segment = '#LeftBlock .ui.segment';

    getShows($(this).attr('href').split('page=')[1], segment);
});

function getShows(page, segment) {
    $(segment).addClass('loading');

    $.ajax({
        url : '/series?page=' + page,
        dataType: 'json'
    }).done(function (data) {
        // On insére le HTML
        $(segment).html(data);

        $.getScript('/js/views/shows/index.js');

        $(segment).removeClass('loading');
    }).fail(function () {
        alert('Les séries n\'ont pas été chargées.');
        $(segment).removeClass('loading');
    });
}

$(document).ready(function() {
    $('.ui.fluid.search.selection.dropdown.channels')
        .dropdown({
            apiSettings: {
                url: '/api/channels/list?name-lk=*{query}*'
            },
            fields: {
                remoteValues: "data",
                value: "name"
            },
        })
    ;

    $('.ui.fluid.search.selection.dropdown.nationalities')
        .dropdown({
            apiSettings: {
                url: '/api/nationalities/list?name-lk=*{query}*'
            },
            fields: {
                remoteValues: "data",
                value: "name"
            }
        })
    ;
});