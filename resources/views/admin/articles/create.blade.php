@extends('layouts.admin')

@section('pageTitle', 'Admin - Articles')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.articles.index') }}" class="section">
        Articles
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter un nouvel article
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter un nouvel article
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" method="POST" action="">
                    <div class="ui required field">
                        <label for="categories">Choisir la catégorie de l'article</label>
                        <div class="ui fluid search selection dropdown dropdownCategory">
                            <input name="categories" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Catégorie</div>
                            <div class="menu">
                            </div>
                        </div>
                    </div>

                    <div class="div-center margin1">
                        <div id="oneShow" class="ui left attached BlueSerieAll button">Une série</div>
                        <div id="multipleShows" class="ui right attached ui button">Plusieurs séries</div>
                        <input type="hidden" name="one" value="1">
                    </div>

                    <div class="verticalDivider ui two column very relaxed grid stackable">
                        <div class="column">
                            <div class="ui required field">
                                <label for="show">Choisir la série liée</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui search fluid selection dropdown oneShowField dropdownShow">
                                            <input id="inputShow" name="show" type="hidden">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Série</div>
                                            <div class="menu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="three wide column">
                                        <div class="ui inline button clearShow oneShowField">Effacer</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ui field">
                                <label for="show">Choisir la saison liée</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui disabled fluid search selection dropdown oneShowField dropdownSeason">
                                            <input id="inputSeason" name="season" type="hidden">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Saison</div>
                                            <div class="menu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="three wide column">
                                        <div class="ui inline disabled button oneShowField clearSeason">Effacer</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ui field">
                                <label for="show">Choisir l'épisodes lié</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui disabled fluid search selection dropdown oneShowField dropdownEpisode">
                                            <input id="inputEpisode" name="episode" type="hidden">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Episode</div>
                                            <div class="menu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="three wide column">
                                        <div class="ui inline disabled button oneShowField clearEpisode">Effacer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui vertical divider">
                            OU
                        </div>
                        <div class="column">
                            <div class="ui required field">
                                <label for="shows">Choisir la ou les série(s) liée(s)</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui disabled fluid search multiple selection dropdown multipleShowsField dropdownShow">
                                            <input id="inputShows" name="shows" type="hidden">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Série(s)</div>
                                            <div class="menu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="three wide column">
                                        <div class="ui disabled inline button clearShows multipleShowsField">Effacer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui required field {{ $errors->has('name') ? ' error' : '' }}">
                        <label for="nameInput">Titre de l'article</label>
                        <input id="nameInput" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui required field {{ $errors->has('intro') ? ' error' : '' }}">
                        <label for="introInput">Chapô</label>
                        <textarea id="introInput" rows="2"></textarea>

                        @if ($errors->has('intro'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('intro') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input id="publishedInput" name="published" type="checkbox">
                            <label for="publishedInput">Publier l'article</label>
                        </div>
                    </div>

                    <div class="ui toggle checkbox">
                        <input id="uneInput" name="une" type="checkbox">
                        <label for="uneInput">Mettre l'article en une</label>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        $('.ui.toggle.checkbox').checkbox();

        var dropdownCategory = '.dropdownCategory';
        var dropdownShow = '.dropdownShow';
        var dropdownSeason = '.dropdownSeason';
        var dropdownEpisode = '.dropdownEpisode';

        var inputShow = '#inputShow';
        var inputSeason = '#inputSeason';

        var clearSeasonButton = '.clearSeason';
        var clearEpisodeButton = '.clearEpisode';

        $(document).ready(function() {

            function checkShowState() {
                // If Show is not empty, we enabled the dropdown
                if(!$(inputShow).val()) {
                    $(dropdownSeason).addClass('disabled');
                    $(clearSeasonButton).addClass('disabled');
                }
                else {
                    $(dropdownSeason).removeClass('disabled');
                    $(clearSeasonButton).removeClass('disabled');
                }
            }

            function checkSeasonState() {
                // If Season is not empty, we enabled the dropdown
                if(!$(inputSeason).val()) {
                    $(dropdownEpisode).addClass('disabled');
                    $(clearEpisodeButton).addClass('disabled');
                }
                else {
                    $(dropdownEpisode).removeClass('disabled');
                    $(clearEpisodeButton).removeClass('disabled');
                }
            }


            // On click on "One Show"
            $('#oneShow').click(function () {
                // We change the colors of buttons
                $(this).addClass('BlueSerieAll');
                $(this).next().removeClass('BlueSerieAll');

                // We disabled the field linked to the not selected
                $('.oneShowField').removeClass('disabled');
                $('.multipleShowsField').addClass('disabled');

                // We change the value of the hidden input
                $('input[name=one]').val(1);

                checkShowState();
                checkSeasonState();
            });

            // On click on "Multiple Show"
            $('#multipleShows').click(function () {
                // We change the colors of buttons
                $(this).addClass('BlueSerieAll');
                $(this).prev().removeClass('BlueSerieAll');

                // We disabled the field linked to the not selected
                $('.oneShowField').addClass('disabled');
                $('.multipleShowsField').removeClass('disabled');

                // We change the value of the hidden input
                $('input[name=one]').val(0);
            });

            // Init the dropdown Categories
            $(dropdownCategory)
                .dropdown({
                    apiSettings: {
                        url: '/api/categories/list?name-lk=*{query}*'
                    },
                    fields: {
                        remoteValues: "data",
                        value: "id"
                    }
                })
            ;

            // Clear buttons
            $('.clearShow').click(function () {
                $(dropdownShow).dropdown('clear');
            });
            $('.clearSeason').click(function (){
                $(dropdownSeason).dropdown('clear');
            });
            $('.clearEpisode').click(function (){
                $(dropdownEpisode).dropdown('clear');
            });
            $('.clearShows').click(function (){
               $(dropdownShow + '.multipleShowsField').dropdown('clear');
            });

            // Init the dropdown Show
            $(dropdownShow)
                .dropdown({
                    apiSettings: {
                        url: '/api/shows/list?name-lk=*{query}*'
                    },
                    fields: {
                        remoteValues: "data",
                        value: "id"
                    },
                    saveRemoteData: false
                })
            ;

            // On change on Show, we init the dropdown Seasons with the new value of show
            $(inputShow).change( function() {
                var show =  $(inputShow).val();

                $(dropdownSeason)
                    .dropdown({
                        apiSettings: {
                            url: '/api/seasons/show/'+ show
                        },
                        fields: {
                            remoteValues: "data",
                            value: "id"
                        }
                    })
                    .dropdown('clear')
                ;

                checkShowState();
            });

            // On change on Season, we init the dropdown Episodes with the new value of season
            $(inputSeason).change( function() {
                var season =  $(inputSeason).val();

                $(dropdownEpisode)
                    .dropdown({
                        apiSettings: {
                            url: '/api/episodes/seasons/' + season
                        },
                        fields: {
                            remoteValues: "data",
                            value: "id",
                            name: "title"
                        }
                    })
                    .dropdown('clear')
                ;

                checkSeasonState();
            });
        });
    </script>
@endsection