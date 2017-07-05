@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.shows.index') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.shows.edit', $show->id) }}" class="section">
        {{ $show->name }}
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.artists.show', $show->id) }}" class="section">
        Acteurs
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter un nouvel acteur
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter un nouvel acteur
        <span class="sub header">
            Ajouter un nouveau rôle dans {{ $show->name }}
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <p>
                    <button class="ui basic button add-artist">
                        <i class="user icon"></i>
                        Ajouter un acteur
                    </button>
                    <br />
                </p>

                <form class="ui form" action="{{ route('admin.artists.store', $show->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="show_id" value="{{ $show->id }}">

                    <div class="div-artists">

                    </div>

                    <p></p>
                    <button class="submit positive ui button" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#dropdown-artists')
            .dropdown({
                apiSettings: {
                    url: '/api/artists/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
                allowAdditions: true,
                forceSelection : false,
                minCharacters: 2
            })
        ;

        // Fonction de création et de suppression des nouveau acteurs
        $(function(){
            // Définition des variables
            var max_fields  =   50; // Nombre maximums de ligne sautorisées
            var artist_number  =  $('.div-artists').length; // Nombre d'acteurs

            // Suppression d'un acteur
            $(document).on('click', '.remove-artist', function(){
                $(this).parents('.div-artist').remove();
                $(this).find(".artist_name-input").attr( "name", 'artists[' + index + '][name]');
                $(this).find(".artist_role-input").attr( "name", 'artists[' + index + '[role]');
                $(this).find(".artist_role-input").attr( "name", 'artists[' + index + '[image]');
                $(this).find(".artist_name-input").attr( "id", 'artists.' + index + '.name');
                $(this).find(".artist_role-input").attr( "id", 'artists.' + index + '.role');
                $(this).find(".artist_role-input").attr( "id", 'artists.' + index + '.image');
            });

            // Ajouter un acteur
            $('.add-artist').click(function(e) {
                e.preventDefault();

                if (artist_number < max_fields) {
                    var html = '<div class="ui segment div-artist">'
                        + '<button class="ui right floated negative basic circular icon button remove-artist">'
                        + '<i class="remove icon"></i>'
                        + '</button>'
                        + '<div class="three fields">'

                        + '<div class="field">'
                        + '<label for="image">Photo de l\'acteur</label>'
                        + '<input id="artists.'+ artist_number +'.image" name="artists[' + artist_number + '][image]" type="file">'
                        + '<div class="ui red hidden message"></div>'
                        + '</div>'

                        + '<div class="field">'
                        + '<label>Nom de l\'acteur</label>'
                        + '<select id="artists.'+ artist_number +'.name" name="artists[' + artist_number + '][name]" class="ui fluid search dropdown artistDropdown">'
                        + '</select>'
                        + '<div class="ui red hidden message"></div>'
                        + '</div>'

                        + '<div class="field">'
                        + '<label class="artist_role-label">Rôle</label>'
                        + '<input class="artist_role-input" id="artists.'+ artist_number +'.role" name="artists[' + artist_number + '][role]" placeholder="Rôle" type="text" value="{{ old('role_artist') }}">'
                        + '<div class="ui red hidden message"></div>'

                        + '</div>'
                        + '</div>'
                        + '</div>';

                    $(function() {
                        $('.artistDropdown')
                            .dropdown({
                                apiSettings: {
                                    url: '/api/artists/list?name-lk=*{query}*'
                                },
                                fields: {remoteValues: "data", value: "name"},
                                allowAdditions: true,
                                forceSelection : true,
                                minCharacters: 2
                            });
                    });

                    ++artist_number;

                    $('.div-artists').append(html);
                }
            });
        });

        // Submission
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();

            var $form = $(this);
            var formdata = (window.FormData) ? new FormData($form[0]) : null;
            var data = (formdata !== null) ? formdata : $form.serialize();

            $('.submit').addClass("loading");

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: data,
                contentType: false, // obligatoire pour de l'upload
                processData: false // obligatoire pour de l'upload
            })
                .done(function () {
                    window.location.href = '{!! route('admin.artists.redirectJSON', $show->id) !!}';
                })
                .fail(function (data) {
                    $('.submit').removeClass("loading");

                    $.each(data.responseJSON, function (key, value) {
                        var input = 'input[id="' + key + '"]';

                        $(input + '+div').text(value);
                        $(input + '+div').removeClass("hidden");
                        $(input).parent().addClass('error');

                        if(key.indexOf('artists.') > -1) {
                            $(input).parents('.div-artist').addClass('red');

                            var dataActor = $('.dataActor');

                            $(dataActor).addClass('red');
                            $(dataActor).css('color', '#DB3041');
                        }
                        else{
                            var dataShow = $('.dataShow');
                            $(dataShow).addClass('red');
                            $(dataShow).css('color', '#DB3041');
                        }
                    });
                });
        });
    </script>
@endsection