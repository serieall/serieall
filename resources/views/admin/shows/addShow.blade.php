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

                @if (session('status'))
                    <div class="ui success message">
                        <i class="close icon"></i>
                        <div class="header">
                            {{ session('status_header') }}
                        </div>
                        <p>{{ session('status_message') }}</p>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="ui warning message">
                        <i class="close icon"></i>
                        <div class="header">
                            {{ session('warning_header') }}
                        </div>
                        <p>{{ session('warning_message') }}</p>
                    </div>
                @endif

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
                        <div id="dropdown-nationalites" class="ui fluid multiple search selection dropdown">
                            <input name="nationalities" type="hidden">
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
                            <input name="creators" type="hidden">
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

                <div class="two fields">
                    <div class="field {{ $errors->has('chaine_fr') ? ' error' : '' }}">
                        <label>Chaine française</label>
                        <div id="dropdown-chainefr" class="ui fluid multiple search selection dropdown">
                            <input name="chaine_fr" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Choisir</div>
                            <div class="menu">
                                @foreach($channels as $channel)
                                    <div class="item" data-value="{{ $channel->name }}">{{ $channel->name }}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="ui info tiny compact message">
                            <p>La chaîne principale sera ajoutée automatiquement (par exemple pour Better Call Saul : <strong>AMC</strong>).<br />
                               En revanche, la chaine française et/ou secondaire (par exemple, <strong>Netflix</strong> pour Better Call Saul) ne sera pas ajoutée. Il faut donc l'ajouter manuellement.
                            </p>
                        </div>

                        @if ($errors->has('chaine_fr'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('chaine_fr') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="field {{ $errors->has('diffusion_fr') ? ' error' : '' }}">
                        <label>Date de la diffusion française</label>
                        <div class="ui calendar" id="date-picker">
                            <div class="ui input left icon">
                                <i class="calendar icon"></i>
                                <input type="text" placeholder="Date">
                            </div>
                        </div>
                        @if ($errors->has('diffusion_fr'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('diffusion_fr') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <button class="positive ui button" type="submit">Créer la série</button>
            </form>
        </div>
    </div>

    @section('scripts')

    @endsection


@endsection