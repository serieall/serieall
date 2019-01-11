InProgressDropdown = '#InProgressDropdown';
OnBreakDropdown = '#OnBreakDropdown';
CompletedDropdown = '#CompletedDropdown';
AbandonedDropdown = '#AbandonedDropdown';
ToSeeDropdown = '#ToSeeDropdown';

InProgressForm = '#InProgressForm';
OnBreakForm = '#OnBreakForm';
CompletedForm = '#CompletedForm';
AbandonedForm = '#AbandonedForm';
ToSeeForm = '#ToSeeForm';

InProgressBox = '#InProgressBox';
OnBreakBox = '#OnBreakBox';
CompletedBox = '#CompletedBox';
AbandonedBox = '#AbandonedBox';
ToSeeBox = '#ToSeeBox';

InProgressMessage = '#InProgressMessage';
OnBreakMessage = '#OnBreakMessage';
CompletedMessage = '#CompletedMessage';
AbandonedMessage = '#AbandonedMessage';
ToSeeMessage = '#ToSeeMessage';

$(document).ready(function() {
    $(InProgressDropdown).dropdown({
        apiSettings: {
            url: '/api/shows/list?name-lk=*{query}*',
        },
        fields: {
            remoteValues: 'data',
            value: 'id',
        },
        clearable: true
    });

    $(OnBreakDropdown).dropdown({
        apiSettings: {
            url: '/api/shows/list?name-lk=*{query}*',
        },
        fields: {
            remoteValues: 'data',
            value: 'id',
        },
        clearable: true
    });

    $(CompletedDropdown).dropdown({
        apiSettings: {
            url: '/api/shows/abandoned/list?name-lk=*{query}*',
        },
        fields: {
            remoteValues: 'data',
            value: 'id',
        },
        clearable: true
    });

    $(ToSeeDropdown).dropdown({
        apiSettings: {
            url: '/api/shows/list?name-lk=*{query}*',
        },
        fields: {
            remoteValues: 'data',
            value: 'id',
        },
        clearable: true
    });

    $(AbandonedDropdown).dropdown({
        apiSettings: {
            url: '/api/shows/list?name-lk=*{query}*',
        },
        fields: {
            remoteValues: 'data',
            value: 'id',
        },
        clearable: true
    });

    function reloadBox(form, box, message) {
        $(message).text('');
        $(message).addClass("hidden");

        $.ajax({
            method: $(form).attr('method'),
            url: $(form).attr('action'),
            data: $(form).serialize(),
            dataType: "json"
        }).done(function (data) {
            // On insére le HTML
            $(box).html(data);

            $(box).removeClass('loading');
        }).fail(function () {
            $(message).text('Impossible de modifier le statut de la série. Veuillez réessayer.');
            $(message).removeClass("hidden");

            $(box).removeClass('loading');
        });
    }

    $(document).on('submit', '#InProgressForm', function(e) {
        e.preventDefault();
        // Clear all other dropdowns
        $(OnBreakDropdown).dropdown('clear');
        $(CompletedDropdown).dropdown('clear');
        $(ToSeeDropdown).dropdown('clear');
        $(AbandonedDropdown).dropdown('clear');

        // Reload all boxes
        reloadBox(this, InProgressBox, InProgressMessage);
        reloadBox(OnBreakForm, OnBreakBox, OnBreakMessage);
        reloadBox(CompletedForm, CompletedBox, CompletedMessage);
        reloadBox(ToSeeForm, ToSeeBox, ToSeeMessage);
        reloadBox(AbandonedForm, AbandonedBox, AbandonedMessage);
        $(InProgressDropdown).dropdown('clear');
    });

    $(document).on('submit', '#OnBreakForm', function(e) {
        e.preventDefault();

        // Clear all other dropdowns
        $(InProgressDropdown).dropdown('clear');
        $(CompletedDropdown).dropdown('clear');
        $(ToSeeDropdown).dropdown('clear');
        $(AbandonedDropdown).dropdown('clear');

        // Reload all boxes
        reloadBox(this, OnBreakBox, OnBreakMessage);
        reloadBox(InProgressForm, InProgressBox, InProgressMessage);
        reloadBox(CompletedForm, CompletedBox, CompletedMessage);
        reloadBox(ToSeeForm, ToSeeBox, ToSeeMessage);
        reloadBox(AbandonedForm, AbandonedBox, AbandonedMessage);
        $(OnBreakDropdown).dropdown('clear');
    });

    $(document).on('submit', '#CompletedForm', function(e) {
        e.preventDefault();

        // Clear all other dropdowns
        $(InProgressDropdown).dropdown('clear');
        $(OnBreakDropdown).dropdown('clear');
        $(ToSeeDropdown).dropdown('clear');
        $(AbandonedDropdown).dropdown('clear');

        // Reload all boxes
        reloadBox(this, CompletedBox, CompletedMessage);
        reloadBox(InProgressForm, InProgressBox, InProgressMessage);
        reloadBox(OnBreakForm, OnBreakBox, OnBreakMessage);
        reloadBox(ToSeeForm, ToSeeBox, ToSeeMessage);
        reloadBox(AbandonedForm, AbandonedBox, AbandonedMessage);
        $(CompletedDropdown).dropdown('clear');
    });

    $(document).on('submit', '#ToSeeForm', function(e) {
        e.preventDefault();

        // Clear all other dropdowns
        $(InProgressDropdown).dropdown('clear');
        $(OnBreakDropdown).dropdown('clear');
        $(CompletedDropdown).dropdown('clear');
        $(AbandonedDropdown).dropdown('clear');

        // Reload all boxes
        reloadBox(this, ToSeeBox, ToSeeMessage);
        reloadBox(InProgressForm, InProgressBox, InProgressMessage);
        reloadBox(OnBreakForm, OnBreakBox, OnBreakMessage);
        reloadBox(CompletedForm, CompletedBox, CompletedMessage);
        reloadBox(AbandonedForm, AbandonedBox, AbandonedMessage);
        $(ToSeeDropdown).dropdown('clear');
    });

    $(document).on('submit', '#AbandonedForm', function(e) {
        e.preventDefault();

        // Clear all other dropdowns
        $(InProgressDropdown).dropdown('clear');
        $(OnBreakDropdown).dropdown('clear');
        $(CompletedDropdown).dropdown('clear');
        $(ToSeeDropdown).dropdown('clear');

        // Reload all boxes
        reloadBox(this, AbandonedBox, AbandonedMessage);
        reloadBox(InProgressForm, InProgressBox, InProgressMessage);
        reloadBox(OnBreakForm, OnBreakBox, OnBreakMessage);
        reloadBox(CompletedForm, CompletedBox, CompletedMessage);
        reloadBox(ToSeeForm, ToSeeBox, ToSeeMessage);
        $(AbandonedDropdown).dropdown('clear');
    });

    $(document).on('submit', '.ui.form.delete', function(e) {
        e.preventDefault();

        console.log(this);
        // Clear all other dropdowns
        $(InProgressDropdown).dropdown('clear');
        $(OnBreakDropdown).dropdown('clear');
        $(InProgressDropdown).dropdown('clear');
        $(CompletedDropdown).dropdown('clear');
        $(ToSeeDropdown).dropdown('clear');

        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json"
        }).fail(function () {
            alert('La série n\'a pas pu être supprimée.');
        });

        // Reload all boxes
        reloadBox(InProgressForm, InProgressBox);
        reloadBox(OnBreakForm, OnBreakBox);
        reloadBox(CompletedForm, CompletedBox);
        reloadBox(ToSeeForm, ToSeeBox);
        reloadBox(AbandonedForm, AbandonedBox);
    });
});