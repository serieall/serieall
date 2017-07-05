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
        Saisons & Episodes
    </div>
@endsection

@section('content')

    <div class="ui grid">
        <div class="ui height wide column">
            <h1 class="ui header" id="admin-titre">
                Saisons & Episodes
                <div class="sub header">
                    Les saisons et épisodes de "{{ $show->name }}"
                </div>
            </h1>
        </div>
        <div class="ui height wide column">
            <form action="{{ route('admin.seasons.create', [$show->id]) }}" method="get" >
                <button class="ui right floated green button" type="submit">
                    <i class="ui add icon"></i>
                    Ajouter une nouvelle saison
                </button>
            </form>
        </div>
    </div>


    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <div class="ui fluid styled accordion seasonsBlock" id="sortableSeasons">
                    @foreach($seasons as $season)
                        <div class="title">
                            <div class="ui grid">
                                <div class="twelve wide column middle aligned expandableBlock seasonName">
                                    <i class="errorSeason' + seasonNumber + ' dropdown icon"></i>
                                    Saison {{ $season->name }}
                                </div>
                                <div class="four wide column">
                                    <form action="{{ route('admin.seasons.destroy', [$season->id]) }}" method="post" >
                                        {{ csrf_field() }}

                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="ui right floated red circular icon button seasonRemove" value="Supprimer cette saison ?" onclick="return confirm('Voulez-vous vraiment supprimer cette saison et les épisodes liés ?')">
                                            <i class="remove icon"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.seasons.edit', [$show->id, $season->id]) }}" method="get" >

                                        <button class="ui right floated blue circular icon button" type="submit">
                                            <i class="edit icon"></i>
                                        </button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        <div class="content">
                            <div class="accordion transition hidden episodesBlock sortableEpisodes">
                                @foreach($season->episodes as $episode)
                                    <div class="episodeBlock">
                                        <div class="title">
                                            <div class="ui grid">
                                                <div class="twelve wide column middle aligned episodeName">
                                                    <i class="dropdown icon"></i>
                                                    Episode {{  $season->name }} x {{ $episode->numero }} - {{ $episode->name }}
                                                </div>
                                                <div class="four wide column">
                                                    <form action="{{ route('admin.episodes.destroy', [$episode->id]) }}" method="post" >
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button class="ui right floated red circular icon button episodeRemove" value="Supprimer cet épisode ?" onclick="return confirm('Voulez-vous vraiment supprimer cet épisode ?')">
                                                            <i class="remove icon"></i>
                                                        </button>
                                                    </form>
                                                    <button class="ui right floated blue circular icon button episodeMove">
                                                        <i class="edit icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
        $('.ui.styled.fluid.accordion.seasonsBlock')
            .accordion({
                selector: {
                    trigger: '.expandableBlock'
                },
                exclusive: true
            })
        ;
    </script>
@endsection