<div class="ui modal avis">
    <div class="header">
        @if(!empty($comments['user_comment']))
            Écrire un commentaire
        @else
            Modifier mon commentaire
        @endif
    </div>
    <div class="content">
        <form id="formAvis" class="ui form" method="post" action="{{ route('comment.storewtn') }}">
            {{ csrf_field() }}

            <input type="hidden" class="object" name="object" value="{{ $object['model'] }}">

            <div class="ui red hidden message"></div>

            <input type="hidden" name="object_id" class="object_id" value="{{ $object['id'] }}">
            <div class="ui red hidden message"></div>

            <div class="ui field">
                <div class="textarea input">
                         <textarea name="avis" id="avis" class="avis" placeholder="Écrivez votre commentaire ici...">
                             @if(!empty($comments['user_comment']))
                                 {{ $comments['user_comment']['message'] }}
                             @endif
                         </textarea>

                    <div class="nombreCarac ui red hidden message">
                        20 caractères minimum requis.
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