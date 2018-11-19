$(document).ready(function() {
    $(".shows_moment").slick({
        slidesToShow: 5,
        slidesToScroll: 5,
        infinite: true,
        variableWidth: false,
        responsive: [
            {
                breakpoint: 1650,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 1210,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 628,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 450,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });

    $(".last_added_shows").slick({
        slidesToShow: 8,
        slidesToScroll: 4,
        infinite: true,
        variableWidth: false,
        responsive: [
            {
                breakpoint: 1650,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 1210,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 628,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 450,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]
    });
});

$(document).one('click', '.label', function(e) {
    const segment = '.placeholder.segment';
    $(segment).addClass('loading');

    filter = $(this).attr('id');

    $.ajax({
        url : '?filter_home=' + filter,
        dataType: 'json'
    }).done(function (data) {
        // On insére le HTML
        $(segment).html(data);

        $.getScript('/js/views/pages/home.js');

        $(segment).removeClass('loading');
    }).fail(function () {
        alert('Les séries n\'ont pas été chargées.');
        $(segment).removeClass('loading');
    });
});