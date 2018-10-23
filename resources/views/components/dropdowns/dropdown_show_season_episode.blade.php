<div class="ui three fields">
    <div class="ui required field {{ $errors->has('show') ? ' error' : '' }}">
        <label for="show">Choisir la série liée</label>
            <div id="dropdownShow" class="ui search fluid selection dropdown">
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

    <div class="ui field {{ $errors->has('season') ? ' error' : '' }}">
        <label for="show">Choisir la saison liée</label>
        <div id="dropdownSeason" class="ui fluid search selection dropdown">
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

    <div class="ui field {{ $errors->has('episode') ? ' error' : '' }}">
        <label for="show">Choisir l'épisodes lié</label>
        <div id="dropdownEpisode" class="ui fluid search selection dropdown">
            <input id="inputEpisode" name="episode" type="hidden" value="{{ old('episode') }}">
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
</div>

@push('scripts')
    {{ Html::script('/js/components/dropdown/dropdown_show_season_episode.js') }}
@endpush