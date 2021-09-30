@extends('layouts.admin')

@section('pageTitle', 'Admin - Séries')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Séries
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="adminTitre">
                    Séries
                    <span class="sub header">
                        Liste de toutes les séries présentes sur Série-All
                    </span>
                </h1>
            </div>
            <div class="ui height wide column">
                <div class="ui right floated green fade dropdown button">
                    <span class="text">Ajouter une nouvelle série</span>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href={{ route('admin.shows.create') }}><i class="cloud download icon"></i> Création via TMDB</a>
                        <a class="item" href={{ route('admin.shows.create.manually') }}><i class="signup icon"></i> Création manuelle</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui centered grid">
            <div class="fifteen wide column segment">
                <div class="ui segment">
                    <div class="ui form">
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
                    </div>
                </div>
                <div id="show" class="ui segment">
                    @component('components.message_simple')
                        @slot('type')
                            info
                        @endslot

                        Pas de série à afficher.
                    @endcomponent
                </div>
            </div>
        </div>

@endsection

@push('scripts')
    {{Html::script('js/views/admin/shows/index.js')}}
@endpush

