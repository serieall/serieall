
    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                getComments(page);
            }
        }
    });

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (e) {
            getComments($(this).attr('href').split('page=')[1]);
            e.preventDefault();
            $('#ListAvis').addClass('loading');
        });
    });

    function getComments(page) {
        $.ajax({
            url : '?page=' + page,
            dataType: 'json'
        }).done(function (data) {
            // On insére le HTML
            $('#LastComments').html(data);

            // On recharge les spoilers et on remonte en haut de la page.
            $.getScript('/js/spoiler/spoiler.js');
            $('html, body').animate({scrollTop:$('#ListAvis').offset().top}, 'slow');//return false;

            location.hash = page;
            $('#ListAvis').removeClass('loading');
        }).fail(function () {
            alert('Les commentaires n\'ont pas été chargés.');
            $('#ListAvis').removeClass('loading');
        });
    }