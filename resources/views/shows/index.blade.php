@extends('layouts.app')

@section('pageTitle', 'Séries TV')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlockShow" class="eleven wide column">
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
        <div id="RightBlockShow" class="four wide column">
            <div class="ui segment">
                <h1>Filtres</h1>

                <div class="ui form">
                    <div class="field">
                        <label>Chaine(s)</label>
                        <div class="ui fluid search selection dropdown channels">
                            <input name="country" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Select Country</div>
                            <div class="menu">
                            </div>
                        </div>

                        <div class="ui red hidden message"></div>
                    </div>

                    <div class="field">
                        <label>Nationalité(s)</label>
                        <div id="dropdown-nationalities" class="ui fluid multiple search selection dropdown">
                            <input id="nationalities" name="nationalities" type="hidden" value="{{ old('nationalities') }}">
                            <i class="dropdown icon"></i>
                            <div class="default text">Choisir</div>
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

@section('scripts')
    <script>
        $('.special.cards .image').dimmer({
            on: 'hover'
        });

        $('.ui.fluid.dropdown.channels')
            .dropdown({
                apiSettings: {
                    url: '/api/channels/list?_q={query}'
                },
                fields: {
                    remoteValues: "data",
                    value: "name"
                },
                localSearch: false
            })
        ;

        $('#dropdown-nationalities')
            .dropdown({
                apiSettings: {
                    url: '/api/nationalities/list?_q={query}'
                },
                fields: {remoteValues: "data", value: "name"}
            })
        ;
    </script>
@endsection
