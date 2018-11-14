$('.special.cards .image').dimmer({
    on: 'hover'
});

$(document).one('click', '.PaginateRow .pagination a', function (e) {
    e.preventDefault();

    let segment = '#LeftBlock .ui.basic.segment';

    getShows($(this).attr('href').split('page=')[1], segment);
});

function getShows(page, segment, channel, nationality, genre ) {
    $(segment).addClass('loading');

    $.ajax({
        url : '/series/' + channel + '/' + nationality + '/' + genre + '?page=' + page,
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
            onChange: function(valChannel) {
                const segment = '#LeftBlock .ui.basic.segment';
                let nationality = $('.nationalities').dropdown('get value');
                let genre = $('.genres').dropdown('get value');
                if (nationality === "") {
                    nationality = 0
                }
                if (genre === "") {
                    genre = 0
                }

                if (valChannel) {
                    getShows(1, segment, valChannel, nationality, genre);
                } else {
                    getShows(1, segment, 0, nationality, genre)
                }
            },
            clearable: true,
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

    $('.restore.button').on('click', function (e) {
       e.preventDefault();

       $('.genres').dropdown('restore defaults');
       $('.nationalities').dropdown('restore defaults');
       $('.channels').dropdown('restore defaults');
       $('.tri').dropdown('restore defaults')
    });
});