const defaultHtml = $('#user').html();
const dropdownUser = '#dropdownUser';

$(document).ready(function() {
    initDropdownUser();
});

function getUser(val) {
    const user = '#user';
    $(user).addClass('loading');

    if(val) {
        $.ajax({
            url : '/admin/users/index/' + val,
            dataType: 'json'
        }).done(function (data) {
            // On insére le HTML
            $(user).html(data);
            $(user).removeClass('loading');
        }).fail(function () {
            alert('L\'utilisateur n\'a pas été chargé.');
            $(user).removeClass('loading');
        });
    } else {
        $(user).html(defaultHtml);
        $(user).removeClass('loading');
    }
}

function initDropdownUser() {
    $(dropdownUser)
        .dropdown({
            apiSettings: {
                url: '/api/users/list?username-lk=*{query}*'
            },
            fields: {
                remoteValues: "data",
                name: "username",
                value: "id"
            },
            clearable: true,
            onChange: function(valUser) {
                if (valUser) {
                    getUser(valUser);
                } else {
                    getUser(null)
                }
            }
        });
}