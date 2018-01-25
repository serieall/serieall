@extends('layouts.admin')

@section('pageTitle', 'Admin - Saisons')

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
    <a href="{{ route('admin.seasons.show', $season->show->id) }}" class="section">
        Saisons & Episodes
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Saison {{ $season->name }}
    </div>
@endsection

@section('content')

    <div class="ui grid">
        <div class="ui height wide column">
            <h1 class="ui header" id="adminTitre">
                Saison {{ $season->name }}
                <span class="sub header">
                    Modifier la saison {{ $season->name }} de "{{ $season->show->name }}"
                </span>
            </h1>
        </div>
        <div class="ui height wide column">
            <form action="{{ route('admin.episodes.create', $season->id) }}">
                <button class="ui right floated green button">
                    <i class="ui add icon"></i>
                    Ajouter de nouveaux épisodes
                </button>
            </form>
        </div>
    </div>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" action="{{ route('admin.seasons.update', $season->id) }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="PUT">

                    <input type="hidden" name="id" value="{{ $season->id }}">
                    <input type="hidden" name="show_id" value="{{ $season->show->id }}">
                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('name') ? ' error' : '' }}">
                            <label for="name">Numéro de la saison</label>
                            <input id="name" name="name" type="number" value="{{ $season->name }}" min="0">

                            @if ($errors->has('name'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="ui field {{ $errors->has('ba') ? ' error' : '' }}">
                            <label for="ba">Bande Annonce</label>
                            <input id="ba" name="ba" value="{{ $season->ba }}">

                            @if ($errors->has('ba'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('ba') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button class="ui green button">Modifier</button>
                </form>
            </div>

            <div class="ui segment">
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
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.ui.styled.fluid.accordion')
                .accordion({
                    selector: {
                        trigger: '.expandableBlock'
                    }
                })
            ;
        });
    </script>
@endsection