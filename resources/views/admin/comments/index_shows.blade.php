@extends('layouts.admin')

@section('pageTitle', 'Admin - Utilisateurs')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Commentaires
    </div>
@endsection

@section('content')
    <div class="ui grid">
        <div class="ui height wide column">
            <h1 class="ui header" id="adminTitre">
                Modérer les avis de séries/saisons/épisodes
            </h1>
        </div>
    </div>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <div class="ui form">
                    <div class="ui three fields">
                        <div class="ui field">
                            <label for="show">Choisir la série</label>
                            <div id="dropdownShow" class="ui search selection dropdown">
                                <input id="inputShow" name="show" type="hidden" value="{{ old('show') }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Série</div>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                        <div class="ui field">
                            <label for="season">Choisir la saison</label>
                            <div id="dropdownSeason" class="ui search selection dropdown">
                                <input id="inputSeason" name="season" type="hidden" value="{{ old('season') }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Saison</div>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                        <div class="ui field">
                            <label for="episode">Choisir l'épisode</label>
                            <div id="dropdownEpisode" class="ui fluid search selection dropdown">
                                <input id="inputEpisode" name="episode" type="hidden" value="{{ old('episode') }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Episode</div>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="comment" class="ui segment">
                @include('admin.comments.info_message')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{Html::script('js/views/admin/comments/index.js')}}
@endpush