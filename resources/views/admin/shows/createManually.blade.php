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

    <form class="ui form" method="POST" action="{{ route('adminShow.store') }}">
        {{ csrf_field() }}

        <div class="ui centered grid">
            <div class="ten wide column segment">
                <div class="ui pointing secondary menu">
                    <a class="item active" data-tab="first">Série</a>
                    <a class="item" data-tab="second">Acteurs</a>
                    <a class="item" data-tab="third">Saisons & épisodes</a>
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
                            <br />
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
                    </div>

                    <div class="ui tab violet segment active">
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
                    </div>
                </div>
                <div class="ui tab blue segment" data-tab="second">
                    <h4 class="ui dividing header">Ajouter un ou plusieurs acteurs</h4>
                </div>
                <div class="ui tab red segment" data-tab="third">
                    <h4 class="ui dividing header">Ajouter les saisons et les épisodes</h4>

                </div>
            </div>
        </div>
    </form>

    <script>
        $('#dropdown-encours')
                .dropdown({
                })
        ;

        $('.menu .item')
                .tab()
        ;
    </script>
@endsection