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
                <form class="ui form" method="POST" action="{{ route('admin.articles.store') }}">
                    {{ csrf_field() }}

                    <h4 class="ui dividing header">Catégorie</h4>
                    <div class="ui required field {{ $errors->has('category') ? ' error' : '' }}">
                        <label for="category">Choisir la catégorie de l'article</label>
                        <div class="ui fluid search selection dropdown dropdownCategory">
                            <input name="category" type="hidden" value="{{ old('category') }}">
                            <i class="dropdown icon"></i>
                            <div class="default text">Catégorie</div>
                            <div class="menu">
                            </div>
                        </div>

                        @if ($errors->has('category'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('category') }}</strong>
                            </div>
                        @endif
                    </div>

                    <h4 class="ui dividing header">Séries</h4>

                    <div class="div-center margin1">
                        @if(is_null(old('one')))
                            <div id="oneShow" class="ui left attached BlueSerieAll button">Une série</div>
                            <div id="multipleShows" class="ui right attached ui button">Plusieurs séries</div>
                            <input type="hidden" name="one" value=1>
                        @else
                            @if(old('one') == 0)
                                <div id="oneShow" class="ui left attached button">Une série</div>
                                <div id="multipleShows" class="ui right attached ui BlueSerieAll button">Plusieurs séries</div>
                                <input type="hidden" name="one" value=0>
                            @else
                                <div id="oneShow" class="ui left attached BlueSerieAll button">Une série</div>
                                <div id="multipleShows" class="ui right attached ui button">Plusieurs séries</div>
                                <input type="hidden" name="one" value=1>
                            @endif
                        @endif
                    </div>

                    <div class="verticalDivider ui two column very relaxed grid stackable">
                        <div class="column">
                            <div class="ui required field {{ $errors->has('show') ? ' error' : '' }}">
                                <label for="show">Choisir la série liée</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui search fluid selection dropdown oneShowField dropdownShow">
                                            <input id="inputShow" name="show" type="hidden" value="{{ old('show') }}">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Série</div>
                                            <div class="menu">
                                            </div>
                                        </div>

                                        @if ($errors->has('show'))
                                            <div class="ui red message">
                                                <strong>{{ $errors->first('show') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="three wide column">
                                        <div class="ui inline button clearShow oneShowField">Effacer</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ui field {{ $errors->has('season') ? ' error' : '' }}">
                                <label for="show">Choisir la saison liée</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui disabled fluid search selection dropdown oneShowField dropdownSeason">
                                            <input id="inputSeason" name="season" type="hidden" value="{{ old('season') }}">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Saison</div>
                                            <div class="menu">
                                            </div>
                                        </div>

                                        @if ($errors->has('season'))
                                            <div class="ui red message">
                                                <strong>{{ $errors->first('season') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="three wide column">
                                        <div class="ui inline disabled button oneShowField clearSeason">Effacer</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ui field {{ $errors->has('episode') ? ' error' : '' }}">
                                <label for="show">Choisir l'épisodes lié</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui disabled fluid search selection dropdown oneShowField dropdownEpisode">
                                            <input id="inputEpisode" name="episode" type="hidden" value="{{ old('episode') }}">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Episode</div>
                                            <div class="menu">
                                            </div>
                                        </div>

                                        @if ($errors->has('episode'))
                                            <div class="ui red message">
                                                <strong>{{ $errors->first('episode') }}</strong>                                        </div>
                                        @endif
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
                            <div class="ui required field {{ $errors->has('shows') ? ' error' : '' }}">
                                <label for="shows">Choisir la ou les série(s) liée(s)</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui disabled fluid search multiple selection dropdown multipleShowsField dropdownShow">
                                            <input id="inputShows" name="shows" type="hidden" value="{{ old('shows') }}">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Série(s)</div>
                                            <div class="menu">
                                            </div>
                                        </div>

                                        @if ($errors->has('shows'))
                                            <div class="ui red message">
                                                <strong>{{ $errors->first('shows') }}</strong>                                        </div>
                                        @endif
                                    </div>
                                    <div class="three wide column">
                                        <div class="ui disabled inline button clearShows multipleShowsField">Effacer</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="ui dividing header">Article</h4>

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
                        <textarea id="introInput" name="intro" rows="2">{{ old('intro') }}</textarea>

                        @if ($errors->has('intro'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('intro') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui required field {{ $errors->has('article') ? ' error' : '' }}">
                        <textarea name="article" id="article" class="article" placeholder="Écrivez votre article ici...">{{ old('article') }}</textarea>

                        @if ($errors->has('article'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('article') }}</strong>
                            </div>
                        @endif
                    </div>

                    <br />

                    <div class="ui required field {{ $errors->has('users') ? ' error' : '' }}">
                        <label for="users">Choisir le ou les rédacteur(s)</label>
                        <div class="ui grid">
                            <div class="thirteen wide column">
                                <div class="ui fluid search multiple selection dropdown dropdownUser">
                                    <input id="inputUsers" name="users" type="hidden">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Rédacteur(s)</div>
                                    <div class="menu">
                                    </div>
                                </div>

                                @if ($errors->has('users'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('users') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="three wide column">
                                <div class="ui inline button clearUser">Effacer</div>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input id="publishedInput" name="published" type="checkbox">
                            <label for="publishedInput">Publier l'article</label>
                        </div>
                    </div>
                    <div class="ui field">
                        <div class="ui toggle checkbox">
                            <input id="uneInput" name="une" type="checkbox">
                            <label for="uneInput">Mettre l'article en une</label>
                        </div>
                    </div>
                    <button class="ui positive button">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        CKEDITOR.plugins.addExternal( 'spoiler', '/js/ckeditor/plugins/spoiler/plugin.js' );
        CKEDITOR.plugins.addExternal( 'wordcount', '/js/ckeditor/plugins/wordcount/plugin.js' );
        CKEDITOR.replace( 'article' ,
            {
                extraPlugins: 'spoiler,wordcount',
                wordcount: {
                    showCharCount: true,
                    showWordCount: false,
                    showParagraphs: false
                }
            });

        $('.ui.toggle.checkbox').checkbox();

        var dropdownCategory = '.dropdownCategory';
        var dropdownShow = '.dropdownShow';
        var dropdownSeason = '.dropdownSeason';
        var dropdownEpisode = '.dropdownEpisode';
        var dropdownUser = '.dropdownUser';

        var inputShow = '#inputShow';
        var inputSeason = '#inputSeason';

        var clearShowsButton = '.clearShows';
        var clearShowButton = '.clearShow';
        var clearSeasonButton = '.clearSeason';
        var clearEpisodeButton = '.clearEpisode';
        var clearUserButton = '.clearUser';

        var multipleShowsButton = '#multipleShows';

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

            function switchToMultipleShows() {
                // We change the colors of buttons
                $(multipleShowsButton).addClass('BlueSerieAll');
                $(multipleShowsButton).prev().removeClass('BlueSerieAll');

                // We disabled the field linked to the not selected
                $('.oneShowField').addClass('disabled');
                $('.multipleShowsField').removeClass('disabled');

                // We change the value of the hidden input
                $('input[name=one]').val(0);
            }

            if($('input[name=one]').val() == 0) {
                switchToMultipleShows();
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
                switchToMultipleShows();
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

            // Init the dropdown Users
            $(dropdownUser)
                .dropdown({
                    apiSettings: {
                        url: '/api/users/list?username-lk=*{query}*'
                    },
                    fields: {
                        remoteValues: "data",
                        value: "id",
                        name: "username"
                    }
                })
            ;

            // Clear buttons
            $(clearShowButton).click(function () {
                $(dropdownShow).dropdown('clear');
            });
            $(clearSeasonButton).click(function (){
                $(dropdownSeason).dropdown('clear');
            });
            $(clearEpisodeButton).click(function (){
                $(dropdownEpisode).dropdown('clear');
            });
            $(clearShowsButton).click(function (){
               $(dropdownShow + '.multipleShowsField').dropdown('clear');
            });
            $(clearUserButton).click(function (){
                $(dropdownUser).dropdown('clear');
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