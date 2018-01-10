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
                        <div id="dropdownCategories" class="ui fluid search selection dropdown">
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

                    <div class="verticalDivider ui two column very relaxed grid">
                        <div class="column">
                            <div class="ui required field">
                                <label for="show">Choisir la série liée</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui search fluid selection dropdown oneShowField dropdownShows">
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
                                        <div id="dropdownSeasons" class="ui disabled fluid search selection dropdown">
                                            <input id="inputSeason" name="season" type="hidden">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Saison</div>
                                            <div class="menu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="three wide column">
                                        <div class="ui inline disabled button clearSeason">Effacer</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ui field">
                                <label for="show">Choisir l'épisodes lié</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div id="dropdownEpisodes" class="ui disabled fluid search selection dropdown">
                                            <input id="inputEpisode" name="episode" type="hidden">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Episode</div>
                                            <div class="menu">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="three wide column">
                                        <div class="ui inline disabled button clearEpisode">Effacer</div>
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
                                        <div class="ui disabled fluid search multiple selection dropdown multipleShowsField dropdownShows">
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
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var dropdownShows = '.dropdownShows';
        var inputShow = '#inputShow';
        var inputSeason = '#inputSeason';
        var dropdownCategories = '#dropdownCategories';
        var dropdownSeasons = '#dropdownSeasons';
        var dropdownEpisodes = '#dropdownEpisodes';

        $(document).ready(function() {
            // Init the dropdown Show
            $(dropdownShows)
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

            $('.clearShow').click(function (){
               $(dropdownShows).dropdown('clear');
            });

            $('.clearSeason').click(function (){
                $(dropdownSeasons).dropdown('clear');
            });
            $('.clearEpisode').click(function (){
                $(dropdownEpisodes).dropdown('clear');
            });

            $('#oneShow').click(function () {
                // We change the colors of buttons
                $(this).addClass('BlueSerieAll');
                $(this).next().removeClass('BlueSerieAll');

                // We disabled the field linked to the not selected
                $('.oneShowField').removeClass('disabled');
                $('.multipleShowsField').addClass('disabled');

                // We change the value of the hidden input
                $('input[name=one]').val(1);
            });

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
            $(dropdownCategories)
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

            // On change on Show, we init the dropdown Seasons with the new value of show
            $(inputShow).change( function() {
                var show =  $(inputShow).val();

                $(dropdownSeasons)
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

                // If Show is not empty, we enabled the dropdown
                if(!$(inputShow).val()) {
                    $(dropdownSeasons).addClass('disabled');
                    $(dropdownSeasons + '+div').addClass('disabled');
                }
                else {
                    $(dropdownSeasons).removeClass('disabled');
                    $(dropdownSeasons + '+div').removeClass('disabled');
                }
            });

            // On change on Season, we init the dropdown Episodes with the new value of season
            $(inputSeason).change( function() {
                var season =  $(inputSeason).val();

                $(dropdownEpisodes)
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

                // If Season is not empty, we enabled the dropdown
                if(!$(inputSeason).val()) {
                    $(dropdownEpisodes).addClass('disabled');
                    $(dropdownEpisodes + '+div').addClass('disabled');
                }
                else {
                    $(dropdownEpisodes).removeClass('disabled');
                    $(dropdownEpisodes + '+div').removeClass('disabled');
                }
            });
        });
    </script>
@endsection