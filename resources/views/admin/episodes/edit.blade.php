@extends('layouts.admin')

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
    <a href="{{ route('admin.seasons.show', $episode->show->id) }}" class="section">
        Saisons & Episodes
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
                <form class="ui form" action="{{ route('admin.episodes.update', $episode->id) }}" method="post">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="PUT">

                    <input type="hidden" name="id" value="{{ $episode->id }}">
                    <input type="hidden" name="show_id" value="{{ $episode->show->id }}">

                    <div class="ui two fields">
                        <div class="ui field">
                            <label for="numero">Numéro de l'épisode</label>
                            <input id="numero" name="numero" type="number" value="{{ $episode->numero }}" min="0">
                            <div class="ui red hidden message"></div>
                        </div>
                        <div class="ui field">
                            <label for="season_id">Saison</label>
                            <select id="season_id" name="season_id" class="ui dropdown" data-value="{{ $episode->season_id }}">
                                @foreach($episode->show->seasons as $season)
                                    <option value="{{ $season->id }}">{{ $season->name }}</option>
                                @endforeach
                            </select>
                            <div class="ui red hidden message"></div>
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field">
                            <label for="name">
                                Nom anglais
                            </label>
                            <input type="text" id="name" name="name" value="{{ $episode->name }}">
                            <div class="ui red hidden message"></div>
                        </div>
                        <div class="ui field">
                            <label for="name_fr">
                                Nom français
                            </label>
                            <input type="text" id="name_fr" name="name_fr" value="{{ $episode->name_fr }}">
                            <div class="ui red hidden message"></div>
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field">
                            <label for="resume">
                                Résumé anglais
                            </label>
                            <textarea name="resume" id="resume">{{ $episode->resume }}</textarea>
                            <div class="ui red hidden message"></div>
                        </div>
                        <div class="ui field">
                            <label for="resume_fr">
                                Résumé français
                            </label>
                            <textarea name="resume_fr" id="resume_fr">{{ $episode->resume_fr }}</textarea>
                            <div class="ui red hidden message"></div>
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field">
                            <label>Date de la diffusion originale</label>
                            <div class="ui calendar" id="datepicker">
                                <div class="ui input left icon">
                                    <i class="calendar icon"></i>
                                    <input id="diffusion_us" name="diffusion_us" class="date-picker" type="date" placeholder="Date" value="{{ $episode->diffusion_us }}">
                                </div>
                            </div>
                            <div class="ui red hidden message"></div>
                        </div>

                        <div class="ui field">
                            <label>Date de la diffusion française</label>
                            <div class="ui calendar" id="datepicker">
                                <div class="ui input left icon">
                                    <i class="calendar icon"></i>
                                    <input id="diffusion_fr" name="diffusion_fr" class="date-picker" type="date" placeholder="Date" value="{{ $episode->diffusion_fr }}">
                                </div>
                            </div>
                            <div class="ui red hidden message"></div>
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="ui field">
                            <label for="ba">
                                Bande-Annonce
                            </label>
                            <input type="text" id="ba" name="ba" value="{{ $episode->ba }}">
                            <div class="ui red hidden message"></div>
                        </div>
                        <div class="field">
                            <label for="directors">Réalisateur(s) de la série</label>
                            <div class="ui fluid multiple search selection dropdown artistsDropdown">
                                <input id="directors" name="directors" type="hidden" value="{{ $directors }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                    </div>
                                </div>
                            <div class="ui red hidden message"></div>
                        </div>
                    </div>
                    <div class="ui two fields">
                        <div class="field">
                            <label>Scénariste(s) de la série</label>
                            <div class="ui fluid multiple search selection dropdown artistsDropdown">
                                <input id="writers" name="writers" type="hidden" value="{{ $writers }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                </div>
                            </div>
                            <div class="ui red hidden message"></div>
                        </div>

                        <div class="field">
                            <label>Guest(s) de la série</label>
                            <div class="ui fluid multiple search selection dropdown artistsDropdown">
                                <input id="guests" name="guests" type="hidden" value="{{ $guests }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Choisir</div>
                                <div class="menu">
                                </div>
                            </div>
                            <div class="ui red hidden message"></div>
                        </div>
                    </div>
                    <button class="ui green button" type="submit">Modifier</button>
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
                },
            })
        ;
        $( '.date-picker' ).datepicker({
            showAnim: "blind",
            dateFormat: "yy-mm-dd",
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