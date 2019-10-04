<div class="ui modal avis">
    <i class="close icon"></i>
    <div class="header">
        @if(!empty($comments['user_comment']))
            Écrire un avis
        @else
            Modifier mon avis
        @endif
    </div>
    <div class="content">
        <form id="formAvis" class="ui form" method="post" action="{{ route('comment.store') }}">
            {{ csrf_field() }}

            <input type="hidden" class="object" name="object" value="{{ $object['model'] }}">
            <input type="hidden" class="episode_id" name="episode_id" value="" disabled>
            <input type="hidden" class="note" name="note" value="" disabled>

            <div class="ui red hidden message"></div>

            <input type="hidden" name="object_id" class="object_id" value="{{ $object['id'] }}">
            <div class="ui red hidden message"></div>

            <div class="ecrireAvis ui info hidden message">
                Vous devez écrire un avis pour attribuer cette note.
            </div>

            <div class="ui field">
                <div class="textarea input">
                         <textarea name="avis" id="avis" class="avis" placeholder="Écrivez votre avis ici...">
                             @if(!empty($comments['user_comment']))
                                 {!! affichageMessageWithLineBreak($comments['user_comment']['message']) !!}
                             @endif
                         </textarea>

                    <div class="nombreCarac ui red hidden message">
                        100 caractères minimum requis.
                    </div>
                </div>

            </div>

            <div class="ui field">
                <div class="inline fields">
                    <div class="field">
                        <div class="ui slider checkbox">
                        <input type="radio" name="thumb" checked="checked" value="1">
                        <label><i class="green smile large icon"></i> Avis favorable</label>
                        </div>
                    </div>
                    <div class="ui red hidden message"></div>
                    <div class="field">
                        <div class="ui slider checkbox">
                        <input type="radio" name="thumb" value="2">
                        <label><i class="grey meh large icon"></i> Avis neutre</label>
                        </div>
                    </div>
                    <div class="ui red hidden message"></div>
                    <div class="field">
                        <div class="ui slider checkbox">
                        <input type="radio" name="thumb" value="3">
                        <label><i class="red frown large icon"></i> Avis défavorable</label>
                        </div>
                    </div>
                    <div class="ui red hidden message"></div>
                </div>
            </div>

            <p></p>

            <button class="ui submit positive button">Envoyer</button>
        </form>
    </div>
</div>