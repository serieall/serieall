@extends('layouts.admin')

@section('pageTitle', 'Admin - Saisons')

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
    <a href="{{ route('admin.seasons.show', $show->id) }}" class="section">
        Saisons & Episodes
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter une nouvelle saison
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="adminTitre">
        Ajouter de nouvelles saisons
        <span class="sub header">
            Ajouter de nouvelles saisons dans {{ $show->name }}
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <p>
                    <button class="ui basic button add-season">
                        <i class="user icon"></i>
                        Ajouter une saison
                    </button>
                    <br />
                </p>

                <form class="ui form" action="{{ route('admin.seasons.store') }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="show_id" value="{{ $show->id }}">

                    <div class="div-seasons">

                    </div>

                    <p></p>
                    <button class="submit positive ui button">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fonction de création et de suppression des nouveau acteurs
        $(function(){
            // Définition des variables
            var max_fields  =   100; // Nombre maximums de ligne sautorisées
            var seasonNumber  =  $('.div-seasons').length; // Nombre d'acteurs

            // Suppression d'un acteur
            $(document).on('click', '.remove-season', function(){
                $(this).parents('.div-season').remove();
            });

            // Ajouter un acteur
            $('.add-season').click(function(e) {
                e.preventDefault();

                var colorArray = [
                    'red',
                    'orange',
                    'yellow',
                    'olive',
                    'green',
                    'teal',
                    'blue',
                    'violet',
                    'purple',
                    'pink',
                    'brown',
                    'grey',
                    'black'
                ];
                var randomNumber = Math.floor(Math.random()*colorArray.length);

                if (seasonNumber < max_fields) {
                    var html = '<div class="ui '  + colorArray[randomNumber] + ' segment div-season">'
                        + '<button class="ui right floated negative basic circular icon button remove-season">'
                        + '<i class="remove icon"></i>'
                        + '</button>'

                        + '<div class="ui two fields">'
                        + '<div class="ui field">'
                        + '<label for="name">Numéro de la saison</label>'
                        + '<input id="seasons.'+ seasonNumber +'.name" name="seasons[' + seasonNumber + '][name]" type="number" min="0">'
                        + '<div class="ui red hidden message"></div>'
                        + '</div>'

                        + '<div class="ui field">'
                        + '<label for="ba">Bande Annonce</label>'
                        + '<input id="seasons.'+ seasonNumber +'.ba" name="seasons[' + seasonNumber + '][ba]">'
                        + '<div class="ui red hidden message"></div>'
                        + '</div>'

                        + '</div>'
                        + '</div>'
                        + '</div>';

                    ++seasonNumber;

                    $('.div-seasons').append(html);
                }
            });
        });

        // Submission
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();
            
            $('.submit').addClass("loading");

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            })
                .done(function () {
                    window.location.href = '{!! route('admin.seasons.redirect', $show->id) !!}';
                })
                .fail(function (data) {
                    $('.submit').removeClass("loading");

                    $.each(data.responseJSON.errors, function (key, value) {
                        var input = 'input[id="' + key + '"]';

                        $(input + '+div').text(value);
                        $(input + '+div').removeClass("hidden");
                        $(input).parent().addClass('error');

                        if(key.indexOf('seasons.') > -1) {
                            $(input).parents('.div-season').addClass('red');

                            var dataSeason = $('.dataSeason');

                            $(dataSeason).addClass('red');
                            $(dataSeason).css('color', '#DB3041');
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
@endpush