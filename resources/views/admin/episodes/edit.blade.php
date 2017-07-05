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
    <a href="{{ route('admin.seasons.show', $show->id) }}" class="section">
        Saisons & Episodes
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Episode {{ $season->name }} x {{ $episode->name }}
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Episode {{ $season->name }} x {{ $episode->name }}
        <span class="sub header">
            Modifier l'épisode {{ $season->name }} x {{ $episode->name }} de "{{ $show->name }}"
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" action="{{ route('admin.episodes.update', $episode->id) }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="PUT">

                    <input type="hidden" name="id" value="{{ $episode->id }}">
                    <input type="hidden" name="season_id" value="{{ $season->id }}">
                    <input type="hidden" name="show_id" value="{{ $show->id }}">
                    <div class="ui two fields">
                        <div class="ui field">
                            <label for="name">Numéro de l'épisode</label>
                            <input id="name" name="name" type="number" value="{{ $episode->numero }}">
                            <div class="ui red hidden message"></div>
                        </div>
                        <div class="ui field">
                            <label for="ba">Bande Annonce</label>
                            <input type="text" id="ba" name="ba" value="{{ $episode->ba }}">
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
        $('.ui.styled.fluid.accordion')
            .accordion({
                selector: {
                    trigger: '.expandableBlock'
                },
            })
        ;
    </script>
@endsection