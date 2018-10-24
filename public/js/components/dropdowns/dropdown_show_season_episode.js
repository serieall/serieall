const dropdownShow = '#dropdownShow';
const dropdownSeason = '#dropdownSeason';
const dropdownEpisode = '#dropdownEpisode';

$(document).ready(function() {
    initDropdownShow();
});

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
            }
        })
        .dropdown('clear');
}

function initDropdownEpisode(valSeason) {
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
        })
        .dropdown('clear');
}