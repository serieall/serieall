@extends('layouts.admin')

@section('pageTitle', 'Admin - Utilisateurs')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.comments.index') }}" class="section">
        Commentaires
    </a>
    <i class="right angle icon divider"></i>
    @if(is_null($comment->parent))
        <div class="active section">
            Modérer l'avis de {{ $comment->user->username }}
        </div>
    @else
        <a href="{{ route('admin.comments.edit', $comment->parent->id) }}" class="section">
            Modérer l'avis de {{ $comment->parent->user->username }}
        </a>
        <i class="right angle icon divider"></i>
        <div class="active section">
            Modérer la réaction de {{ $comment->user->username }}
        </div>
    @endif
@endsection

@section('content')
    @component('components.title_subtitle')
        @slot('title')
            @if(is_null($comment->parent))
                Modérer l'avis de {{ $comment->user->username }}
            @else
                Modérer la réaction de {{ $comment->user->username }} au commentaire de {{ $comment->parent->user->username }}
            @endif
        @endslot
        Sur
        @if(is_null($comment->parent))
            @if($comment->commentable_type == 'App\Models\Episode')
                {{ $comment->commentable->show->name }} / {{ $comment->commentable->season->name }}.{{ sprintf('%02s', $comment->commentable->numero) }} {{ $comment->commentable->name }}
            @elseif($comment->commentable_type == 'App\Models\Season')
                {{ $comment->commentable->show->name }} / Saison {{ $comment->commentable->name }}
            @else
                {{ $comment->commentable->name }}
            @endif
        @else
            @if($comment->parent->commentable_type == 'App\Models\Episode')
                {{ $comment->parent->commentable->show->name }} / {{ $comment->parent->commentable->season->name }}.{{ sprintf('%02s', $comment->parent->commentable->numero) }} {{ $comment->parent->commentable->name }}
            @elseif($comment->parent->commentable_type == 'App\Models\Season')
                {{ $comment->parent->commentable->show->name }} / Saison {{ $comment->parent->commentable->name }}
            @else
                {{ $comment->parent->commentable->name }}
            @endif
        @endif
    @endcomponent

    @if(!is_null($comment->parent))
        <a href="{{ route('admin.comments.edit', $comment->parent->id) }}">
            @component('components.buttons.button', ['type' => 'icon blue'])
                <i class="icon reply"></i>
                Retourner au commentaire parent
            @endcomponent
        </a>
        <p></p>
    @endif

    <form class="ui form" action="{{ route('admin.comments.update') }}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="_method" value="PUT">
        @if(!is_null($comment->parent))
            <input type="hidden" name="parent_id" value="{{ $comment->parent->id }}">
        @endif
        <input type="hidden" name="id" value="{{ $comment->id }}">

        @if(is_null($comment->parent) and $comment->commentable_type != 'App\Models\Article')
            @component('components.dropdowns.dropdown_thumb')
                {{ $comment->thumb }}
            @endcomponent
        @endif

        @component('components.editors.editor_comment')
            {{ $comment->message }}
        @endcomponent

        @if(is_null($comment->parent) and $comment->commentable_type != 'App\Models\Article')
            <p></p>
            <h3>Déplacer l'avis (Laissez vide pour ne pas le déplacer)</h3>
            @component('components.dropdowns.dropdown_show_season_episode', ['comment' => $comment])
            @endcomponent
            <p></p>
        @endif
        @if($comment->commentable_type == 'App\Models\Article')
            <p></p>
            <h3>Déplacer l'avis (Laissez vide pour ne pas le déplacer)</h3>
            @component('components.dropdowns.dropdown_article', ['comment' => $comment])
            @endcomponent
            <p></p>
        @endif
        <div class="ui divider"></div>

        <div class="four wide column">
            <div class="flex-center">
                @component('components.buttons.button', ['type' => 'positive'])
                    Modifier
                @endcomponent


            </div>
        </div>
    </form>

    @if(count($comment->children) > 0)
            <h2>Réactions</h2>
            @component('components.tables.table_admin', ['headers' => ["Utilisateur", "Message", "Actions"]])
                @foreach($comment->children as $reaction)
                    <tr class="line">
                        <td>
                            {{ $reaction->user->username }}
                        </td>
                        <td>
                            {!! cutResume($reaction->message) !!}
                        </td>
                        <td class="center aligned">
                            <div class="four wide column">
                                <div class="flex-center">
                                    <a href="{{ route('admin.comments.edit', $reaction->id) }}">
                                        @component('components.buttons.button', ['type' => 'blue circular icon'])
                                            <i class="edit icon"></i>
                                        @endcomponent
                                    </a>

                                    @component('components.buttons.button_delete', ['type' => 'circular icon'])
                                        @slot('route')
                                            {!! route('admin.comments.destroy', $reaction->id) !!}
                                        @endslot
                                        @slot('title')
                                            Supprimer cette réaction ?
                                        @endslot
                                        <i class="remove icon"></i>
                                    @endcomponent
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endcomponent
        @else
            @if(is_null($comment->parent))
                @component('components.message_simple', ['type' => 'info'])
                    Pas de réactions sous ce commentaire
                @endcomponent
            @endif
        @endif
@endsection