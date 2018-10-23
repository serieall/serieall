<div class="ui field {{ $errors->has('avis') ? ' error' : '' }}">
    <textarea name="avis" id="avis" class="avis" placeholder="Écrivez votre commentaire ici...">
        {{ $slot }}
    </textarea>

    @if ($errors->has('avis'))
        <div class="ui red message">
            <strong>{{ $errors->first('avis') }}</strong>
        </div>
    @endif
</div>

@push('scripts')
    {{ Html::script('/js/components/editors/editor_comment.js') }}
@endpush