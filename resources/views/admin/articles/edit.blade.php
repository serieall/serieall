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
        Editer {{ $article->name }}
    </div>
@endsection

@section('content')
    <div class="ui grid">
        <div class="ui height wide column">
            <h1 class="ui header" id="adminTitre">
                Articles
                <span class="sub header">
                    Editer un article
                </span>
            </h1>
        </div>
        <div class="ui height wide column">
            <div class="ui height wide column">
                <button class="ui right floated blue button" title="Voir l'aperçu" onclick="window.open('{{ route('article.show', $article->article_url) }}')">
                    <i class="ui eye icon"></i>
                    Voir l'aperçu de mon article
                </button>
            </div>
        </div>
    </div>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" method="POST" action="{{ route('admin.articles.update') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{$article->id}}">

                    <h4 class="ui dividing header">Catégorie</h4>
                    <div class="ui required field {{ $errors->has('category') ? ' error' : '' }}">
                        <label for="inputCategory">Choisir la catégorie de l'article</label>
                        <div id="dropdownCategory" class="ui fluid search selection dropdown">
                            <input id="inputCategory" name="category" type="hidden" value="{{$article->category->name}}">
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

                    <div class="d-center m-1">
                        <div id="oneShow" class="ui left attached @if(count($article->shows) <= 1) blueSA @endif button">Une série</div>
                        <div id="multipleShows" class="ui right attached @if(count($article->shows) > 1) blueSA @endif ui button">Plusieurs séries</div>
                        <input type="hidden" name="one" value=@if(count($article->shows) > 1) 0 @else 1 @endif>
                    </div>

                    <div class="verticalDivider ui two column very relaxed grid stackable">
                        <div class="column">
                            <div class="ui required field {{ $errors->has('show') ? ' error' : '' }}">
                                <label for="show">Choisir la série liée</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui @if(count($article->shows) > 1) disabled @endif search fluid selection dropdown oneShowField dropdownShow">
                                            <input id="inputShow" name="show" type="hidden" value="@if(count($article->shows) <= 1){{ $article->shows->first()->name }}@else{{ old('show') }}@endif">
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
                                        <div class="ui @if(count($article->shows) > 1) disabled  @endif inline button clearShow oneShowField">Effacer</div>
                                    </div>
                                </div>
                            </div>

                            <div class="ui field {{ $errors->has('season') ? ' error' : '' }}">
                                <label for="show">Choisir la saison liée</label>
                                <div class="ui grid">
                                    <div class="thirteen wide column">
                                        <div class="ui disabled fluid search selection dropdown oneShowField dropdownSeason">
                                            <input id="inputSeason" name="season" type="hidden" value="@if(count($article->seasons) > 0){{ $article->seasons->first()->name }}@else{{ old('season') }}@endif">
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
                                            <input id="inputEpisode" name="episode" type="hidden" value="@if(count($article->episodes) > 0){{ $article->episodes->first()->name }}@else{{ old('episode') }}@endif">
                                            <i class="dropdown icon"></i>
                                            <div class="default text">Episode</div>
                                            <div class="menu">
                                            </div>
                                        </div>

                                        @if ($errors->has('episode'))
                                            <div class="ui red message">
                                                <strong>{{ $errors->first('episode') }}</strong>
                                            </div>
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
                                        <div class="thirteen wide column">
                                            <div class="ui @if(count($article->shows) <= 1) disabled @endif fluid search multiple selection dropdown multipleShowsField dropdownShow">
                                                <input id="inputUsers" name="shows" type="hidden" value="{{ $shows }}">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">Série(s)</div>
                                                <div class="menu">
                                                </div>
                                            </div>

                                            @if ($errors->has('shows'))
                                                <div class="ui red message">
                                                    <strong>{{ $errors->first('shows') }}</strong>
                                                </div>
                                            @endif
                                        </div>
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
                        <label for="inputName">Titre de l'article</label>
                        <input id="inputName" name="name" value="@if(old('name')){{ old('name') }}@else{{ $article->name }}@endif">

                        @if ($errors->has('name'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui required field {{ $errors->has('intro') ? ' error' : '' }}">
                        <label for="introInput">Chapô</label>
                        <textarea id="introInput" name="intro" rows="2">@if(old('intro')){{old('intro')}}@else{!! $article->intro !!}@endif</textarea>

                        @if ($errors->has('intro'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('intro') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui required field {{ $errors->has('article') ? ' error' : '' }}">
                        <textarea name="article" id="article" class="article" placeholder="Écrivez votre article ici...">{!! $article->content !!}</textarea>

                        @if ($errors->has('article'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('article') }}</strong>
                            </div>
                        @endif
                    </div>

                    <br />

                    <div class="ui field {{ $errors->has('image') ? ' error' : '' }}">
                        <label for="image">Image de l'article (En ajouter que si vous voulez modifier celle existante)</label>
                        <input id="image" name="image" type="file">

                        @if ($errors->has('image'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('image') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui required field {{ $errors->has('users') ? ' error' : '' }}">
                        <label for="users">Choisir le ou les rédacteur(s)</label>
                        <div class="ui grid">
                            <div class="thirteen wide column">
                                <div class="ui fluid search multiple selection dropdown dropdownUser">
                                    <input id="inputUsers" name="users" type="hidden" value="{{ $users }}">
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
                    <button class="ui positive button">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
        @if($article->state == 1)
            $('.ui.toggle.checkbox').checkbox('check');
        @endif

        const dropdownCategory = '.dropdownCategory';
        const dropdownShow = '.dropdownShow';
        const dropdownSeason = '.dropdownSeason';
        const dropdownEpisode = '.dropdownEpisode';
        const dropdownUser = '.dropdownUser';

        const inputShow = '#inputShow';
        const inputSeason = '#inputSeason';

        const clearShowsButton = '.clearShows';
        const clearShowButton = '.clearShow';
        const clearSeasonButton = '.clearSeason';
        const clearEpisodeButton = '.clearEpisode';
        const clearUserButton = '.clearUser';

        const multipleShowsButton = '#multipleShows';

        $(document).ready(function() {
            // Init the dropdown Categories
            $('#dropdownCategory')
                .dropdown({
                    apiSettings: {
                        url: '/api/genres/list?name-lk=*{query}*'
                    },
                    fields: {remoteValues: "data", value: "name"},
                    allowAdditions: true,
                    hideAdditions: false
                })
            ;

            // Init the dropdown Show
            $(dropdownShow)
                .dropdown({
                    apiSettings: {
                        url: '/api/shows/list?name-lk=*{query}*',
                    },
                    fields: {
                        remoteValues: 'data',
                        value: 'name',
                    },
                    allowAdditions: true,
                    hideAdditions: false
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
                        value: "username",
                        name: "username"
                    },
                    allowAdditions: true,
                    hideAdditions: false
                })
            ;

            checkShowState();
            checkSeasonState();

            function checkShowState() {
                                // If Show is not empty, we enabled the dropdown
                if(!$(inputShow).val()) {
                    $(dropdownSeason).addClass('disabled');
                    $(clearSeasonButton).addClass('disabled');
                }
                else {
                    $(dropdownSeason).removeClass('disabled');
                    $(clearSeasonButton).removeClass('disabled');

                    let show =  $(inputShow).val();

                    $(dropdownSeason)
                        .dropdown({
                            apiSettings: {
                                url: '/api/seasons/show_name/'+ show
                            },
                            fields: {
                                remoteValues: "data",
                                value: "name"
                            },
                            allowAdditions: true,
                            hideAdditions: false
                        })
                    ;
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

                    let season =  $(inputSeason).val();

                    $(dropdownEpisode)
                        .dropdown({
                            apiSettings: {
                                url: '/api/episodes/seasons/' + season
                            },
                            fields: {
                                remoteValues: "data",
                                value: "id",
                                name: "title"
                            },
                            allowAdditions: true,
                            hideAdditions: false
                        })
                    ;

                }
            }

            function switchToMultipleShows() {
                // We change the colors of buttons
                $(multipleShowsButton).addClass('blueSA');
                $(multipleShowsButton).prev().removeClass('blueSA');

                // We disabled the field linked to the not selected
                $('.oneShowField').addClass('disabled');
                $('.multipleShowsField').removeClass('disabled');

                // We change the value of the hidden input
                $('input[name=one]').val(0);
            }

            if($('input[name=one]').val() === 0) {
                switchToMultipleShows();
            }

            // On click on "One Show"
            $('#oneShow').click(function () {
                console.log('coucou');
                // We change the colors of buttons
                $(this).addClass('blueSA');
                $(this).next().removeClass('blueSA');

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

            // On change on Show, we init the dropdown Seasons with the new value of show
            $(inputShow).change( function() {
                checkShowState();
            });

            // On change on Season, we init the dropdown Episodes with the new value of season
            $(inputSeason).change( function() {
                checkSeasonState();
            });
        });
    </script>
@endpush