const defaultHtml = $('#show').html();
const dropdownShow = '#dropdownShow';

$(document).ready(function() {
    initDropdownShow();
});

function getShow(val) {
    const show = '#show';
    $(show).addClass('loading');

    if(val) {
        $.ajax({
            url : '/admin/shows/index/' + val,
            dataType: 'json'
        }).done(function (data) {
            // On insére le HTML
            $(show).html(data);
            $(show).removeClass('loading');
        }).fail(function () {
            alert('La série n\'a pas été chargée.');
            $(show).removeClass('loading');
        });
    } else {
        $(show).html(defaultHtml);
        $(show).removeClass('loading');
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
                    getShow(valShow);
                } else {
                    getShow(null)
                }
            }
        });
}