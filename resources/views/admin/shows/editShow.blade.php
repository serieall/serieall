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
    <div class="active section">
        Editer une série manuellement
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Editer une série manuellement
        <span class="sub header">
            Attention, une édition manuelle d'une série pourrait être écrasée lors de la mise à jour quotidienne via theTVDB.
        </span>
    </h1>

    <form class="ui form" method="POST" action="{{ route('admin.shows.updateShow') }}">
        {{ csrf_field() }}

        <div class="ui centered grid">
            <div class="ten wide column segment">
                <div class="ui pointing secondary menu">
                    <a class="dataShow item active" data-tab="first">Série</a>
                    <a class="dataActor item" data-tab="second">Acteurs</a>
                    <a class="dataRentree item" data-tab="three">Rentrée</a>
                </div>
                <div class="ui tab active" data-tab="first">
                    <div class="ui teal segment">
                        <h4 class="ui dividing header">Informations générales sur la série</h4>
                        <div class="two fields">
                            <div class="field">
                                <label>Nom original de la série</label>
                                <input id="name" name="name" placeholder="Nom original de la série" type="text" value="{{ $show->name }}">
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Nom français de la série</label>
                                <input id="name_fr" name="name_fr" placeholder="Nom français" type="text" value="{{ $show->name_fr }}">
                                <div class="ui red hidden message"></div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label for="resume">Résumé</label>
                                <textarea id="resume" name="resume">{{ $show->synopsis_fr }}</textarea>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="two fields field">
                                <div class="field">
                                    <label>Format</label>
                                    <div class="ui left icon input">
                                        <input id="format" name="format" placeholder="Format de la série..." type="number" value="{{ $show->format }}">
                                        <i class="tv icon"></i>
                                    </div>
                                    <div class="ui red hidden message"></div>
                                </div>

                                <div class="field">
                                    <label>Série en cours</label>
                                    <div id="dropdown-encours" class="ui fluid search selection dropdown">
                                        <input name="encours" type="hidden" value="{{ $show->encours }}">
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
                                        <input id="diffusion_us" name="diffusion_us" class="date-picker" type="date" placeholder="Date" value="{{ $show->diffusion_us }}">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Date de la diffusion française</label>
                                <div class="ui calendar" id="datepicker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input id="diffusion_fr" name="diffusion_fr" class="date-picker" type="date" placeholder="Date" value="{{ $show->diffusion_fr }}">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label>Chaine(s)</label>
                                <div id="dropdown-chaines" class="ui fluid multiple search selection dropdown">
                                    <input id="channels" name="channels" type="hidden" value="{{ $channels }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Nationalité(s)</label>
                                <div id="dropdown-nationalities" class="ui fluid multiple search selection dropdown">
                                    <input id="nationalities" name="nationalities" type="hidden" value="{{ $nationalities }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label>Créateur(s) de la série</label>
                                <div id="dropdown-creators" class="ui fluid multiple search selection dropdown">
                                    <input id="creators" name="creators" type="hidden" value="{{ $creators }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                            </div>

                            <div class="field">
                                <label>Genre(s)</label>
                                <div id="dropdown-genres" class="ui fluid multiple search selection dropdown">
                                    <input id="genres" name="genres" type="hidden" value="{{ $genres }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
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
                        <button class="ui basic button add-artist">
                            <i class="user icon"></i>
                            Ajouter un acteur
                        </button>
                        <br />
                    </p>

                    <div class="div-artists">
                        @foreach($show->actors as $actor)
                            <div class="ui segment div-artist">
                                <button class="ui right floated negative basic circular icon button remove-artist">
                                    <i class="remove icon"></i>
                                    </button>
                                <div class="two fields">
                                    <div class="field">
                                        <label>Nom de l'acteur</label>
                                        <div class="ui fluid search selection dropdown artistDropdown">
                                            <input class="artist_name-input" id="artists.'. {{ $actor->id }} .'.name_artist" name="artists[' . {{ $actor->id }} . '][name_artist]" type="hidden" value="{{ $actor->name }}">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Choisir</div>
                                            <div class="menu">
                                            </div>
                                        </div>
                                        <div class="ui red hidden message"></div>
                                    </div>

                                    <div class="field">
                                        <label class="artist_role-label">Rôle</label>
                                        <input class="artist_role-input" id="artists.'. {{ $actor->id }} .'.role_artist" name="artists['. {{ $actor->id }} .'][role_artist]" placeholder="Rôle" type="text" value="{{ $actor->role }}">
                                        <div class="ui red hidden message"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="ui tab violet segment" data-tab="three">
                    <h4 class="ui dividing header">Informations sur la rentrée</h4>
                    <div class="two fields">
                        <div class="field">
                            <label>Taux érectile</label>
                            <div class="ui left icon input">
                                <input id="taux_erectile" name="taux_erectile" placeholder="Pourcentage..." type="number" value="{{ $show->taux_erectile }}">
                                <i class="percent icon"></i>
                            </div>
                            <div class="ui red hidden message"></div>
                        </div>

                        <div class="field">
                            <label for="avis_rentree">Avis de la rédaction</label>
                            <textarea id="avis_rentree" name="avis_rentree">{{ $show->avis_rentree }}</textarea>
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
                apiSettings: {
                    url: '/api/artists/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
                allowAdditions: true,
                forceSelection : false,
                minCharacters: 2
            })
        ;
        $('#dropdown-genres')
            .dropdown({
                apiSettings: {
                    url: '/api/genres/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
                allowAdditions: true,
                forceSelection : false
            })
        ;
        $('#dropdown-chaines')
            .dropdown({
                apiSettings: {
                    url: '/api/channels/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
                allowAdditions: true,
                forceSelection : false
            })
        ;

        $('#dropdown-nationalities')
            .dropdown({
                apiSettings: {
                    url: '/api/nationalities/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
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

        $('.artistDropdown')
            .dropdown({
                apiSettings: {
                    url: '/api/artists/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
                allowAdditions: true,
                forceSelection : false,
                minCharacters: 2
            });
    </script>
@endsection
