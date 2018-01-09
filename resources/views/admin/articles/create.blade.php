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
                    <div class="ui field">
                        <label for="categories">Choisir la catégorie de l'article</label>
                        <div id="dropdownCategories" class="ui fluid search selection dropdown">
                            <input name="categories" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Catégorie</div>
                            <div class="menu">
                            </div>
                        </div>
                    </div>
                    <div class="ui field">
                        <label for="show">Choisir la série liée</label>
                        <div id="dropdownShows" class="ui fluid search selection dropdown">
                            <input id="inputShow" name="show" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Série</div>
                            <div class="menu">
                            </div>
                        </div>
                    </div>
                    <div class="ui field">
                        <label for="show">Choisir la saison liée</label>
                        <div id="dropdownSeasons" class="ui fluid search selection dropdown">
                            <input id="inputSeason" name="season" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Saison</div>
                            <div class="menu">
                            </div>
                        </div>
                    </div>
                    <div class="ui field">
                        <label for="show">Choisir l'épisodes lié</label>
                        <div id="dropdownEpisodes" class="ui fluid search selection dropdown">
                            <input id="inputEpisode" name="season" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Episode</div>
                            <div class="menu">
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
        var dropdownShows = '#dropdownShows';
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
                    }
                })
            ;

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
            });
        });
    </script>
@endsection