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
    <div class="active section">
        Acteurs
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Les acteurs de "{{ $show->name }}"
        <span class="sub header">
            Liste des acteurs
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <div class="ui special five stackable cards">
                @foreach($actors as $actor)
                    <div class="card">
                        <div class="blurring dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                        <div class="ui inverted button">Modifier la photo</div>
                                    </div>
                                </div>
                            </div>
                            @if(file_exists(public_path() . "$folderActors" . "$actor->artist_url.jpg"))
                                <img class="right floated mini ui image" src="{{ $folderActors }}{{ $actor->artist_url }}.jpg" />
                            @else
                                <img class="right floated mini ui image" src="{{ $folderActors }}default_empty.jpg" />
                            @endif
                        </div>
                        <div class="content">
                            <div class="header">
                                {{ $actor->name }}
                            </div>
                            <form class="ui form" method="POST" action="{{ route('admin.artists.update', $actor->id) }}">
                                <div class="meta">
                                    <label class="artist_role-label">As</label>
                                    <input name="role" placeholder="Rôle" type="text" value="{{ $actor->pivot['role'] }}">
                                    <div class="ui red hidden message"></div>
                                </div>

                                <button type="submit">Envoyer</button>
                            </form>
                        </div>
                        <div class="extra content">
                            <div class="ui two buttons">
                                <div class="ui basic green button">Mettre à jour</div>
                                <div class="ui basic red button">Supprimer</div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.artistDropdown')
            .dropdown({
                apiSettings: {
                    url: '/api/artists/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
                allowAdditions: true,
                forceSelection : false,
                minCharacters: 2
            })
        ;
        $('.special.cards .image').dimmer({
            on: 'hover'
        });
    </script>
@endsection