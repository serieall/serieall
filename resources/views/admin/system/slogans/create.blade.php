@extends('layouts.admin')

@section('pageTitle', 'Admin - Slogans')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.system') }}" class="section">
        Système
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.slogans') }}" class="section">
        Slogans
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Nouveau slogan
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="adminTitre">
        Ajouter de nouveaux slogans
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <p>
                    <button class="ui basic button add-slogan">
                        <i class="bullhorn icon"></i>
                        Ajouter un slogan
                    </button>
                    <br />
                </p>

                <form class="ui form" action="{{ route('admin.slogans.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="div-slogans">

                    </div>

                    <p></p>
                    <button class="submit positive ui button">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            var sloganNumber = $('.div-slogans').length; // Nombre d'épisodes

            //Suppression d'un slogan
            $(document).on('click', '.remove-slogan', function(){
                $(this).parents('.div-slogan').remove();
            });

            //Ajout d'un episode
            $('.add-slogan').click(function (e) {
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
                var randomNumber = Math.floor(Math.random() * colorArray.length);

                var html = '<div class="ui ' + colorArray[randomNumber] + ' segment div-slogan">'

                    + '<div class="ui field">'
                    + '<button class="ui right floated negative basic circular icon button remove-slogan">'
                    + '<i class="remove icon"></i>'
                    + '</button>'
                    + '</div>'

                    + '<div class="ui field">'
                    + '<label for="message">Slogan</label>'
                    + '<input id="slogans.' + sloganNumber + '.message" name="slogans[' + sloganNumber + '][message]">'
                    + '<div class="ui red hidden message"></div>'
                    + '</div>'

                    + '<div class="ui two fields">'
                    + '<div class="ui field">'
                    + '<label for="source">Source</label>'
                    + '<input id="slogans.' + sloganNumber + '.source" name="slogans[' + sloganNumber + '][source]">'
                    + '<div class="ui red hidden message"></div>'
                    + '</div>'

                    + '<div class="ui field">'
                    + '<label for="url">URL</label>'
                    + '<input id="slogans.' + sloganNumber + '.url" name="slogans[' + sloganNumber + '][url]">'
                    + '<div class="ui red hidden message"></div>'
                    + '</div>'
                    + '</div>'
                    + '</div>';

                ++sloganNumber;

                $('.div-slogans').append(html);
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
                    window.location.href = '{!! route('admin.slogans.redirect') !!}';
                })
                .fail(function (data) {
                    $('.submit').removeClass("loading");

                    $.each(data.responseJSON.errors, function (key, value) {
                        var input = 'input[id="' + key + '"]';

                        $(input + '+div').text(value);
                        $(input + '+div').removeClass("hidden");
                        $(input).parent().addClass('error');
                    });
                });
        });
    </script>
@endsection