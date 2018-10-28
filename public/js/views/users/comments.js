$('.ui.modal').modal();

$(document).ready( function() {
    $('.readAvis').click(function () {
        modal = $(this).attr('modal');

        $('#' + modal).modal('show');
    });
});

$(document).one('click', '#paginateShow .pagination a', function (e) {
    e.preventDefault();
    const segment = '#cardsShows';

    getComments($(this).attr('href').split('show=')[1], 'show', segment);
});

$(document).one('click', '.filterShow .item', function (e) {
    e.preventDefault();
    const segment = '#cardsShows';
    const filter = '.filterShow';

    getComments(1, 'show', segment, filter);
});

$(document).one('click', '#paginateSeason .pagination a', function (e) {
    e.preventDefault();
    const segment = '#cardsSeasons';
    const filter = '.filterSeason';

    getComments($(this).attr('href').split('season=')[1], 'season', segment, filter);
});

$(document).one('click', '.filterSeason .item', function (e) {
    e.preventDefault();
    const segment = '#cardsSeasons';
    const filter = '.filterSeason';

    getComments(1, 'season', segment, filter);
});

$(document).one('click', '#paginateEpisode .pagination a', function (e) {
    e.preventDefault();
    const segment = '#cardsEpisodes';
    const filter = '.filterEpisode';

    getComments($(this).attr('href').split('episode=')[1], 'episode', segment, filter);
});

$(document).one('click', '.filterEpisode .item', function (e) {
    e.preventDefault();
    const segment = '#cardsEpisodes';
    const filter = '.filterEpisode';

    getComments(1, 'episode', segment, filter);
});

function getComments(page, action, segment, filter) {
    $(segment).addClass('loading');

    let filterURL;
    let triURL;
    let valueFilter = $(filter).dropdown('get value');

    valueFilter[0] === "" ? filterURL = 10 : filterURL = valueFilter[0];
    valueFilter[1] === "" ? triURL = 10 : triURL = valueFilter[1];

    $.ajax({
        url : '/profil/admin/avis/' + action + '/' + filterURL + '/' + triURL + '?' + action + '=' + page,
        dataType: 'json'
    }).done(function (data) {
        // On insére le HTML
        $(segment).html(data);

        $.getScript('/js/views/users/comments.js');

        $(segment).removeClass('loading');
    }).fail(function () {
        alert('Les avis n\'ont pas été chargés.');
        $(segment).removeClass('loading');
    });
}