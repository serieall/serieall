@extends('layouts.app')

@section('pageTitle', 'Séries TV')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlock" class="eleven wide column">
            <div class="ui segment">
                <h1>Liste des séries</h1>

                <div class="row">
                    <div class="ui four special cards">
                    @foreach($shows as $show)
                        <div class="card">
                            <div class="blurring dimmable image">
                                <div class="ui dimmer">
                                    <div class="content">
                                        <div class="center">
                                            <a href="{{ route('show.fiche', $show->show_url) }}">
                                                <div class="ui inverted button">Voir la fiche série</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <img src="{{ ShowPicture($show->show_url) }}">
                            </div>
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
        <div id="RightBlock" class="four wide column">
            <div class="ui segment">
                <h1>Filtres</h1>

                <div class="ui form">
                    <div class="field">
                        <label>Chaine(s)</label>
                        <div class="ui fluid search multiple selection dropdown channels">
                            <input name="channels" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Chaine(s)</div>
                            <div class="menu">
                            </div>
                        </div>

                        <div class="ui red hidden message"></div>
                    </div>

                    <div class="field">
                        <label>Nationalité(s)</label>
                        <div class="ui fluid search multiple selection dropdown nationalities">
                            <input name="channels" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Nationalité(s)</div>
                            <div class="menu">
                            </div>
                        </div>
                        <div class="ui red hidden message"></div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.special.cards .image').dimmer({
            on: 'hover'
        });

        $(document).ready(function() {
            $('.ui.fluid.search.selection.dropdown.channels')
                .dropdown({
                    apiSettings: {
                        url: '/api/channels/list?name-lk=*{query}*'
                    },
                    fields: {
                        remoteValues: "data",
                        value: "name"
                    }
                })
            ;

            $('.ui.fluid.search.selection.dropdown.nationalities')
                .dropdown({
                    apiSettings: {
                        url: '/api/nationalities/list?name-lk=*{query}*'
                    },
                    fields: {
                        remoteValues: "data",
                        value: "name"
                    }
                })
            ;
        });
    </script>
@endpush
