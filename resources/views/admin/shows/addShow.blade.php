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
        Ajouter une série
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter une série
        <div class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </div>
    </h1>
    <div class="ui centered grid">
        <div class="ten wide column segment">
            <form class="ui form" method="POST" action="{{ route('adminShow.store') }}">
                {{ csrf_field() }}

                <div class="ui teal segment">
                    <h4 class="ui dividing header">Informations sur la série</h4>
                    <div class="field {{ $errors->has('thetvdb_id') ? ' error' : '' }}">
                        <label>ID de la série sur TheTVDB</label>
                        <input name="thetvdb_id" placeholder="TheTVDB ID" type="text" value="{{ old('thetvdb_id') }}">

                        @if ($errors->has('thetvdb_id'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('thetvdb_id') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="two fields">
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

                        <div class="field {{ $errors->has('creators') ? ' error' : '' }}">
                            <label>Créateur(s) de la série</label>
                            <div id="dropdown-creators" class="ui fluid multiple search selection dropdown">
                                <input name="creators" type="hidden" value="{{ old('creators') }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                    @foreach($artists as $artist)
                                        <div class="item" data-value="{{ $artist->name }}">{{ $artist->name }}</div>
                                    @endforeach
                                </div>
                            </div>

                            @if ($errors->has('creators'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('creators') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
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
                                    @foreach($channels as $channel)
                                        <div class="item" data-value="{{ $channel->name }}">{{ $channel->name }}</div>
                                    @endforeach
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
                            <label>Avis de la rédaction</label>
                            <textarea name="avis_rentree" value="{{ old('avis_rentree') }}"></textarea>

                                @if ($errors->has('avis_rentree'))
                                    <div class="ui red message">
                            <strong>{{ $errors->first('avis_rentree') }}</strong>
                            @endif
                        </div>
                    </div>
                </div>

                <button class="positive ui button" type="submit">Créer la série</button>
            </div>
            </form>
        </div>
    </div>

    <script>
        @yield('scripts')

        $('.dropdown')
                .dropdown()
        ;

        $('.message .close')
                .on('click', function() {
                    $(this)
                            .closest('.message')
                            .transition('fade')
                    ;
                })
        ;

        $('#dropdown-creators')
                .dropdown({
                    allowAdditions: true,
                    forceSelection : false,
                    minCharacters : 5
                })
        ;
        $('#dropdown-genres')
                .dropdown({
                    allowAdditions: true,
                    forceSelection : false,
                    minCharacters : 5
                })
        ;
        $('#dropdown-chainefr')
                .dropdown({
                    allowAdditions: true,
                    forceSelection : false,
                    minCharacters : 5
                })
        ;

        $('#dropdown-nationalities')
                .dropdown({
                    allowAdditions: true,
                    forceSelection : false,
                    minCharacters : 5
                })
        ;

        $( "#datepicker" ).datepicker({
            showAnim: "blind",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });
    </script>
@endsection