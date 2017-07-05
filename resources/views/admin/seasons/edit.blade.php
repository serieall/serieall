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
        Saison {{ $season->name }}
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Saison {{ $season->name }}
        <span class="sub header">
            Modifier la saison {{ $season->name }} de "{{ $show->name }}"
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" action="{{ route('admin.seasons.update', $season->id) }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="PUT">

                    <input type="hidden" name="id" value="{{ $season->id }}">
                    <input type="hidden" name="show_id" value="{{ $show->id }}">
                    <div class="ui two fields">
                        <div class="ui field">
                            <label for="name">Numéro de la saison</label>
                            <input id="name" name="name" type="number" value="{{ $season->name }}">
                            <div class="ui red hidden message"></div>
                        </div>
                        <div class="ui field">
                            <label for="ba">Bande Annonce</label>
                            <input type="text" id="ba" name="ba" value="{{ $season->ba }}">
                        </div>
                    </div>
                    <button class="ui green button" type="submit">Modifier</button>
                </form>
            </div>

            <div class="ui segment">
                <div class="ui fluid styled accordion">
                    <div class="active title">
                        <div class="twelve wide column middle aligned expandableBlock">
                            <i class="dropdown icon"></i>
                            Episodes
                        </div>
                    </div>
                    <div class="active content">
                        <div class="ui accordion">
                            @foreach($season->episodes as $episode)
                                <div class="title">
                                    <div class="ui grid">
                                        <div class="twelve wide column middle aligned">
                                            Episode {{  $season->name }} x {{ $episode->numero }} - {{ $episode->name }}
                                        </div>
                                        <div class="four wide column">
                                            <form action="{{ route('admin.episodes.destroy', [$episode->id]) }}" method="post" >
                                                {{ csrf_field() }}

                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="ui right floated red circular icon button" value="Supprimer cet épisode ?" onclick="return confirm('Voulez-vous vraiment supprimer cet épisode ?')">
                                                    <i class="remove icon"></i>
                                                </button>
                                            </form>
                                            <button class="ui right floated blue circular icon button">
                                                <i class="edit icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
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