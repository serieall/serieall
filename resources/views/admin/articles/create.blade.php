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
                        <label for="dropdown-shows">Choisir la catégorie de l'article</label>
                        <div id="dropdownCategories" class="ui fluid search selection dropdown">
                            <input name="categories" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Catégorie(s)</div>
                            <div class="menu">
                            </div>
                        </div>
                    </div>
                    <div class="ui field">
                        <label for="dropdown-shows">Choisir la ou les séries liées</label>
                        <div id="dropdownShows" class="ui fluid search multiple selection dropdown">
                            <input name="shows" type="hidden">
                            <i class="dropdown icon"></i>
                            <div class="default text">Série(s)</div>
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
        $(document).ready(function() {
            $('#dropdownShows')
                .dropdown({
                    apiSettings: {
                        url: '/api/shows/list?name-lk=*{query}*'
                    },
                    fields: {
                        remoteValues: "data",
                        value: "name"
                    }
                })
            ;

            $('#dropdownCategories')
                .dropdown({
                    apiSettings: {
                        url: '/api/categories/list?name-lk=*{query}*'
                    },
                    fields: {
                        remoteValues: "data",
                        value: "name"
                    },
                    allowMultiple: false
                })
            ;
        });
    </script>
@endsection