<textarea name="avis" id="avis" class="avis" placeholder="Écrivez votre commentaire ici...">
    {{ $slot }}
</textarea>

@push('scripts')
    {{ Html::script('/js/components/editors/editor_comment.js') }}
@endpush