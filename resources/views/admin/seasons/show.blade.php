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
                <span class="sub header">
                    Les saisons et épisodes de "{{ $show->name }}"
                </span>
            </h1>
        </div>
        <div class="ui height wide column">
            <form action="{{ route('admin.seasons.create', [$show->id]) }}">
                <button class="ui right floated green button">
                    <i class="ui add icon"></i>
                    Ajouter de nouvelles saisons
                </button>
            </form>
        </div>
    </div>


    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <div class="ui fluid styled accordion seasonsBlock" id="sortableSeasons">
                    @foreach($show->seasons as $season)
                        <div class="title">
                            <div class="ui grid">
                                <div class="twelve wide column middle aligned seasonName">
                                    <span class="expandableBlock">
                                        Voir les épisodes
                                        <i class="dropdown icon"></i>
                                    </span>
                                    <a href="{{ route('admin.seasons.edit', [$season->id]) }}">Saison {{ $season->name }}</a>
                                </div>
                                <div class="four wide column">
                                    <form action="{{ route('admin.seasons.destroy', [$season->id]) }}" method="post" >
                                        {{ csrf_field() }}

                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="ui right floated red circular icon button seasonRemove" value="Supprimer cette saison ?" onclick="return confirm('Voulez-vous vraiment supprimer cette saison et les épisodes liés ?')">
                                            <i class="remove icon"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <table class="ui selectable table">
                                @foreach($season->episodes as $episode)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.episodes.edit', $episode->id) }}">Episode {{  $season->name }} x {{ $episode->numero }} - {{ $episode->name }}</a>
                                        </td>
                                        <td class="right aligned">
                                            <form action="{{ route('admin.episodes.destroy', [$episode->id]) }}" method="post" >
                                             {{ csrf_field() }}

                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="ui red circular icon button" value="Supprimer cet épisode ?" onclick="return confirm('Voulez-vous vraiment supprimer cet épisode ?')">
                                                   <i class="remove icon"></i>
                                             </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
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