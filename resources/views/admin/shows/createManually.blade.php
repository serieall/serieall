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
        <span class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </span>
    </h1>

    <form class="ui form" method="POST" action="{{ route('adminShow.storeManually') }}">
        {{ csrf_field() }}

        <div class="ui centered grid">
            <div class="ten wide column segment">
                <div class="ui pointing secondary menu">
                    <a class="dataShow item active" data-tab="first">Série</a>
                    <a class="dataActor item" data-tab="second">Acteurs</a>
                    <a class="dataSeason item" data-tab="third">Saisons & épisodes</a>
                    <a class="dataRentree item" data-tab="fourth">Rentrée</a>
                </div>
                <div class="ui tab active" data-tab="first">
                    <div class="ui teal segment">
                        <h4 class="ui dividing header">Informations générales sur la série</h4>
                        <div class="two fields">
                            <div class="field">
                                <label>Nom original de la série</label>
                                <input id="name" name="name" placeholder="Nom original de la série" type="text" value="{{ old('name') }}">
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Nom français de la série</label>
                                <input id="name_fr" name="name_fr" placeholder="Nom français" type="text" value="{{ old('name_fr') }}">
                                <div class="ui red hidden message"></div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label for="resume">Résumé</label>
                                <textarea id="resume" name="resume"></textarea>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="two fields field">
                                <div class="field">
                                    <label>Format</label>
                                    <div class="ui left icon input">
                                        <input id="format" name="format" placeholder="Format de la série..." type="number" value="{{ old('format') }}">
                                        <i class="tv icon"></i>
                                    </div>
                                    <div class="ui red hidden message"></div>
                                </div>

                                <div class="field">
                                    <label>Série en cours</label>
                                    <div id="dropdown-encours" class="ui fluid search selection dropdown">
                                        <input name="encours" type="hidden">
                                        <i class="dropdown icon"></i>
                                        <span class="text">Choisir</span>
                                        <div class="menu">
                                            <div class="item" data-value="1">
                                                <i class="checkmark icon"></i>
                                                Oui
                                            </div>
                                            <div class="item" data-value="0">
                                                <i class="remove icon"></i>
                                                Non
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui red hidden message"></div>
                                </div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label>Date de la diffusion originale</label>
                                <div class="ui calendar" id="datepicker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input id="diffusion_us" name="diffusion_us" class="date-picker" type="date" placeholder="Date" value="{{ old('diffusion_us') }}">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Date de la diffusion française</label>
                                <div class="ui calendar" id="datepicker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input id="diffusion_fr" name="diffusion_fr" class="date-picker" type="date" placeholder="Date" value="{{ old('diffusion_fr') }}">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label>Chaine(s)</label>
                                <div id="dropdown-chaines" class="ui fluid multiple search selection dropdown">
                                    <input id="channels" name="channels" type="hidden" value="{{ old('channels') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($channels as $channel)
                                            <div class="item" data-value="{{ $channel->name }}">{{ $channel->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Nationalité(s)</label>
                                <div id="dropdown-nationalities" class="ui fluid multiple search selection dropdown">
                                    <input id="nationalities" name="nationalities" type="hidden" value="{{ old('nationalities') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($nationalities as $nationality)
                                            <div class="item" data-value="{{ $nationality->name }}">{{ $nationality->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label>Créateur(s) de la série</label>
                                <div id="dropdown-creators" class="ui fluid multiple search selection dropdown">
                                    <input id="creators" name="creators" type="hidden" value="{{ old('creators') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($actors as $actor)
                                            <div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Genre(s)</label>
                                <div id="dropdown-genres" class="ui fluid multiple search selection dropdown">
                                    <input id="genres" name="genres" type="hidden" value="{{ old('genres') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($genres as $genre)
                                            <div class="item" data-value="{{ $genre->name }}">{{ $genre->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
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
                        <div class="field">
                            <label>Taux érectile</label>
                            <div class="ui left icon input">
                                <input id="taux_erectile" name="taux_erectile" placeholder="Pourcentage..." type="number" value="{{ old('taux_erectile') }}">
                                <i class="percent icon"></i>
                            </div>
                            <div class="ui red hidden message"></div>
                        </div>

                        <div class="field">
                            <label for="avis_rentree">Avis de la rédaction</label>
                            <textarea id="avis_rentree" name="avis_rentree"></textarea>
                            <div class="ui red hidden message"></div>
                        </div>
                    </div>
                    <button class="submit positive ui button" type="submit">Créer la série</button>
                </div>
            </div>
        </div>
    </form>
@endsection

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

            // Suppression d'un acteur
            $(document).on('click', '.remove-actor', function(){
                $(this).parents('.div-actor').remove();
                $(this).find(".actor_name-input").attr( "name", 'actors[' + index + '][name]');
                $(this).find(".actor_role-input").attr( "name", 'actors[' + index + '[role]');
                $(this).find(".actor_name-input").attr( "id", 'actors.' + index + '.name');
                $(this).find(".actor_role-input").attr( "id", 'actors.' + index + '.role');
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
                            + '<label>Nom de l\'acteur</label>'
                            + '<div class="ui fluid search selection dropdown actorDropdown">'
                            + '<input class="actor_name-input" id="actors.'+ actor_number +'.name_actor" name="actors[' + actor_number + '][name_actor]" type="hidden" value="{{ old('guests') }}">'
                            + '<i class="dropdown icon"></i>'
                            + '<div class="default text">Choisir</div>'
                            + '<div class="menu">'
                            + '@foreach($actors as $actor)'
                            + '<div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>'
                            + '@endforeach'
                            + '</div>'
                            + '</div>'
                            + '<div class="ui red hidden message"></div>'
                            + '</div>'

                            + '<div class="field">'
                            + '<label class="actor_role-label">Rôle</label>'
                            + '<input class="actor_role-input" id="actors.'+ actor_number +'.role_actor" name="actors[' + actor_number + '][role_actor]" placeholder="Rôle" type="text" value="{{ old('role_actor') }}">'
                            + '<div class="ui red hidden message"></div>'

                            + '</div>'
                            + '</div>'
                            + '</div>';

                            $(function() {
                                $('.actorDropdown')
                                    .dropdown({
                                        allowAdditions: true,
                                        forceSelection : false,
                                        minCharacters: 4
                                    });
                            });

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
                stop: function(){
                    // Pour chaque item de liste
                    $('#sortableSeasons').find('.seasonBlock').each(function(){
                        // On actualise sa position
                        var seasonIndex = parseInt($(this).index()+1);

                        // On met à jour les infos saisons
                        $(this).find(".seasonName").html('<i class="errorSeason'+ seasonIndex +' dropdown icon"></i>Saison ' + seasonIndex);
                        $(this).find(".content").attr("seasonNumber", seasonIndex);
                        $(this).find(".episodeAdd").attr("id", 'episodeAdd' + seasonIndex );
                        $(this).find(".episodesBlock").attr("id", 'episodes' + seasonIndex );

                        $(this).find(".seasonInputBA").attr("name", 'seasons[' + seasonIndex + '][ba]' );
                        $(this).find(".seasonInputBA").attr("id", 'seasons.' + seasonIndex + '.ba' );

                        $(this).attr( "season", seasonIndex);

                        $(this).find('.episodeBlock').each(function () {
                            $(this).attr("class", 'episodeBlock episode' + seasonIndex);

                            // On actualise sa position
                            var episodeIndex = parseInt($(this).index('.episode' + seasonIndex) + 1);

                            $(this).attr( "episode", episodeIndex);

                            $(this).find(".episodeName").html('<i class="errorEpisode'+ seasonIndex + 'x' + episodeIndex + ' dropdown icon"></i> Episode ' + seasonIndex + '.' + episodeIndex);

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

                            $(this).find(".episodeInputNameEN").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.name');
                            $(this).find(".episodeInputNameFR").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.name_fr');
                            $(this).find(".episodeInputResumeEN").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.resume');
                            $(this).find(".episodeInputResumeFR").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.resume_fr');
                            $(this).find(".episodeInputDiffusionUS").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.diffusion_us');
                            $(this).find(".episodeInputDiffusionFR").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.diffusion_fr');
                            $(this).find(".episodeInputParticularite").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.particularite');
                            $(this).find(".episodeInputBA").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.ba');
                            $(this).find(".episodeInputDirectors").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.directors');
                            $(this).find(".episodeInputWriters").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.writers');
                            $(this).find(".episodeInputGuests").attr("id", 'seasons.'+ seasonIndex +'episodes.' + episodeIndex + '.guests');
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
                    var seasonIndex = parseInt($(this).index()+1);
                    // On la met à jour dans la page
                    $(this).find(".expandableBlock").html('<i class="dropdown icon"></i> Saison '+ seasonIndex);
                    $(this).find(".content").attr("seasonNumber", seasonIndex);
                    $(this).attr( "season", seasonIndex);

                    $(this).find('.episodeBlock').each(function () {
                        $(this).attr("class", 'episodeBlock episode' + seasonIndex);

                        // On actualise sa position
                        var episodeIndex = parseInt($(this).index('.episode' + seasonIndex) + 1);

                        $(this).attr( "episode", episodeIndex);

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

                        $(this).find(".episodeInputNameEN").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.name');
                        $(this).find(".episodeInputNameFR").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.name_fr');
                        $(this).find(".episodeInputResumeEN").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.resume');
                        $(this).find(".episodeInputResumeFR").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.resume_fr');
                        $(this).find(".episodeInputDiffusionUS").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.diffusion_us');
                        $(this).find(".episodeInputDiffusionFR").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.diffusion_fr');
                        $(this).find(".episodeInputParticularite").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.particularite');
                        $(this).find(".episodeInputBA").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.ba');
                        $(this).find(".episodeInputDirectors").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.directors');
                        $(this).find(".episodeInputWriters").attr("id", 'seasons.'+ seasonIndex +'.episodes.' + episodeIndex + '.writers');
                        $(this).find(".episodeInputGuests").attr("id", 'seasons.'+ seasonIndex +'episodes.' + episodeIndex + '.guests');
                    });
                });

                --seasonNumber;
            });

            //Ajout d'une saison
            $('.seasonAdd').click(function(e){
                e.preventDefault();
                var html = '<div class="seasonBlock" season="'+ seasonNumber +'">'
                        + '<div class="title">'
                        + '<div class="ui grid">'
                        + '<div class="twelve wide column middle aligned expandableBlock seasonName">'
                        + '<i class="errorSeason'+ seasonNumber +' dropdown icon"></i>'
                        + 'Saison '+ seasonNumber
                        + '</div>'
                        + '<div class="four wide column">'
                        + '<button class="ui right floated negative basic circular icon button seasonRemove">'
                        + '<i class="remove icon"></i>'
                        + '</button>'
                        + '<button class="ui right floated positive basic circular icon button seasonMove">'
                        + '<i class="move icon"></i>'
                        + '</button>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '<div class="content" seasonNumber=' + seasonNumber + '>'

                        + '<input class="seasonInputNumber" name="seasons[' + seasonNumber + '][number]" type="hidden" value="'+ seasonNumber +'">'

                        + '<div class="field">'
                        + '<label>Bande Annonce</label>'
                        + '<input class="seasonInputBA" name="seasons[' + seasonNumber + '][ba]" placeholder="Bande annonce" type="text" value="{{ old('ba') }}">'
                        + '<div class="ui red hidden message"></div>'
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
                    //Déplacement d'un épisode
                    $('.sortableEpisodes').sortable({
                        axis: "y",
                        connectWith: ".episodesBlock",
                        containment: ".episodesBlock",
                        handle: ".episodeMove",
                        cursor: "grabbing",
                        cancel: '',
                        placeholder: "ui segment fluid portlet-placeholder",
                        // Evenement appelé lorsque l'élément est relaché
                        stop: function(){
                            // Pour chaque item de liste
                            $('.sortableEpisodes').find('.episodeBlock').each(function(){
                                var seasonNumber = $(this).parents('.content').attr('seasonNumber');

                                $(this).attr("class", 'episodeBlock episode' + seasonNumber);

                                // On actualise sa position
                                var episodeIndex = parseInt($(this).index('.episode' + seasonNumber) + 1);

                                // On met à jour les infos épisodes
                                $(this).attr( "season", seasonNumber);
                                $(this).attr( "episode", episodeIndex);

                                $(this).find(".episodeName").html('<i class="errorEpisode'+ seasonNumber + 'x' + episodeIndex + ' dropdown icon"></i> Episode ' + seasonNumber + '.' + episodeIndex);

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

                                $(this).find(".episodeInputNameEN").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.name');
                                $(this).find(".episodeInputNameFR").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.name_fr');
                                $(this).find(".episodeInputResumeEN").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.resume');
                                $(this).find(".episodeInputResumeFR").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.resume_fr');
                                $(this).find(".episodeInputDiffusionUS").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.diffusion_us');
                                $(this).find(".episodeInputDiffusionFR").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.diffusion_fr');
                                $(this).find(".episodeInputParticularite").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.particularite');
                                $(this).find(".episodeInputBA").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.ba');
                                $(this).find(".episodeInputDirectors").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.directors');
                                $(this).find(".episodeInputWriters").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.writers');
                                $(this).find(".episodeInputGuests").attr("id", 'seasons.'+ seasonNumber +'episodes.' + episodeIndex + '.guests');
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
                            var episodeIndex = parseInt($(this).index('.episode' + seasonNumber) +1);

                            // On la met à jour dans la page
                            $(this).attr( "season", seasonNumber);
                            $(this).attr( "episode", episodeIndex);

                            $(this).find(".episodeName").html('<i class="errorEpisode'+ seasonNumber + 'x' + episodeIndex + ' dropdown icon"></i> Episode ' + seasonNumber + '.' + episodeIndex);

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

                            $(this).find(".episodeInputNameEN").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.name');
                            $(this).find(".episodeInputNameFR").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.name_fr');
                            $(this).find(".episodeInputResumeEN").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.resume');
                            $(this).find(".episodeInputResumeFR").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.resume_fr');
                            $(this).find(".episodeInputDiffusionUS").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.diffusion_us');
                            $(this).find(".episodeInputDiffusionFR").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.diffusion_fr');
                            $(this).find(".episodeInputParticularite").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.particularite');
                            $(this).find(".episodeInputBA").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.ba');
                            $(this).find(".episodeInputDirectors").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.directors');
                            $(this).find(".episodeInputWriters").attr("id", 'seasons.'+ seasonNumber +'.episodes.' + episodeIndex + '.writers');
                            $(this).find(".episodeInputGuests").attr("id", 'seasons.'+ seasonNumber +'episodes.' + episodeIndex + '.guests');
                        });
                    });

                    //Ajout d'un episode
                    $('#episodeAdd' + seasonNumber).click(function(e){
                        e.preventDefault();

                        var seasonNumber = $(this).parents('.content').attr('seasonNumber');
                        var episodeNumber =  $('#episodes' + seasonNumber).children('.episodeBlock').length + 1 ; // Nombre d'épisode total

                        var html = '<div class="episodeBlock episode' + seasonNumber +'" season="'+ seasonNumber +'" episode="'+ episodeNumber +'">'
                                + '<div class="title">'
                                + '<div class="ui grid">'
                                + '<div class="twelve wide column middle aligned expandableBlock episodeName">'
                                + '<i class="errorEpisode'+ seasonNumber + 'x' + episodeNumber +' dropdown icon"></i>'
                                + 'Episode ' + seasonNumber + '.' + episodeNumber
                                + '</div>'
                                + '<div class="four wide column">'
                                + '<button class="ui right floated negative basic circular icon button episodeRemove">'
                                + '<i class="remove icon"></i>'
                                + '</button>'
                                + '<button class="ui right floated positive basic circular icon button episodeMove">'
                                + '<i class="move icon"></i>'
                                + '</button>'
                                + '</div>'
                                + '</div>'
                                + '</div>'
                                + '<div class="content">'

                                + '<input class="episodeInputNumber" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][number]" type="hidden" value="'+ episodeNumber +'">'

                                + '<div class="two fields">'
                                + '<div class="field">'
                                + '<label>Nom original</label>'
                                + '<input class="episodeInputNameEN" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.name" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][name]" placeholder="Nom original de l\'épisode" type="text" value="{{ old('name') }}">'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '<div class="field">'
                                + '<label>Nom français</label>'
                                + '<input class="episodeInputNameFR" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.name_fr" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][name_fr]" placeholder="Nom français de l\'épisode" type="text" value="{{ old('name_fr') }}">'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '</div>'

                                + '<div class="two fields">'
                                + '<div class="field">'
                                + '<label>Résumé original</label>'
                                + '<textarea class="episodeInputResumeEN" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.resume" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][resume]" placeholder="Résumé original de l\'épisode" value="{{ old('resume') }}""></textarea>'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '<div class="field">'
                                + '<label>Résumé de l\'épisode</label>'
                                + '<textarea class="episodeInputResumeFR" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.resume_fr" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][resume_fr]" placeholder="Résumé en français de l\'épisode" value="{{ old('resume_fr') }}""></textarea>'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '</div>'

                                + '<div class="two fields">'
                                + '<div class="field">'
                                + '<label>Date de la diffusion originale</label>'
                                + '<div class="ui calendar" id="datepicker">'
                                + '<div class="ui input left icon">'
                                + '<i class="calendar icon"></i>'
                                + '<input class="episodeInputDiffusionUS date-picker" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.diffusion_us" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][diffusion_us]" type="date" placeholder="Date" value="{{ old('diffusion_us') }}">'
                                + '</div>'
                                + '</div>'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '<div class="field">'
                                + '<label>Date de la diffusion française</label>'
                                + '<div class="ui calendar" id="datepicker">'
                                + '<div class="ui input left icon">'
                                + '<i class="calendar icon"></i>'
                                + '<input class="episodeInputDiffusionFR date-picker" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.diffusion_fr" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][diffusion_fr]" type="date" placeholder="Date" value="{{ old('diffusion_fr') }}">'
                                + '</div>'
                                + '</div>'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '</div>'

                                + '<div class="two fields">'
                                + '<div class="field">'
                                + '<label>Particularité</label>'
                                + '<textarea rows="2" class="episodeInputParticularite" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.particularite" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][particularite]" placeholder="Particularité de l\'épisode" value="{{ old('particularite') }}""></textarea>'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '<div class="field">'
                                + '<label>Bande annonce de l\'épisode</label>'
                                + '<input class="episodeInputBA" id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.ba" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][ba]" type="date" placeholder="Bande Annonce de l\'épisode" value="{{ old('ba') }}">'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'
                                + '</div>'

                                + '<div class="three fields">'

                                + '<div class="field">'
                                + '<label>Réalisateur(s) de la série</label>'
                                + '<div class="ui fluid multiple search selection dropdown directorDropdown">'
                                + '<input id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.directors" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][directors]" type="hidden" value="{{ old('directors') }}">'
                                + '<i class="dropdown icon"></i>'
                                + '<div class="default text">Choisir</div>'
                                + '<div class="menu">'
                                + '@foreach($actors as $actor)'
                                + '<div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>'
                                + '@endforeach'
                                + '</div>'
                                + '</div>'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'

                                + '<div class="field">'
                                + '<label>Scénariste(s) de la série</label>'
                                + '<div class="ui fluid multiple search selection dropdown writerDropdown">'
                                + '<input id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.writers" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][writers]" type="hidden" value="{{ old('writers') }}">'
                                + '<i class="dropdown icon"></i>'
                                + '<div class="default text">Choisir</div>'
                                + '<div class="menu">'
                                + '@foreach($actors as $actor)'
                                + '<div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>'
                                + '@endforeach'
                                + '</div>'
                                + '</div>'
                                + '<div class="ui red hidden message"></div>'
                                + '</div>'

                                + '<div class="field">'
                                + '<label>Guest(s) de la série</label>'
                                + '<div class="ui fluid multiple search selection dropdown guestDropdown">'
                                + '<input id="seasons.'+ seasonNumber +'.episodes.' + episodeNumber + '.guests" name="seasons['+ seasonNumber +'][episodes][' + episodeNumber + '][guests]" type="hidden" value="{{ old('guests') }}">'
                                + '<i class="dropdown icon"></i>'
                                + '<div class="default text">Choisir</div>'
                                + '<div class="menu">'
                                + '@foreach($actors as $actor)'
                                + '<div class="item" data-value="{{ $actor->name }}">{{ $actor->name }}</div>'
                                + '@endforeach'
                                + '</div>'
                                + '</div>'
                                + '<div class="ui red hidden message"></div>'
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
                    .done(function () {
                        window.location.href = '{!! route('adminShow.redirectJSON') !!}';
                    })
                    .fail(function (data) {
                        $('.submit').removeClass("loading");

                        $.each(data.responseJSON, function (key, value) {
                            var input = 'input[id="' + key + '"]';

                            $(input + '+div').text(value);
                            $(input + '+div').removeClass("hidden");
                            $(input).parent().addClass('error');

                            if(key.indexOf('actors.') > -1) {
                                $(input).parents('.div-actor').addClass('red');

                                var dataActor = $('.dataActor');

                                $(dataActor).addClass('red');
                                $(dataActor).css('color', '#DB3041');
                            }
                            else if(key.indexOf('seasons.') > -1) {
                                var seasonNumber = $(input).parents('.episodeBlock').attr('season');
                                var episodeNumber = $(input).parents('.episodeBlock').attr('episode');

                                $('.errorSeason' + seasonNumber).addClass('red');
                                $('.errorEpisode' + seasonNumber + 'x' + episodeNumber).addClass('red');

                                var dataSeason = $('.dataSeason');

                                $(dataSeason).addClass('red');
                                $(dataSeason).css('color', '#DB3041');
                            }
                            else if(key.indexOf('rentree.') > -1) {
                                var dataRentree = $('.dataRentree');

                                $(dataRentree).addClass('red');
                                $(dataRentree).css('color', '#DB3041');
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