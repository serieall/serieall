<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<script src="/js/ckeditor/ckeditor.js"></script>
<script src="/spoiler/spoiler.js"></script>

<script>
    $(document).ready(function() {
        $('#footer .icon').hover(function () {
            $(this).transition('tada');
        }, function () {
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
    })
</script>

@yield('scripts')