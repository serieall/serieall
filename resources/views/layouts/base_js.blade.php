<script src="/js/libs/all_js.js"></script>
<script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
<script src='/js/libs/TweenMax.min.js' async></script>
<script src="/js/spoiler/spoiler.js" async></script>
<script src="/js/libs/moment.min.js" async></script>

<script src="/js/libs/fr.js" async></script>
<script src="{{ asset('js/share.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.sidebarIcon').click(function() {
           $('.sidebar.menu').sidebar('toggle');
        });

        $('#footer .icon').hover(function () {
            $(this).transition('tada');
        }, function () {
        });

        $('.coupled.modal').modal({
            allowMultiple: true
        })
        ;

        $('.clickLogin').on('click', function(){
            $('#loginModal').modal({
                transition: 'drop down'
            })
                .modal('show')
            ;
        });

        $('.clickRegister').on('click', function(){
            $('#registerModal').modal({
                transition: 'drop down'
            })
                .modal('show')
            ;
        });

        @if(Route::current()->getName() == 'inscription')
            $('.second.modal').modal('show');
        @endif

        $('.second.modal')
            .modal({
                transition: 'fly left'
            })
            .modal('attach events', '#goToSecondModal')

        ;

        $('.dropdown')
            .dropdown()
        ;

        $('.message .close')
            .on('click', function () {
                $(this)
                    .closest('.message')
                    .transition('fade')
                ;
            })
        ;

        $('.showDropdown')
            .search({
                apiSettings: {
                    url: '/api/shows/search?_q={query}'
                },
                fields: { results: "data", title: "name", url: "url" },
                selectFirstResult: true,
                minCharacters: 1,
                maxResults: 40
            });

        $('.ui.inline.cookie.nag')
            .nag({
                key      : 'accepts-cookies',
                value    : true
            })
        ;

        $('.clickToConnect').click(function() {
            $('#login')
                .modal('show')
            ;
        });

        $(document).on('submit', '#formLogin', function(e) {
            e.preventDefault();
            var buttonSubmit = '#formLogin .submit';

            $(buttonSubmit).addClass("loading");

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            })
                .done(function(data) {
                    console.log(data.activated);
                    if (!data.activated) {
                        $('#LoginHeaderActivated').removeClass('hidden');
                        $(buttonSubmit).removeClass("loading");
                    } else if (data.suspended) {
                        $('#LoginHeaderSuspended').removeClass('hidden');
                        $(buttonSubmit).removeClass("loading");
                    } else {
                        $('#login').modal('hide');
                        window.location.reload(false);
                    }
                })
                .fail(function(data) {
                    $(buttonSubmit).removeClass("loading");

                    $.each(data.responseJSON.errors, function (key, value) {
                        var input = '#formLogin input[name=' + key + ']';

                        $(input + '+div').removeClass('hidden');
                        $(input + '+div').text(value);

                        $(input).parent().addClass('error');
                    });
                });
        });

        $(document).on('submit', '#formRegister', function(e) {
            e.preventDefault();
            var buttonSubmit = '#formRegister .submit';
            var positiveMessage = '#registerModal .positive.message';
            var captchaError = '#formRegister .captchaError';

            // Reinitialiser tous les messages d'erreur
            $('#formRegister input+div').addClass('hidden');
            $('#formRegister input').parent().removeClass('error');

            $(buttonSubmit).addClass("loading");

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            })
                .done(function() {
                    $(buttonSubmit).removeClass("loading");
                    $(positiveMessage).removeClass('hidden');
                })
                .fail(function(data) {
                    $(buttonSubmit).removeClass("loading");

                    $.each(data.responseJSON.errors, function (key, value) {
                        var input = '#formRegister input[name=' + key + ']';

                        $(input + '+div').removeClass('hidden');
                        $(input + '+div').text(value);

                        $(input).parent().addClass('error');

                        if(key = 'g-recaptcha-response'){
                            $(captchaError).text(value);
                            $(captchaError).removeClass('hidden');
                        }
                    });
                });
        });

        $('.notifications.dropdown').dropdown({
            useLabels: false
        });

        $('.notifications.menu .circle.icon').click(function(e){
            e.preventDefault();

            icon = $(this);
            nb_notif = +($('.notification.label').text());

            $.ajax({
                method: 'post',
                url: '/notification',
                data: {'_token': "{{csrf_token()}}" , 'notif_id': $(this).attr('id'), 'markUnread' : true},
                dataType: "json"
            }).done(function() {
                $(icon).toggleClass('outline');
                if($(icon).hasClass('outline')) {
                    if(nb_notif == 1) {
                        $('.notification.label').hide();
                        $('.notification.label').text(nb_notif - 1);
                    } else {
                        $('.notification.label').text(nb_notif - 1);
                    }
                } else {
                    if(nb_notif == 0) {
                        $('.notification.label').show();
                        $('.notification.label').text(nb_notif + 1);
                    } else {
                        $('.notification.label').text(nb_notif + 1);
                    }
                }
            });
        });

        $('.notifications.menu .item a').click(function(e){
            e.preventDefault();

            icon = $(this).prev();
            link = $(this);
            nb_notif = +($('.notification.label').text());

            $.ajax({
                method: 'post',
                url: '/notification',
                data: {'_token': "{{csrf_token()}}" , 'notif_id': icon.attr('id'), 'markUnread' : false},
                dataType: "json"
            }).done(function() {
                window.location.href = $(link).attr('href');
            });


        });

        $('.markAllasRead').click(function(e) {
            e.preventDefault();

            $.ajax({
                method: 'post',
                url: '/notifications',
                data: {'_token': "{{csrf_token()}}"},
                dataType: "json"
            }).done(function() {
                $('.notifications.menu .circle.icon').toggleClass('outline');
                $('.notification.label').hide();
                $('.notification.label').text(0);
                $('.markAllasRead').hide();
            });
        });

        $('#reload_captcha').click(function(event){
            $('#captcha_image').attr('src', $('#captcha_image').attr('src')+'{{ captcha_src() }}');
        });
    })
</script>

@stack('scripts')