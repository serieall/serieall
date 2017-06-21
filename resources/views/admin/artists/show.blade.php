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
        <div class="ten wide column segment">
            <div class="ui segment">
                @foreach($actors as $actor)
                    <form class="ui form" method="POST" action="{{ route('admin.artists.update', $actor->id) }}">
                        <div class="two fields">
                            <div class="field">
                                <label>Nom de l'acteur</label>
                                <div class="ui fluid search selection dropdown artistDropdown">
                                    <input name="name" type="hidden" value="{{ $actor->name }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                    </div>
                                </div>
                                <div class="ui red hidden message"></div>
                                </div>
                            <div class="field">
                                <label>Rôle</label>
                                <input name="role" placeholder="Rôle" type="text" value="{{ $actor->role }}">
                                <div class="ui red hidden message"></div>

                                </div>
                            </div>
                    </form>
                @endforeach
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
    </script>
@endsection