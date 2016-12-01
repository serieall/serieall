@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('adminIndex') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('adminShow.index') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter une série manuellement
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter une série manuellement
        <div class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </div>
    </h1>

    <form class="ui form" method="POST" action="{{ route('adminShow.storeManually') }}">
        {{ csrf_field() }}

        <div class="ui centered grid">
            <div class="ten wide column segment">
                <div class="ui pointing secondary menu">
                    <a class="item active" data-tab="first">Série</a>
                    <a class="item" data-tab="second">Acteurs</a>
                    <a class="item" data-tab="third">Saisons & épisodes</a>
                    <a class="item" data-tab="fourth">Rentrée</a>
                </div>
                <div class="ui tab active" data-tab="first">
                    <div class="ui teal segment">
                        <h4 class="ui dividing header">Informations générales sur la série</h4>
                        <div class="two fields">
                            <div class="field {{ $errors->has('name') ? ' error' : '' }}">
                                <label>Nom original de la série</label>
                                <input name="name" placeholder="Nom original de la série" type="text" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('name_fr') ? ' error' : '' }}">
                                <label>Nom français de la série</label>
                                <input name="name_fr" placeholder="Nom français" type="text" value="{{ old('name_fr') }}">

                                @if ($errors->has('name_fr'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('name_fr') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('resume') ? ' error' : '' }}">
                                <label>Résumé</label>
                                <textarea name="resume" value="{{ old('resume') }}"></textarea>

                                @if ($errors->has('resume'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('resume') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="two fields field">
                                <div class="field {{ $errors->has('format') ? ' error' : '' }}">
                                    <label>Format</label>
                                    <div class="ui left icon input">
                                        <input name="taux_erectile" placeholder="Format de la série..." type="number" value="{{ old('format') }}">
                                        <i class="tv icon"></i>
                                    </div>

                                    @if ($errors->has('format'))
                                        <div class="ui red message">
                                            <strong>{{ $errors->first('format') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="field {{ $errors->has('encours') ? ' error' : '' }}">
                                    <label>Série en cours</label>
                                    <div id="dropdown-encours" class="ui fluid search selection dropdown">
                                        <i class="dropdown icon"></i>
                                        <span class="text">Choisir</span>
                                        <div class="menu">
                                            <div class="item">
                                                <i class="checkmark icon"></i>
                                                Oui
                                            </div>
                                            <div class="item">
                                                <i class="remove icon"></i>
                                                Non
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('encours'))
                                        <div class="ui red message">
                                            <strong>{{ $errors->first('encours') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('diffusion_us') ? ' error' : '' }}">
                                <label>Date de la diffusion originale</label>
                                <div class="ui calendar" id="datepicker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input name="diffusion_us" class="date-picker" type="date" placeholder="Date" value="{{ old('diffusion_us') }}">
                                    </div>
                                </div>
                                @if ($errors->has('diffusion_us'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('diffusion_us') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('diffusion_fr') ? ' error' : '' }}">
                                <label>Date de la diffusion française</label>
                                <div class="ui calendar" id="datepicker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input name="diffusion_fr" class="date-picker" type="date" placeholder="Date" value="{{ old('diffusion_fr') }}">
                                    </div>
                                </div>
                                @if ($errors->has('diffusion_fr'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('diffusion_fr') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('channels') ? ' error' : '' }}">
                                <label>Chaine(s)</label>
                                <div id="dropdown-chaines" class="ui fluid multiple search selection dropdown">
                                    <input name="channels" type="hidden" value="{{ old('channels') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($channels as $channel)
                                            <div class="item" data-value="{{ $channel->name }}">{{ $channel->name }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($errors->has('channels'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('channels') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('nationalities') ? ' error' : '' }}">
                                <label>Nationalité(s)</label>
                                <div id="dropdown-nationalities" class="ui fluid multiple search selection dropdown">
                                    <input name="nationalities" type="hidden" value="{{ old('nationalities') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($nationalities as $nationality)
                                            <div class="item" data-value="{{ $nationality->name }}">{{ $nationality->name }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($errors->has('nationalities'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('nationalities') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('creators') ? ' error' : '' }}">
                                <label>Créateur(s) de la série</label>
                                <div id="dropdown-creators" class="ui fluid multiple search selection dropdown">
                                    <input name="creators" type="hidden" value="{{ old('creators') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($actors as $actor)
                                            <div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($errors->has('creators'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('creators') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('genres') ? ' error' : '' }}">
                                <label>Genre(s)</label>
                                <div id="dropdown-genres" class="ui fluid multiple search selection dropdown">
                                    <input name="genres" type="hidden" value="{{ old('genres') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($genres as $genre)
                                            <div class="item" data-value="{{ $genre->name }}">{{ $genre->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                @if ($errors->has('genres'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('genres') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <button class="submit positive ui button" type="submit">Créer la série</button>
                    </div>
                </div>

                <div class="ui tab blue segment" data-tab="second">
                    <h4 class="ui dividing header">Ajouter un ou plusieurs acteurs</h4>
                    <p>
                        <button class="ui basic button add-actor">
                            <i class="user icon"></i>
                            Ajouter un acteur
                        </button>
                        <br />
                    </p>

                    <div class="div-actors">

                    </div>

                    <p></p>
                    <button class="submit positive ui button" type="submit">Créer la série</button>
                </div>

                <div class="ui tab red segment" data-tab="third">
                    <h4 class="ui dividing header">Ajouter les saisons et les épisodes</h4>
                    <p>
                        <div class="ui info message">
                            Vous pouvez utiliser l'icone <i class="hashtag icon"></i> pour changer l'ordre des éléments.
                        </div>

                        <button class="ui basic button seasonAdd">
                            <i class="object group icon"></i>
                            Ajouter une saison
                        </button>
                        <br />
                    </p>


                    <div class="ui fluid styled accordion seasonsBlock" id="sortableSeasons">

                    </div>

                    <p></p>
                    <button class="submit positive ui button" type="submit">Créer la série</button>
                </div>

                <div class="ui tab violet segment" data-tab="fourth">
                    <h4 class="ui dividing header">Informations sur la rentrée</h4>
                    <div class="two fields">
                        <div class="field {{ $errors->has('taux_erectile') ? ' error' : '' }}">
                            <label>Taux érectile</label>
                            <div class="ui left icon input">
                                <input name="taux_erectile" placeholder="Pourcentage..." type="number" value="{{ old('taux_erectile') }}">
                                <i class="percent icon"></i>
                            </div>

                            @if ($errors->has('taux_erectile'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('taux_erectile') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('avis_rentree') ? ' error' : '' }}">
                            <label>Avis de la rédaction</label>
                            <textarea name="avis_rentree" value="{{ old('avis_rentree') }}"></textarea>

                            @if ($errors->has('avis_rentree'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('avis_rentree') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button class="submit positive ui button" type="submit">Créer la série</button>
                </div>
            </div>
        </div>
    </form>

    @section('scripts')
        <script>
            $('#dropdown-creators')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false,
                        minCharacters: 4
                    })
            ;
            $('#dropdown-genres')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false
                    })
            ;
            $('#dropdown-chaines')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false
                    })
            ;

            $('#dropdown-nationalities')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false
                    })
            ;

            $( '.date-picker' ).datepicker({
                showAnim: "blind",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });

            $('#dropdown-encours')
                    .dropdown({
                    })
            ;

            $('.menu .item')
                    .tab()
            ;

            $('.ui.styled.fluid.accordion.seasonsBlock')
                    .accordion({
                        selector: {
                            trigger: '.expandableBlock'

                        },
                        exclusive: false
                    })
            ;

            // Fonction de création et de suppression des nouveau acteurs
            $(function(){
                // Définition des variables
                var max_fields  =   50; // Nombre maximums de ligne sautorisées
                var actor_number  =  $('.div-actors').length; // Nombre d'acteurs
                var obj = $(this);

                // Suppression d'un acteur
                $(document).on('click', '.remove-actor', function(){
                    $(this).parents('.div-actor').remove();
                    $(this).find(".actor_name-label").attr( "for", 'name' + index);
                    $(this).find(".actor_name-input").attr( "name", 'actors[' + index + '][name]');
                    $(this).find(".actor_role-label").attr( "for", 'role' + index );
                    $(this).find(".actor_role-input").attr( "name", 'actors[' + index + '][role]');
                });

                // Ajouter un acteur
                $('.add-actor').click(function(e) {
                    e.preventDefault();

                    if (actor_number < max_fields) {
                        var html = '<div class="ui segment div-actor">'
                                + '<button class="ui right floated negative basic circular icon button remove-actor">'
                                + '<i class="remove icon"></i>'
                                + '</button>'
                                + '<div class="two fields">'
                                + '<div class="field">'
                                + '<label class="actor_name-label" for="name' + actor_number + '">Nom de l\'acteur</label>'
                                + '<input class="actor_name-input" name="actors[' + actor_number + '][name_actor]" placeholder="Nom de l\'acteur" type="text" value="{{ old('name_actor') }}">'
                                + '<div class="ui red message">'
                                + '</div>'
                                + '</div>'
                                + '<div class="field {{ $errors->has('role_actor') ? ' error' : '' }}">'
                                + '<label class="actor_role-label" for="role' + actor_number + '">Rôle</label>'
                                + '<input class="actor_role-input" name="actors[' + actor_number + '][role_actor]" placeholder="Role de l\'acteur" type="text" value="{{ old('role_actor') }}">'
                                + '<div class="ui red message">'
                                + '</div>'
                                + '</div>'
                                + '</div>';

                        ++actor_number;

                        $('.div-actors').append(html);
                    }
                });
            });

            // Fonction de Drag 'N Drop pour changer l'ordre des saisons
            $(function(){
                //Définition des variables
                var seasonNumber = $('.seasonsBlock').length; // Nombre de saisons

                // Déplacement d'une saison
                $('#sortableSeasons').sortable({
                    axis: "y",
                    containment: ".seasonsBlock",
                    handle: ".seasonMove",
                    cursor: "grabbing",
                    cancel: '',
                    placeholder: "ui segment fluid portlet-placeholder",
                    // Evenement appelé lorsque l'élément est relaché
                    stop: function(event, ui){
                        // Pour chaque item de liste
                        $('#sortableSeasons').find('.seasonBlock').each(function(){
                            // On actualise sa position
                            seasonIndex = parseInt($(this).index()+1);

                            // On met à jour les infos saisons
                            $(this).find(".seasonName").html('<i class="dropdown icon"></i>Saison ' + seasonIndex);
                            $(this).find(".content").attr("seasonNumber", seasonIndex);
                            $(this).find(".episodeAdd").attr("id", 'episodeAdd' + seasonIndex );
                            $(this).find(".episodesBlock").attr("id", 'episodes' + seasonIndex );

                            $(this).find(".seasonInputBA").attr("name", 'seasons[' + seasonIndex + '][ba]' );

                            $(this).find('.episodeBlock').each(function () {
                                $(this).attr("class", 'episodeBlock episode' + seasonIndex);

                                // On actualise sa position
                                episodeIndex = parseInt($(this).index('.episode' + seasonIndex) + 1);

                                $(this).find(".episodeName").html('<i class="dropdown icon"></i>Episode ' + seasonIndex + '.' + episodeIndex);
                                $(this).find(".episodeInputNameEN").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][name]');
                                $(this).find(".episodeInputNameFR").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][name_fr]');
                                $(this).find(".episodeInputResumeEN").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][resume]');
                                $(this).find(".episodeInputResumeFR").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][resume_fr]');
                                $(this).find(".episodeInputDiffusionUS").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][diffusion_us]');
                                $(this).find(".episodeInputDiffusionFR").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][diffusion_fr]');
                                $(this).find(".episodeInputParticularite").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][particularite]');
                                $(this).find(".episodeInputBA").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][ba]');
                                $(this).find(".episodeInputDirectors").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][directors]');
                                $(this).find(".episodeInputWriters").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][writers]');
                                $(this).find(".episodeInputGuests").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][guests]');
                            });
                        });
                    }
                });

                //Suppression d'une saison
                $(document).on('click', '.seasonRemove', function(){
                    $(this).parents('.seasonBlock').next('.content').remove();
                    $(this).parents('.seasonBlock').remove();

                    $('#sortableSeasons').find('.seasonBlock').each(function(){
                        // On actualise sa position
                        seasonIndex = parseInt($(this).index()+1);
                        // On la met à jour dans la page
                        $(this).find(".expandableBlock").html('<i class="dropdown icon"></i> Saison '+ seasonIndex);
                        $(this).find(".seasonInputBA").attr( "name", 'seasons[' + seasonIndex + '][ba]');

                        $(this).find('.episodeBlock').each(function () {
                            $(this).attr("class", 'episodeBlock episode' + seasonIndex);

                            // On actualise sa position
                            episodeIndex = parseInt($(this).index('.episode' + seasonIndex) + 1);

                            $(this).find(".episodeName").html('<i class="dropdown icon"></i>Episode ' + seasonIndex + '.' + episodeIndex);
                            $(this).find(".episodeInputNameEN").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][name]');
                            $(this).find(".episodeInputNameFR").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][name_fr]');
                            $(this).find(".episodeInputResumeEN").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][resume]');
                            $(this).find(".episodeInputResumeFR").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][resume_fr]');
                            $(this).find(".episodeInputDiffusionUS").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][diffusion_us]');
                            $(this).find(".episodeInputDiffusionFR").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][diffusion_fr]');
                            $(this).find(".episodeInputParticularite").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][particularite]');
                            $(this).find(".episodeInputBA").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][ba]');
                            $(this).find(".episodeInputDirectors").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][directors]');
                            $(this).find(".episodeInputWriters").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][writers]');
                            $(this).find(".episodeInputGuests").attr("name", 'seasons['+ seasonIndex +'][episodes][' + episodeIndex + '][guests]');
                        });
                    });

                    --seasonNumber;
                });

                //Ajout d'une saison
                $('.seasonAdd').click(function(e){
                    e.preventDefault();
                    var html = '<div class="seasonBlock">'
                            + '<div class="title">'
                            + '<div class="ui grid">'
                            + '<div class="twelve wide column middle aligned expandableBlock seasonName">'
                            + '<i class="dropdown icon"></i>'
                            + 'Saison '+ seasonNumber
                            + '</div>'
                            + '<div class="four wide column">'
                            + '<button class="ui right floated negative basic circular icon button seasonRemove">'
                            + '<i class="remove icon"></i>'
                            + '</button>'
                            + '<button class="ui right floated positive basic circular icon button seasonMove">'
                            + '<i class="hashtag icon"></i>'
                            + '</button>'
                            + '</div>'
                            + '</div>'
                            + '</div>'
                            + '<div class="content" seasonNumber=' + seasonNumber + '>'
                            + '<div class="field {{ $errors->has('ba') ? ' error' : '' }}">'
                            + '<label>Bande Annonce</label>'
                            + '<input class="seasonInputBA" name="seasons[' + seasonNumber + '][ba]" placeholder="Bande annonce" type="text" value="{{ old('ba') }}">'
                            + '@if ($errors->has('ba'))'
                            + '<div class="ui red message">'
                            + '<strong>{{ $errors->first('ba') }}</strong>'
                            + '</div>'
                            + '@endif'
                            + '</div>'
                            + '<button class="ui basic button episodeAdd" id="episodeAdd'+ seasonNumber +'">'
                            + '<i class="tv icon"></i>'
                            + 'Ajouter un épisode'
                            + '</button>'
                            + '<div class="accordion transition hidden episodesBlock sortableEpisodes" id="episodes' + seasonNumber + '">'
                            + '</div>'
                            + '</div>'
                            + '</div>';

                    $('.seasonsBlock').append(html);

                    // Fonction de Drag 'N Drop pour changer l'ordre des épisodes
                    $(function(){
                        $('.sortableEpisodes').sortable({
                            axis: "y",
                            connectWith: ".episodesBlock",
                            containment: ".episodesBlock",
                            handle: ".episodeMove",
                            cursor: "grabbing",
                            cancel: '',
                            placeholder: "ui segment fluid portlet-placeholder",
                            // Evenement appelé lorsque l'élément est relaché
                            stop: function(event, ui){
                                // Pour chaque item de liste
                                $('.sortableEpisodes').find('.episodeBlock').each(function(){
                                    var seasonNumber = $(this).parents('.content').attr('seasonNumber');

                                    $(this).attr("class", 'episodeBlock episode' + seasonNumber);

                                    // On actualise sa position
                                    episodeIndex = parseInt($(this).index('.episode' + seasonNumber) + 1);

                                    // On met à jour les infos épisodes
                                    $(this).find(".episodeName").html('<i class="dropdown icon"></i> Episode ' + seasonNumber + '.' + episodeIndex);
                                    $(this).find(".episodeInputNameEN").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][name]');
                                    $(this).find(".episodeInputNameFR").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][name_fr]');
                                    $(this).find(".episodeInputResumeEN").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][resume]');
                                    $(this).find(".episodeInputResumeFR").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][resume_fr]');
                                    $(this).find(".episodeInputDiffusionUS").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][diffusion_us]');
                                    $(this).find(".episodeInputDiffusionFR").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][diffusion_fr]');
                                    $(this).find(".episodeInputParticularite").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][particularite]');
                                    $(this).find(".episodeInputBA").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][ba]');
                                    $(this).find(".episodeInputDirectors").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][directors]');
                                    $(this).find(".episodeInputWriters").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][writers]');
                                    $(this).find(".episodeInputGuests").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][guests]');

                                });
                            }
                        });

                        //Suppression d'un épisode
                        $(document).on('click', '.episodeRemove', function(){
                            var seasonNumber = $(this).parents('.content').attr('seasonNumber');

                            $(this).parents('.episodeBlock').next('.content').remove();
                            $(this).parents('.episodeBlock').remove();

                            $('#episodes' + seasonNumber).find('.episodeBlock').each(function(){
                                // On actualise sa position
                                episodeIndex = parseInt($(this).index('.episode' + seasonNumber) +1);

                                // On la met à jour dans la page
                                $(this).find(".episodeName").html('<i class="dropdown icon"></i> Episode ' + seasonNumber + '.' + episodeIndex);
                                $(this).find(".episodeInputNameEN").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][name]');
                                $(this).find(".episodeInputNameFR").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][name_fr]');
                                $(this).find(".episodeInputResumeEN").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][resume]');
                                $(this).find(".episodeInputResumeFR").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][resume_fr]');
                                $(this).find(".episodeInputDiffusionUS").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][diffusion_us]');
                                $(this).find(".episodeInputDiffusionFR").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][diffusion_fr]');
                                $(this).find(".episodeInputParticularite").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][particularite]');
                                $(this).find(".episodeInputBA").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][ba]');
                                $(this).find(".episodeInputDirectors").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][directors]');
                                $(this).find(".episodeInputWriters").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][writers]');
                                $(this).find(".episodeInputGuests").attr("name", 'seasons['+ seasonNumber +'][episodes][' + episodeIndex + '][guests]');
                            });
                        });

                        //Ajout d'un episode
                        $('#episodeAdd' + seasonNumber).click(function(e){
                            e.preventDefault();

                            var seasonNumber = $(this).parents('.content').attr('seasonNumber');
                            var episodeNumber =  $('#episodes' + seasonNumber).children('.episodeBlock').length + 1 ; // Nombre d'épisode total

                            var html = '<div class="episodeBlock episode' + seasonNumber +'">'
                                    + '<div class="title">'
                                    + '<div class="ui grid">'
                                    + '<div class="twelve wide column middle aligned expandableBlock episodeName">'
                                    + '<i class="dropdown icon"></i>'
                                    + 'Episode ' + seasonNumber + '.' + episodeNumber
                                    + '</div>'
                                    + '<div class="four wide column">'
                                    + '<button class="ui right floated negative basic circular icon button episodeRemove">'
                                    + '<i class="remove icon"></i>'
                                    + '</button>'
                                    + '<button class="ui right floated positive basic circular icon button episodeMove">'
                                    + '<i class="hashtag icon"></i>'
                                    + '</button>'
                                    + '</div>'
                                    + '</div>'
                                    + '</div>'
                                    + '<div class="content">'
                                    + '<div class="two fields">'
                                    + '<div class="field {{ $errors->has('name') ? ' error' : '' }}">'
                                    + '<label>Nom original</label>'
                                    + '<input class="episodeInputNameEN" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][name]" placeholder="Nom original de l\'épisode" type="text" value="{{ old('name') }}">'
                                    + '@if ($errors->has('name'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('name') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '<div class="field {{ $errors->has('name_fr') ? ' error' : '' }}">'
                                    + '<label>Nom français</label>'
                                    + '<input class="episodeInputNameFR" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][name_fr]" placeholder="Nom français de l\'épisode" type="text" value="{{ old('name_fr') }}">'
                                    + '@if ($errors->has('name_fr'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('name_fr') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '</div>'

                                    + '<div class="two fields">'
                                    + '<div class="field {{ $errors->has('resume') ? ' error' : '' }}">'
                                    + '<label>Résumé original</label>'
                                    + '<textarea class="episodeInputResumeEN" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][resume]" placeholder="Résumé original de l\'épisode" value="{{ old('resume') }}""></textarea>'
                                    + '@if ($errors->has('resume'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('resume') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '<div class="field {{ $errors->has('resume_fr') ? ' error' : '' }}">'
                                    + '<label>Résumé de l\'épisode</label>'
                                    + '<textarea class="episodeInputResumeFR" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][resume_fr]" placeholder="Résumé en français de l\'épisode" value="{{ old('resume_fr') }}""></textarea>'
                                    + '@if ($errors->has('resume_fr'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('resume_fr') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '</div>'

                                    + '<div class="two fields">'
                                    + '<div class="field {{ $errors->has('diffusion_us') ? ' error' : '' }}">'
                                    + '<label>Date de la diffusion originale</label>'
                                    + '<div class="ui calendar" id="datepicker">'
                                    + '<div class="ui input left icon">'
                                    + '<i class="calendar icon"></i>'
                                    + '<input class="episodeInputDiffusionUS date-picker" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][diffusion_us]" type="date" placeholder="Date" value="{{ old('diffusion_us') }}">'
                                    + '</div>'
                                    + '</div>'
                                    + '@if ($errors->has('diffusion_us'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('diffusion_us') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '<div class="field {{ $errors->has('diffusion_fr') ? ' error' : '' }}">'
                                    + '<label>Date de la diffusion française</label>'
                                    + '<div class="ui calendar" id="datepicker">'
                                    + '<div class="ui input left icon">'
                                    + '<i class="calendar icon"></i>'
                                    + '<input class="episodeInputDiffusionFR date-picker" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][diffusion_fr]" type="date" placeholder="Date" value="{{ old('diffusion_fr') }}">'
                                    + '</div>'
                                    + '</div>'
                                    + '@if ($errors->has('diffusion_fr'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('diffusion_fr') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '</div>'

                                    + '<div class="two fields">'
                                    + '<div class="field {{ $errors->has('particularite') ? ' error' : '' }}">'
                                    + '<label>Particularité</label>'
                                    + '<textarea rows="2" class="episodeInputParticularite" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][particularite]" placeholder="Particularité de l\'épisode" value="{{ old('particularite') }}""></textarea>'
                                    + '@if ($errors->has('particularite'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('particularite') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '<div class="field {{ $errors->has('ba') ? ' error' : '' }}">'
                                    + '<label>Bande annonce de l\'épisode</label>'
                                    + '<input class="episodeInputBA" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][ba]" type="date" placeholder="Bande Annonce de l\'épisode" value="{{ old('ba') }}">'
                                    + '@if ($errors->has('ba'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('ba') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '</div>'

                                    + '<div class="three fields">'

                                    + '<div class="field {{ $errors->has('directors') ? ' error' : '' }}">'
                                    + '<label>Réalisateur(s) de la série</label>'
                                    + '<div class="ui fluid multiple search selection dropdown directorDropdown">'
                                    + '<input name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][directors]" type="hidden" value="{{ old('directors') }}">'
                                    + '<i class="dropdown icon"></i>'
                                    + '<div class="default text">Choisir</div>'
                                    + '<div class="menu">'
                                    + '@foreach($actors as $actor)'
                                    + '<div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>'
                                    + '@endforeach'
                                    + '</div>'
                                    + '</div>'
                                    + '@if ($errors->has('directors'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('directors') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'

                                    + '<div class="field {{ $errors->has('writers') ? ' error' : '' }}">'
                                    + '<label>Scénariste(s) de la série</label>'
                                    + '<div class="ui fluid multiple search selection dropdown writerDropdown">'
                                    + '<input name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][writers]" type="hidden" value="{{ old('writers') }}">'
                                    + '<i class="dropdown icon"></i>'
                                    + '<div class="default text">Choisir</div>'
                                    + '<div class="menu">'
                                    + '@foreach($actors as $actor)'
                                    + '<div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>'
                                    + '@endforeach'
                                    + '</div>'
                                    + '</div>'
                                    + '@if ($errors->has('writers'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('writers') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'

                                    + '<div class="field {{ $errors->has('guests') ? ' error' : '' }}">'
                                    + '<label>Guest(s) de la série</label>'
                                    + '<div class="ui fluid multiple search selection dropdown guestDropdown">'
                                    + '<input name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][guests]" type="hidden" value="{{ old('guests') }}">'
                                    + '<i class="dropdown icon"></i>'
                                    + '<div class="default text">Choisir</div>'
                                    + '<div class="menu">'
                                    + '@foreach($actors as $actor)'
                                    + '<div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>'
                                    + '@endforeach'
                                    + '</div>'
                                    + '</div>'
                                    + '@if ($errors->has('guests'))'
                                    + '<div class="ui red message">'
                                    + '<strong>{{ $errors->first('guests') }}</strong>'
                                    + '</div>'
                                    + '@endif'
                                    + '</div>'
                                    + '</div>'
                                    + '</div>'
                                    + '</div>';

                            $(function() {
                                $( '.date-picker' ).datepicker({
                                    showAnim: "blind",
                                    dateFormat: "yy-mm-dd",
                                    changeMonth: true,
                                    changeYear: true
                                });

                                $('.guestDropdown')
                                        .dropdown({
                                            allowAdditions: true,
                                            forceSelection : false,
                                            minCharacters: 4
                                        });
                                $('.writerDropdown')
                                        .dropdown({
                                            allowAdditions: true,
                                            forceSelection : false,
                                            minCharacters: 4
                                        });
                                $('.directorDropdown')
                                        .dropdown({
                                            allowAdditions: true,
                                            forceSelection : false,
                                            minCharacters: 4
                                        });
                            });

                            ++episodeNumber;

                            $(this).next('.episodesBlock').append(html);
                        });

                        ++seasonNumber;
                    });
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
                        .done(function (data) {
                            window.location.href = '{!! url('/adminShow') !!}';
                        })
                        .fail(function (data) {
                            $('.submit').removeClass("loading");
                            $.each(data.responseJSON, function (key, value) {
                                var input = 'input[name="' + key + '"]';
                                $(input + '+small').text(value);
                                $(input).parent().addClass('error');
                            });
                        });
            });
        </script>
    @endsection
@endsection