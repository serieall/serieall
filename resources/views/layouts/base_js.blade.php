<script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.16/js/dataTables.semanticui.min.js"></script>
<script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
<script src="/spoiler/spoiler.js"></script>

<button id="feedback-form">Feedback</button>

<script id="zammad_form_script" src="https://sav.pingflow.fr/assets/form/form.js"></script>

<script>
    $(function() {
        $('#feedback-form').ZammadForm({
            messageTitle: 'Formulaire de Commentaire',
            messageSubmit: 'Envoyer',
            messageThankYou: 'Merci pour votre requête  (#%s) ! Nous vous recontacterons dans les meilleurs délais.',
            debug: true,
            modal: true,
            attachmentSupport: true
        });
    });
</script>

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