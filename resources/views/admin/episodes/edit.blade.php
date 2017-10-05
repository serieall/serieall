@extends('layouts.admin')

@section('pageTitle', 'Admin - Episodes')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.shows.index') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.shows.edit', $episode->show->id) }}" class="section">
        {{ $episode->show->name }}
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.seasons.edit', $episode->season->id) }}" class="section">
        Saison {{ $episode->season->name }}
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Episode {{ $episode->season->name }} x {{ $episode->numero }}
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Episode {{ $episode->season->name }} x {{ $episode->numero }} : "{{ $episode->name }}"
        <span class="sub header">
            Modifier l'épisode {{ $episode->season->name }} x {{ $episode->numero }} de "{{ $episode->show->name }}"
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" action="{{ route('admin.episodes.update') }}" method="POST">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="PUT">

                    <input type="hidden" name="id" value="{{ $episode->id }}">
                    <input type="hidden" name="show_id" value="{{ $episode->show->id }}">
                    <input type="hidden" name="season_id" value="{{ $episode->season->id }}">

                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('numero') ? ' error' : '' }}">
                            <label for="numero">Numéro de l'épisode</label>
                            <input id="numero" name="numero" type="number" value="{{ $episode->numero }}" min="0">

                            @if ($errors->has('numero'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('numero') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="ui field {{ $errors->has('season_id') ? ' error' : '' }}">
                            <label for="season_id">Saison</label>
                            <select id="season_id" name="season_id" class="ui dropdown">
                                @foreach($episode->show->seasons as $season)
                                    <option
                                            @if($season->id == $episode->season_id)
                                                    selected
                                            @endif
                                            value="{{ $season->id }}">{{ $season->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('season_id'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('season_id') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('name') ? ' error' : '' }}">
                            <label for="name">
                                Nom anglais
                            </label>
                            <input id="name" name="name" value="{{ $episode->name }}">

                            @if ($errors->has('name'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="ui field {{ $errors->has('name_fr') ? ' error' : '' }}">
                            <label for="name_fr">
                                Nom français
                            </label>
                            <input id="name_fr" name="name_fr" value="{{ $episode->name_fr }}">

                            @if ($errors->has('name_fr'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('name_fr') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('resume') ? ' error' : '' }}">
                            <label for="resume">
                                Résumé anglais
                            </label>
                            <textarea name="resume" id="resume">{{ $episode->resume }}</textarea>

                            @if ($errors->has('resume'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('resume') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="ui field {{ $errors->has('resume_fr') ? ' error' : '' }}">
                            <label for="resume_fr">
                                Résumé français
                            </label>
                            <textarea name="resume_fr" id="resume_fr">{{ $episode->resume_fr }}</textarea>

                            @if ($errors->has('resume_fr'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('resume_fr') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('diffusion_us') ? ' error' : '' }}">
                            <label>Date de la diffusion originale</label>
                            <div class="ui calendar" id="datepicker">
                                <div class="ui input left icon">
                                    <i class="calendar icon"></i>
                                    <input id="diffusion_us" name="diffusion_us" class="date-picker" type="date" placeholder="Date"
                                       @if(!is_null($episode->diffusion_us))
                                           value="{{ $episode->diffusion_us }}"
                                       @endif>
                                </div>
                            </div>

                            @if ($errors->has('diffusion_us'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('diffusion_us') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="ui field {{ $errors->has('diffusion_fr') ? ' error' : '' }}">
                            <label>Date de la diffusion française</label>
                            <div class="ui calendar" id="datepicker">
                                <div class="ui input left icon">
                                    <i class="calendar icon"></i>
                                    <input id="diffusion_fr" name="diffusion_fr" class="date-picker" type="date" placeholder="Date"
                                       @if(!is_null($episode->diffusion_fr))
                                           value="{{ $episode->diffusion_fr }}"
                                       @endif>
                                </div>
                            </div>

                            @if ($errors->has('diffusion_fr'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('diffusion_fr') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('ba') ? ' error' : '' }}">
                            <label for="ba">
                                Bande-Annonce
                            </label>
                            <input id="ba" name="ba" value="{{ $episode->ba }}">

                            @if ($errors->has('ba'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('ba') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="ui field {{ $errors->has('directors') ? ' error' : '' }}">
                            <label for="directors">Réalisateur(s) de l'épisode</label>
                            <div class="ui fluid multiple search selection dropdown artistsDropdown">
                                <input id="directors" name="directors" type="hidden" value="{{ $directors }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                </div>
                            </div>

                            @if ($errors->has('directors'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('directors') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('writers') ? ' error' : '' }}">
                            <label>Scénariste(s) de l'épisode</label>
                            <div class="ui fluid multiple search selection dropdown artistsDropdown">
                                <input id="writers" name="writers" type="hidden" value="{{ $writers }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                </div>
                            </div>

                            @if ($errors->has('writers'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('writers') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="ui field {{ $errors->has('guests') ? ' error' : '' }}">
                            <label>Guest(s) de l'épisode</label>
                            <div class="ui fluid multiple search selection dropdown artistsDropdown">
                                <input id="guests" name="guests" type="hidden" value="{{ $guests }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                </div>
                            </div>

                            @if ($errors->has('guests'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('guests') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button class="ui green button">Modifier</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.ui.styled.fluid.accordion')
            .accordion({
                selector: {
                    trigger: '.expandableBlock'
                }
            })
        ;
        $( '.date-picker' ).datepicker({
            showAnim: "blind",
            dateFormat: "yy-mm-dd",
            yearRange: "-100:+10",
            changeMonth: true,
            changeYear: true
        });
        $('.artistsDropdown')
            .dropdown({
                apiSettings: {
                    url: '/api/artists/list?name-lk=*{query}*'
                },
                fields: {remoteValues: "data", value: "name"},
                allowAdditions: true,
                forceSelection: false,
                minCharacters: 4
            });
    </script>
@endsection