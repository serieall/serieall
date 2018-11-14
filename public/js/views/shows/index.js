$('.special.cards .image').dimmer({
    on: 'hover'
});

$(document).one('click', '.PaginateRow .pagination a', function (e) {
    e.preventDefault();

    let segment = '#LeftBlock .ui.basic.segment';

    getShows($(this).attr('href').split('page=')[1], segment);
});

function getShows(page, segment, channel, nationality, genre, tri ) {
    $(segment).addClass('loading');

    $.ajax({
        url : '/series/' + channel + '/' + nationality + '/' + genre + '/' + tri + '?page=' + page,
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
                let tri = $('.tri').dropdown('get value');
                if (nationality === "") {
                    nationality = 0
                }
                if (genre === "") {
                    genre = 0
                }
                if (tri === "") {
                    tri = 0
                }

                if (valChannel) {
                    getShows(1, segment, valChannel, genre, nationality, tri);
                } else {
                    getShows(1, segment, 0, genre, nationality, tri)
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
            onChange: function(valNationality) {
                const segment = '#LeftBlock .ui.basic.segment';
                let channel = $('.channels').dropdown('get value');
                let genre = $('.genres').dropdown('get value');
                let tri = $('.tri').dropdown('get value');

                if (channel === "") {
                    channel = 0
                }
                if (genre === "") {
                    genre = 0
                }
                if (tri === "") {
                    tri = 0
                }

                if (valNationality) {
                    getShows(1, segment, channel, genre, valNationality, tri);
                } else {
                    getShows(1, segment, channel, genre, 0, tri);
                }
            },
            clearable: true,
            saveRemoteData: false,
        });

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
            onChange: function(valGenre) {
                const segment = '#LeftBlock .ui.basic.segment';
                let nationality = $('.nationalities').dropdown('get value');
                let channel = $('.channels').dropdown('get value');
                let tri = $('.tri').dropdown('get value');

                if (channel === "") {
                    channel = 0
                }
                if (nationality === "") {
                    nationality = 0
                }
                if (tri === "") {
                    tri = 0
                }

                if (valGenre) {
                    getShows(1, segment, channel, valGenre, nationality, tri);
                } else {
                    getShows(1, segment, channel, 0, nationality, tri);
                }
            },
            clearable: true,
            saveRemoteData: false,
        })
    ;

    $('.tri')
        .dropdown({
            onChange: function(valTri) {
                const segment = '#LeftBlock .ui.basic.segment';
                let nationality = $('.nationalities').dropdown('get value');
                let channel = $('.channels').dropdown('get value');
                let genre = $('.genres').dropdown('get value');

                if (channel === "") {
                    channel = 0
                }
                if (genre === "") {
                    genre = 0
                }
                if (nationality === "") {
                    nationality = 0
                }

                if (valTri) {
                    getShows(1, segment, channel, genre, nationality, valTri);
                } else {
                    getShows(1, segment, channel, genre, nationality, 0);
                }
            },
            clearable: true,
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