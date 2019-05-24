@extends('layouts.admin')

@section('pageTitle', 'Admin - Artistes')

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

    <div class="ui grid">
        <div class="ui height wide column">
            <h1 class="ui header" id="adminTitre">
                Acteurs
                <span class="sub header">
                    Les acteurs de "{{ $show->name }}"
                </span>
            </h1>
        </div>
        <div class="ui height wide column">
            <form action="{{ route('admin.artists.create', [$show->id]) }}">
                <button class="ui right floated green button">
                    <i class="ui add icon"></i>
                    Ajouter de nouveaux acteurs
                </button>
            </form>
        </div>
    </div>


    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <div class="ui special five stackable cards">
                @foreach($show->actors as $actor)
                    <div class="card">
                        <div class="blurring dimmable image">
                            <div class="ui dimmer">
                                <div class="content">
                                    <div class="center">
                                        <!-- Formulaire d'édition -->
                                        <form action="{{ route('admin.artists.edit', [$show->id, $actor->id]) }}">
                                            <button class="ui inverted green button">
                                                &Eacute;diter
                                            </button>
                                        </form>
                                        <br />
                                        <br />
                                        <!-- Formulaire de suppression -->
                                        <form action="{{ route('admin.artists.unlinkShow', [$show->id, $actor->id]) }}" method="post" >
                                            {{ csrf_field() }}

                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="ui inverted red button" value="Supprimer cet acteur ?" onclick="return confirm('Voulez-vous vraiment supprimer cet acteur ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <img class="ui tiny image" src="{!! ActorPicture($actor->artist_url) !!}" alt="Photo {{ $artist->name }}"/>
                        </div>
                        <div class="content">
                            <div class="header">
                                {{ $actor->name }}
                            </div>
                            <div class="meta">
                                {{ $actor->pivot['role'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.artistDropdown')
                .dropdown({
                    apiSettings: {
                        url: '/api/artists/list?name-lk=*{query}*'
                    },
                    fields: {remoteValues: "data", value: "name"},
                    allowAdditions: true,
                    hideAdditions: false,
                    forceSelection: false,
                    minCharacters: 2
                })
            ;
            $('.special.cards .image').dimmer({
                on: 'hover'
            });
        });
    </script>
@endpush