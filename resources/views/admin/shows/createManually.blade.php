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

    <div class="ui centered grid">
        <div class="ten wide column segment">
            <div class="ui pointing secondary menu">
                <a class="item active" data-tab="first">Série</a>
                <a class="item" data-tab="second">Acteurs</a>
                <a class="item" data-tab="third">Saisons & épisodes</a>
            </div>
            <div class="ui tab teal segment active" data-tab="first">
                <h4 class="ui dividing header">Informations générales sur la série</h4>
            </div>
            <div class="ui tab blue segment" data-tab="second">
                <h4 class="ui dividing header">Ajouter un ou plusieurs acteurs</h4>
            </div>
            <div class="ui tab red segment" data-tab="third">
                <h4 class="ui dividing header">Ajouter les saisons et les épisodes</h4>
            </div>
        </div>
    </div>

    <script>
        $('.menu .item')
                .tab()
        ;
    </script>
@endsection