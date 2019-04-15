<div class="ui modal reaction">
    <div class="header">
            Répondre au commentaire de <span class="answerUsername"></span>
    </div>
    <div class="content">
        <form id="formReaction" class="ui form" method="post" action="{{ route('comment.storereaction') }}">
            {{ csrf_field() }}

            <input type="hidden" name="object_parent_id" class="object_parent_id" value="">

            <div class="ui red hidden message"></div>

            <div class="ui field">
                <div class="textarea input">
                         <textarea name="reaction" id="reaction" class="reaction" placeholder="Écrivez votre réponse ici...">

                         </textarea>

                    <div class="nombreCarac ui red hidden message">
                        3 caractères minimum requis.
                    </div>
                </div>

            </div>

            <div class="ui field">
                <div class="ui red hidden message"></div>
            </div>

            <p></p>

            <button class="ui submit positive button">Envoyer</button>
        </form>
    </div>
</div>
