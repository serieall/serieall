@extends('layouts.admin')

@section('pageTitle', 'Admin - Séries')

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
        {{ $show->name }}
    </div>
@endsection

@section('content')
    <div class="ui grid">
        <div class="ui height wide column">
            <h1 class="ui header" id="adminTitre">
                Editer une série manuellement
                <span class="sub header">
                    Remplir le formulaire ci-dessous pour modifier la série. Attention, une modification manuelle pourrait être écrasée par la mise à jour quotidienne en provenance de TheTVDB.
                </span>
            </h1>
        </div>
        <div class="ui height wide column">
            <div class="ui height wide column">
                <a href="{{ route('show.fiche', $show->show_url) }}">
                    <button class="ui right floated blue button" title="Voir la fiche">
                        <i class="ui eye icon"></i>
                        Voir la fiche de la série
                    </button>
                </a>
            </div>
        </div>
    </div>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui huge three buttons">
                <button class="fluid ui blue button" onclick="window.location.href='{{ route('admin.artists.show', $show->id) }}'">Modifier les acteurs de la série</button>
                <button class="fluid ui teal button" onclick="window.location.href='{{ route('admin.seasons.show', $show->id) }}'">Modifier les saisons et les épisodes</button>
                <!-- Formulaire de suppression -->
                <form action="{{ route('admin.shows.updateoneshowfromtvdb', $show->thetvdb_id) }}" method="post" >
                    {{ csrf_field() }}
                    <button class="fluid ui orange button" title="Forcer la mise à jour">Forcer la mise à jour depuis TVDB</button>
                </form>
            </div>

            <div class="ui segment">
                <form class="ui form" method="POST" action="{{ route('admin.shows.update.manually') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="id" value="{{ $show->id }}">

                    <div class="two fields">
                        <div class="ui raised small image {{ $errors->has('poster') ? ' error' : '' }}">
                                <img src="{{ chooseImage($show->show_url, "poster", "170_250") }}">
                                <label for="poster" class="ui blue ribbon label" style="cursor: pointer" tabindex="0">
                                    <i class="ui upload icon"></i>
                                    Modifier le poster
                                </label>
                                <input id="poster" name="poster" type="file" style="display: none">
                                @if ($errors->has('poster'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('poster') }}</strong>
                                    </div>
                                @endif
                        </div>
                        {{-- <div class="field"></div> --}}
                        <div class="field">
                            <div class="ui raised image {{ $errors->has('banner') ? ' error' : '' }}">
                                <img src="{{ chooseImage($show->show_url, "banner", "950_230") }}">
                                <label for="banner" class="ui blue right ribbon label" style="cursor: pointer" tabindex="0">
                                    <i class="ui upload icon"></i>
                                    Modifier la bannière
                                </label>
                                <input id="banner" name="banner" type="file" style="display: none">
                                @if ($errors->has('banner'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('banner') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="three fields">
                        <div class="field {{ $errors->has('name') ? ' error' : '' }}">
                            <label>Nom original de la série</label>
                            <input id="name" name="name" placeholder="Nom original de la série" value="{{ $show->name }}">
                            @if ($errors->has('name'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('name_fr') ? ' error' : '' }}">
                            <label>Nom français de la série</label>
                            <input id="name_fr" name="name_fr" placeholder="Nom français" value="{{ $show->name_fr }}">
                            @if ($errors->has('name_fr'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('name_fr') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="@if(Auth::user()->role >= 2) disabled @endif field {{ $errors->has('thetvdb_id') ? ' error': '' }}">
	                    <label>TVDB ID</label>
                            <input id="thetvdb_id" name="thetvdb_id" placeholder="The TVDB ID" value="{{ $show->thetvdb_id }}">
                            @if ($errors->has('thetvdb_id'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('thetvdb_id') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="field {{ $errors->has('resume_en') ? ' error' : '' }}">
                            <label for="resume_en">Résumé anglais</label>
                            <textarea id="resume_en" name="resume_en">{{ $show->synopsis }}</textarea>
                            @if ($errors->has('resume_en'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('resume_fr') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('resume_fr') ? ' error' : '' }}">
                            <label for="resume_fr">Résumé français</label>
                            <textarea id="resume_fr" name="resume_fr">{{ $show->synopsis_fr }}</textarea>
                            @if ($errors->has('resume_fr'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('resume_fr') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="two fields field">
                            <div class="field {{ $errors->has('format') ? ' error' : '' }}">
                                <label>Format</label>
                                <div class="ui left icon input">
                                    <input id="format" name="format" placeholder="Format de la série..." type="number" min="0" value="{{ $show->format }}">
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
                                @if ($errors->has('encours'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('encours') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="ui field {{ $errors->has('particularite') ? ' error' : '' }}">
                            <label for="particularite">Particularité</label>
                            <input id="particularite" name="particularite" value="{{ $show->particularite }}">

                            @if ($errors->has('particularite'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('particularite') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="field {{ $errors->has('diffusion_us') ? ' error' : '' }}">
                            <label>Date de la diffusion originale</label>
                            <div class="ui calendar" id="datepicker">
                                <div class="ui input left icon">
                                    <i class="calendar icon"></i>
                                    <input id="diffusion_us" name="diffusion_us" class="date-picker" type="date" placeholder="Date"
                                    @if(!is_null($show->diffusion_us))
                                            value="{{ $show->diffusion_us }}"
                                    @endif>
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
                                    <input id="diffusion_fr" name="diffusion_fr" class="date-picker" type="date" placeholder="Date"
                                    @if(!is_null($show->diffusion_fr))
                                        value="{{ $show->diffusion_fr }}"
                                    @endif>
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
                                <input id="channels" name="channels" type="hidden" value="{{ $channels }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
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
                                <input id="nationalities" name="nationalities" type="hidden" value="{{ $nationalities }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
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
                                <input id="creators" name="creators" type="hidden" value="{{ $creators }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
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
                                <input id="genres" name="genres" type="hidden" value="{{ $genres }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                </div>
                            </div>
                            @if ($errors->has('genres'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('genres') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="field {{ $errors->has('taux_erectile') ? ' error' : '' }}">
                            <label>Taux érectile</label>
                            <div class="ui left icon input">
                                <input id="taux_erectile" name="taux_erectile" placeholder="Pourcentage..." type="number" value="{{ $show->taux_erectile }}">
                                <i class="percent icon"></i>
                            </div>
                            @if ($errors->has('taux_erectile'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('taux_erectile') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('avis_rentree') ? ' error' : '' }}">
                            <label for="avis_rentree">Avis de la rédaction</label>
                            <textarea id="avis_rentree" name="avis_rentree">{{ $show->avis_rentree }}</textarea>
                            @if ($errors->has('avis_rentree'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('avis_rentree') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button class="submit positive ui button">Modifier la série</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dropdown-creators')
                .dropdown({
                    apiSettings: {
                        url: '/api/artists/list?name-lk=*{query}*'
                    },
                    fields: {remoteValues: "data", value: "name"},
                    allowAdditions: true,
                    hideAdditions: false,
                    forceSelection: false,
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
                    hideAdditions: false,
                    forceSelection: false
                })
            ;
            $('#dropdown-chaines')
                .dropdown({
                    apiSettings: {
                        url: '/api/channels/list?name-lk=*{query}*'
                    },
                    fields: {remoteValues: "data", value: "name"},
                    allowAdditions: true,
                    hideAdditions: false,
                    forceSelection: false
                })
            ;

            $('#dropdown-nationalities')
                .dropdown({
                    apiSettings: {
                        url: '/api/nationalities/list?name-lk=*{query}*'
                    },
                    fields: {remoteValues: "data", value: "name"},
                    allowAdditions: true,
                    hideAdditions: false,
                    forceSelection: false
                })
            ;

            $('.date-picker').datepicker({
                showAnim: "blind",
                dateFormat: "yy-mm-dd",
                yearRange: "-100:+10",
                changeMonth: true,
                changeYear: true
            });

            $('#dropdown-encours')
                .dropdown({})
            ;
        });
    </script>
@endpush
