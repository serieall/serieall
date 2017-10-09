@extends('layouts.app')

@section('pageTitle', 'Séries TV')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlockShow" class="eleven wide column">
            <div class="ui segment">
                <h1>Liste des séries</h1>

                <div class="row">
                    <div class="ui four cards">
                    @foreach($shows as $show)
                        <div class="card">
                            <a class="image" href="{{ route('show.fiche', $show->show_url) }}">
                                <img src="{{ ShowPicture($show->show_url) }}">
                            </a>
                            <div class="content">
                                <a href="{{ route('show.fiche', $show->show_url) }}" class="header">{{ $show->name }}</a>
                                <div class="meta">
                                    @foreach($show->genres as $genre)
                                        {{ $genre->name }}
                                        @if(!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="extra content">
                                <a>
                                    <i class="calendar icon"></i>
                                    {{ $show->annee }}
                                </a>
                                <a class="right floated">
                                    <i class="heartbeat icon"></i>
                                    {!! affichageNote($show->moyenne) !!}
                                </a>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>

                <div class="PaginateRow row">
                    <div class="column center aligned">
                        {{ $shows->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div id="RightBlockShow" class="four wide column">
            <div class="ui segment">
                <h1>Filtres</h1>
            </div>
        </div>
    </div>
@endsection
