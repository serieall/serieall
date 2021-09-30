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
        Ajouter une série
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="adminTitre">
        Ajouter une série
        <span class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </span>
    </h1>
    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <form class="ui form" method="POST" action="{{ route('admin.shows.store') }}">
                {{ csrf_field() }}

                <div class="ui teal segment">
                    <h4 class="ui dividing header">Informations sur la série</h4>
                    <div class="field {{ $errors->has('tmdb_id') ? ' error' : '' }}">
                        <label>ID de la série sur TMDB</label>
                        <input name="tmdb_id" placeholder="TMDB ID" type="text" value="{{ old('tmdb_id') }}">

                        @if ($errors->has('tmdb_id'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('tmdb_id') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui blue segment">
                        <h4 class="ui dividing header">Informations sur la diffusion française</h4>
                        <div class="two fields">
                            <div class="field {{ $errors->has('chaine_fr') ? ' error' : '' }}">
                                <label>Chaine française</label>
                                <div id="dropdown-chainefr" class="ui fluid multiple search selection dropdown">
                                    <input name="chaine_fr" type="hidden" value="{{ old('chaine_fr') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                    </div>
                                </div>

                                @if ($errors->has('chaine_fr'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('chaine_fr') }}</strong>
                                    </div>
                                @endif
                                <div class="ui info tiny compact message">
                                    <p>La chaîne principale sera ajoutée automatiquement (par exemple pour Better Call Saul : <strong>AMC</strong>).<br />
                                        En revanche, la chaine française et/ou secondaire (par exemple, <strong>Netflix</strong> pour Better Call Saul) ne sera pas ajoutée.<br />
                                        Il faut donc ajouter les autres chaines manuellement.
                                    </p>
                                </div>
                            </div>

                            <div class="field {{ $errors->has('diffusion_fr') ? ' error' : '' }}">
                                <label>Date de la diffusion française</label>
                                <div class="ui calendar" id="date-picker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input name="diffusion_fr" id="datepicker" type="date" placeholder="Date" value="{{ old('diffusion_fr') }}">
                                    </div>
                                </div>
                                @if ($errors->has('diffusion_fr'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('diffusion_fr') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="ui violet segment">
                        <h4 class="ui dividing header">Informations pour la rentrée</h4>
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
                                <label for="avis_rentree">Avis de la rédaction</label>
                                <textarea id="avis_rentree" name="avis_rentree">{{ old('avis_rentree') }}</textarea>
                                    @if ($errors->has('avis_rentree'))
                                        <div class="ui red message">
                                <strong>{{ $errors->first('avis_rentree') }}</strong>
                                @endif
                            </div>
                        </div>
                    </div>

                    <button class="positive ui button" type="submit">Créer la série</button>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dropdown-chainefr')
                .dropdown({
                    apiSettings: {
                        url: '/api/channels/list?name-lk=*{query}*'
                    },
                    fields: {remoteValues: "data", value: "name"},
                    allowAdditions: true,
                    hideAdditions: false,
                    forceSelection: false,
                    minCharacters: 1
                })
            ;
            $('#datepicker').datepicker({
                showAnim: "blind",
                dateFormat: "yy-mm-dd",
                yearRange: "-100:+10",
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
@endpush
