const defaultHtml = $('#comment').html();
const dropdownShow = '#dropdownShow';
const dropdownSeason = '#dropdownSeason';
const dropdownEpisode = '#dropdownEpisode';

$(document).ready(function() {
    initDropdownShow();
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

function initDropdownShow() {
    $(dropdownShow)
        .dropdown({
            apiSettings: {
                url: '/api/shows/list?name-lk=*{query}*'
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

function initDropdownSeason(valShow) {
    $(dropdownSeason)
        .dropdown({
            apiSettings: {
                url: '/api/seasons/show/'+ valShow
            },
            fields: {
                remoteValues: "data",
                value: "id"
            },
            clearable: true,
            onChange: function(valSeason) {
                initDropdownEpisode(valSeason, valShow);

                if (valSeason) {
                    getComment("Season", valSeason);
                } else if (valShow) {
                    getComment("Show", valShow);
                }
            }
        })
        .dropdown('clear');
}

function initDropdownEpisode(valSeason, valShow) {
    $(dropdownEpisode)
        .dropdown({
            apiSettings: {
                url: '/api/episodes/seasons/' + valSeason
            },
            fields: {
                remoteValues: "data",
                value: "id",
                name: "title"
            },
            clearable: true,
            onChange: function(valEpisode) {
                if(valEpisode){
                    getComment("Episode", valEpisode);
                } else if (valSeason) {
                    getComment("Season", valSeason);
                } else if (valShow) {
                    getComment("Show", valShow);
                }
            }
        })
        .dropdown('clear');
}