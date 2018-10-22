<textarea name="avis" id="avis" class="avis" placeholder="Écrivez votre commentaire ici...">
    {{ $slot }}
</textarea>

{{ Html::script('/js/components/editors/editor_comment.js') }}