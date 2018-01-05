<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
<script src="/spoiler/spoiler.js"></script>

<script>
    $(document).ready(function() {
        $('#footer .icon').hover(function () {
            $(this).transition('tada');
        }, function () {
        });

        $('#click-login').on('click', function(){
            $('#login')
                .modal('show')
            ;
        });

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

        $('#showDropdown')
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

        $(document).on('submit', '#formLogin', function(e) {
            e.preventDefault();

            $('input+small').text('');
            $('input').parent().removeClass('has-error');

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            })
                .done(function(data) {
                    $('.alert-success').removeClass('hidden');
                    $('#myModal').modal('hide');
                })
                .fail(function(data) {
                    $.each(data.responseJSON, function (key, value) {
                        var input = '#formRegister input[name=' + key + ']';
                        $(input + '+small').text(value);
                        $(input).parent().addClass('has-error');
                    });
                });
        });

    })
</script>

@yield('scripts')