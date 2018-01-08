<div class="ui modal avis">
    <div class="header">
        @if(!isset($comments['user_comment']))
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
                             @if(isset($comments['user_comment']))
                                 {{ $comments['user_comment']['message'] }}
                             @endif
                         </textarea>

                    <div class="nombreCarac ui red hidden message">
                        100 caractères minimum requis.
                    </div>
                </div>

            </div>

            <div class="ui field">
                <div class="ui fluid selection dropdown">
                    <input name="thumb" id="thumb" class="thumb" type="hidden" value="@if(isset($comments['user_comment'])){{ $comments['user_comment']['thumb'] }}@endif">
                    <i class="dropdown icon"></i>
                    <div class="ui black text default text">Choisissez un type d'avis</div>
                    <div class="menu">
                        <div class="item" data-value="1">
                            <i class="green smile large icon"></i>
                            Avis favorable
                        </div>
                        <div class="item" data-value="2">
                            <i class="grey meh large icon"></i>
                            Avis neutre
                        </div>
                        <div class="item" data-value="3">
                            <i class="red frown large icon"></i>
                            Avis défavorable
                        </div>
                    </div>
                </div>
                <div class="ui red hidden message"></div>
            </div>

            <p></p>

            <button class="ui submit positive button">Envoyer</button>
        </form>
    </div>
</div>