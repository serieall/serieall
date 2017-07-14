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
    <a href="{{ route('admin.shows.edit', $season->show->id) }}" class="section">
        {{ $season->show->name }}
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.seasons.edit', $season->id) }}" class="section">
        Saison {{ $season->name }}
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter de nouveaux épisodes
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter de nouveaux épisodes
        <span class="sub header">
            Ajouter de nouveaux épisodes dans la saison {{ $season->name }} de "{{ $season->show->id }}"
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <p>
                    <button class="ui basic button add-artist">
                        <i class="user icon"></i>
                        Ajouter un acteur
                    </button>
                    <br />
                </p>

                <form class="ui form" action="{{ route('admin.episodes.store', $show->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="season_id" value="{{ $season->id }}">

                    <div class="div-seasons">

                    </div>

                    <p></p>
                    <button class="submit positive ui button" type="submit">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection