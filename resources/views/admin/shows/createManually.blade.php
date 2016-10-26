@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('adminIndex') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('adminShow.index') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter une série manuellement
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter une série manuellement
        <div class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </div>
    </h1>

    <form class="ui form" method="POST" action="{{ route('adminShow.storeManually') }}">
        {{ csrf_field() }}

        <div class="ui centered grid">
            <div class="ten wide column segment">
                <div class="ui pointing secondary menu">
                    <a class="item active" data-tab="first">Série</a>
                    <a class="item" data-tab="second">Acteurs</a>
                    <a class="item" data-tab="third">Saisons & épisodes</a>
                    <a class="item" data-tab="fourth">Rentrée</a>
                </div>
                <div class="ui tab active" data-tab="first">
                    <div class="ui teal segment">
                        <h4 class="ui dividing header">Informations générales sur la série</h4>
                        <div class="two fields">
                            <div class="field {{ $errors->has('name') ? ' error' : '' }}">
                                <label>Nom original de la série</label>
                                <input name="name" placeholder="Nom original de la série" type="text" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('name_fr') ? ' error' : '' }}">
                                <label>Nom français de la série</label>
                                <input name="name_fr" placeholder="Nom français" type="text" value="{{ old('name_fr') }}">

                                @if ($errors->has('name_fr'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('name_fr') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('resume') ? ' error' : '' }}">
                                <label>Résumé</label>
                                <textarea name="resume" value="{{ old('resume') }}"></textarea>

                                @if ($errors->has('resume'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('resume') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="two fields field">
                                <div class="field {{ $errors->has('format') ? ' error' : '' }}">
                                    <label>Format</label>
                                    <div class="ui left icon input">
                                        <input name="taux_erectile" placeholder="Format de la série..." type="number" value="{{ old('format') }}">
                                        <i class="tv icon"></i>
                                    </div>

                                    @if ($errors->has('format'))
                                        <div class="ui red message">
                                            <strong>{{ $errors->first('format') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="field {{ $errors->has('encours') ? ' error' : '' }}">
                                    <label>Série en cours</label>
                                    <div id="dropdown-encours" class="ui fluid search selection dropdown">
                                        <i class="dropdown icon"></i>
                                        <span class="text">Choisir</span>
                                        <div class="menu">
                                            <div class="item">
                                                <i class="checkmark icon"></i>
                                                Oui
                                            </div>
                                            <div class="item">
                                                <i class="remove icon"></i>
                                                Non
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('encours'))
                                        <div class="ui red message">
                                            <strong>{{ $errors->first('encours') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('diffusion_us') ? ' error' : '' }}">
                                <label>Date de la diffusion originale</label>
                                <div class="ui calendar" id="datepicker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input name="diffusion_us" id="date-picker-us" type="date" placeholder="Date" value="{{ old('diffusion_us') }}">
                                    </div>
                                </div>
                                @if ($errors->has('diffusion_us'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('diffusion_us') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('diffusion_fr') ? ' error' : '' }}">
                                <label>Date de la diffusion française</label>
                                <div class="ui calendar" id="datepicker">
                                    <div class="ui input left icon">
                                        <i class="calendar icon"></i>
                                        <input name="diffusion_fr" id="date-picker-fr" type="date" placeholder="Date" value="{{ old('diffusion_fr') }}">
                                    </div>
                                </div>
                                @if ($errors->has('diffusion_fr'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('diffusion_fr') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('chaine_fr') ? ' error' : '' }}">
                                <label>Chaine(s)</label>
                                <div id="dropdown-chaines" class="ui fluid multiple search selection dropdown">
                                    <input name="chaine_fr" type="hidden" value="{{ old('chaine_fr') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($channels as $channel)
                                            <div class="item" data-value="{{ $channel->name }}">{{ $channel->name }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($errors->has('chaine_fr'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('chaine_fr') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('nationalities') ? ' error' : '' }}">
                                <label>Nationalité(s)</label>
                                <div id="dropdown-nationalities" class="ui fluid multiple search selection dropdown">
                                    <input name="nationalities" type="hidden" value="{{ old('nationalities') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($nationalities as $nationality)
                                            <div class="item" data-value="{{ $nationality->name }}">{{ $nationality->name }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($errors->has('nationalities'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('nationalities') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field {{ $errors->has('creators') ? ' error' : '' }}">
                                <label>Créateur(s) de la série</label>
                                <div id="dropdown-creators" class="ui fluid multiple search selection dropdown">
                                    <input name="creators" type="hidden" value="{{ old('creators') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($creators as $creator)
                                            <div class="item" data-value="{{ $creator->name }}">{{ $creator->name }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($errors->has('creators'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('creators') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('genres') ? ' error' : '' }}">
                                <label>Genre(s)</label>
                                <div id="dropdown-genres" class="ui fluid multiple search selection dropdown">
                                    <input name="genres" type="hidden" value="{{ old('genres') }}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Choisir</div>
                                    <div class="menu">
                                        @foreach($genres as $genre)
                                            <div class="item" data-value="{{ $genre->name }}">{{ $genre->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                @if ($errors->has('genres'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('genres') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button class="positive ui button" type="submit">Créer la série</button>
                </div>

                <div class="ui tab blue segment" data-tab="second">
                    <h4 class="ui dividing header">Ajouter un ou plusieurs acteurs</h4>
                    <p>
                        <button class="ui basic button add_actor_button">
                            <i class="icon user"></i>
                            Ajouter un acteur
                        </button>
                        <br />
                    </p>

                    <div class="add_actor">
                        <div class="two fields">
                            <div class="field {{ $errors->has('name') ? ' error' : '' }}">
                                <label>Nom de l'acteur</label>
                                <input name="name" placeholder="Nom de l'acteur" type="text" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="field {{ $errors->has('role') ? ' error' : '' }}">
                                <label>Rôle</label>
                                <input name="role" placeholder="Role de l'acteur" type="text" value="{{ old('role') }}">

                                @if ($errors->has('role'))
                                    <div class="ui red message">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <a href="#" class="ui items remove_field">
                                <i class="item middle aligned content delete icon"></i>
                            </a>
                        </div>
                    </div>

                    <button class="positive ui button" type="submit">Créer la série</button>
                </div>

                <div class="ui tab red segment" data-tab="third">
                    <h4 class="ui dividing header">Ajouter les saisons et les épisodes</h4>
                    <div class="ui styled accordion" id="seasons">
                        <div class="title">
                            <i class="dropdown icon"></i>
                            Saison 1
                        </div>
                        <div class="content">
                            <p class="transition hidden">
                                <div class="two fields">
                                    <div class="field {{ $errors->has('numero') ? ' error' : '' }}">
                                        <label>Numéro de la saison</label>
                                        <input name="numero" placeholder="Numéro de la saison" type="number" value="{{ old('numero') }}">

                                        @if ($errors->has('numero'))
                                            <div class="ui red message">
                                                <strong>{{ $errors->first('numero') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="field {{ $errors->has('ba') ? ' error' : '' }}">
                                        <label>Bande Annonce</label>
                                        <input name="ba" placeholder="Bande Annonce" type="text" value="{{ old('ba') }}">

                                        @if ($errors->has('ba'))
                                            <div class="ui red message">
                                                <strong>{{ $errors->first('ba') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>

                    <button class="positive ui button" type="submit">Créer la série</button>
                </div>

                <div class="ui tab violet segment" data-tab="fourth">
                    <h4 class="ui dividing header">Informations sur la rentrée</h4>
                    <div class="two fields">
                        <div class="field {{ $errors->has('taux_erectile') ? ' error' : '' }}">
                            <label>Taux érectile</label>
                            <div class="ui left icon input">
                                <input name="taux_erectile" placeholder="Pourcentage..." type="number" value="{{ old('taux_erectile') }}">
                                <i class="percent icon"></i>
                            </div>

                            @if ($errors->has('taux_erectile'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('taux_erectile') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('avis_rentree') ? ' error' : '' }}">
                            <label>Avis de la rédaction</label>
                            <textarea name="avis_rentree" value="{{ old('avis_rentree') }}"></textarea>

                            @if ($errors->has('avis_rentree'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('avis_rentree') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button class="positive ui button" type="submit">Créer la série</button>
                </div>
            </div>
        </div>
    </form>

    @section('scripts')
        <script>
            $('#dropdown-creators')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false,
                        minCharacters: 4
                    })
            ;
            $('#dropdown-genres')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false
                    })
            ;
            $('#dropdown-chaines')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false
                    })
            ;

            $('#dropdown-nationalities')
                    .dropdown({
                        allowAdditions: true,
                        forceSelection : false
                    })
            ;

            $( '#date-picker-us' ).datepicker({
                showAnim: "blind",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });

            $( '#date-picker-fr' ).datepicker({
                showAnim: "blind",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });

            $('#dropdown-encours')
                    .dropdown({
                    })
            ;

            $('.menu .item')
                    .tab()
            ;

            $('.ui.accordion')
                    .accordion()
            ;

            $(document).ready(function() {
                var max_fields      = 50; //maximum input boxes allowed
                var wrapper         = $(".add_actor"); //Fields wrapper
                var add_button      = $(".add_actor_button"); //Add button ID

                var x = 1; //initlal text box count
                $(add_button).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append('<div class="two fields">' +
                        '<div class="field {{ $errors->has('name') ? ' error' : '' }}">' +
                        '<label>Nom de l\'acteur</label>' +
                        '<input name="name" placeholder="Nom de l\'acteur" type="text" value="{{ old('name') }}">' +

                        '@if ($errors->has('name'))' +
                        '<div class="ui red message">' +
                        '<strong>{{ $errors->first('name') }}</strong>' +
                        '</div>' +
                        '@endif' +
                        '</div>' +

                        '<div class="field {{ $errors->has('role') ? ' error' : '' }}">' +
                        '<label>Rôle</label>' +
                        '<input name="role" placeholder="Role de l\'acteur" type="text" value="{{ old('role') }}">' +

                        '@if ($errors->has('role'))' +
                        '<div class="ui red message">' +
                        '<strong>{{ $errors->first('role') }}</strong>' +
                        '</div>' +
                        '@endif' +
                        '</div>' +
                        '<a href="#" class="ui items remove_field"><i class="item middle aligned content delete icon"></i></a>' +
                        '</div>'); //add input box
                    }
                });

                $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
        </script>
    @endsection
@endsection