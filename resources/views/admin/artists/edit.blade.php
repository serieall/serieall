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
    <a href="{{ route('admin.shows.edit', $show->id) }}" class="section">
        {{ $show->name }}
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.artists.show', $show->id) }}" class="section">
        Acteurs
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        {{ $artist->name }}
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        {{ $artist->name }}
        <span class="sub header">
            Modifier le rôle de {{ $artist->name }} dans {{ $show->name }}
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" action="{{ route('admin.artists.update', [$show->id, $artist->id]) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="show_id" value="{{ $show->id }}">
                    <input type="hidden" name="artist_id" value="{{ $artist->id }}">

                    <div class="ui two fields">
                        <img class="ui small left floated image" src="{{ ActorPicture($artist->artist_url) }}" alt="Photo {{ $artist->name }}">
                        <div class="ui field">
                            <label for="image">Photo de l'actrice</label>
                            <input id="image" name="image" type="file">
                        </div>
                        <div class="ui field">
                            <label for="role">Rôle</label>
                            <input type="text" id="role" name="role" value="{{ $artist->pivot['role'] }}">
                        </div>
                    </div>
                    <button class="ui green button" type="submit">Modifier</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    </script>
@endsection