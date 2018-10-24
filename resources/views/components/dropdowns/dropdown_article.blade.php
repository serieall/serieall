<div class="ui required field {{ $errors->has('article') ? ' error' : '' }}">
    <label for="show">Choisir l'article lié</label>
        <div id="dropdownArticle" class="ui search fluid selection dropdown">
            <input id="inputArticle" name="article" type="hidden" value="{{ old('article') }}">
            <i class="dropdown icon"></i>
            <div class="default text">Article</div>
            <div class="menu">
            </div>
        </div>

        @if ($errors->has('article'))
            <div class="ui red message">
                <strong>{{ $errors->first('article') }}</strong>
            </div>
        @endif
</div>

@push('scripts')
    {{ Html::script('/js/components/dropdowns/dropdown_article.js') }}
@endpush