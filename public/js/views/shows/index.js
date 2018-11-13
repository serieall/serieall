$('.special.cards .image').dimmer({
    on: 'hover'
});

$(document).one('click', '.PaginateRow .pagination a', function (e) {
    e.preventDefault();

    let segment = '#LeftBlock .ui.basic.segment';

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
    $('.channels')
        .dropdown({
            apiSettings: {
                url: '/api/channels/list?name-lk=*{query}*',
                beforeSend: function(settings) {
                    if (typeof(Storage) !== "undefined") {
                        let sStorage = window.sessionStorage;
                        sStorage.removeItem("/api/channels/list?name-lk=**");

                        return settings;
                    }
                }
            },
            fields: {
                remoteValues: "data",
                value: "name"
            },
            saveRemoteData: false,
        })
    ;

    $('.nationalities')
        .dropdown({
            apiSettings: {
                url: '/api/nationalities/list?name-lk=*{query}*',
                beforeSend: function(settings) {
                    if (typeof(Storage) !== "undefined") {
                        let sStorage = window.sessionStorage;
                        sStorage.removeItem("/api/nationalities/list?name-lk=**");

                        return settings;
                    }
                }
            },
            fields: {
                remoteValues: "data",
                value: "name"
            },
            saveRemoteData: false,
        })
    ;

    $('.genres')
        .dropdown({
            apiSettings: {
                url: '/api/genres/list?name-lk=*{query}*',
                beforeSend: function(settings) {
                    if (typeof(Storage) !== "undefined") {
                        let sStorage = window.sessionStorage;
                        sStorage.removeItem("/api/genres/list?name-lk=**");

                        return settings;
                    }
                }
            },
            fields: {
                remoteValues: "data",
                value: "name"
            },
            saveRemoteData: false,
        })
    ;
});