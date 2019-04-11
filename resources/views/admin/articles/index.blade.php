@extends('layouts.admin')

@section('pageTitle', 'Admin - Articles')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Articles
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="adminTitre">
                    Articles
                    <span class="sub header">
                        Liste de tous les articles présents sur Série-All
                    </span>
                </h1>
            </div>
            <div class="ui height wide column">
                <div class="ui height wide column">
                    <form action="{{ route('admin.articles.create') }}">
                        <button class="ui right floated green button">
                            <i class="ui add icon"></i>
                            Ajouter un nouvel article
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="ui centered grid">
            <div class="fifteen wide column segment">
                <div class="ui segment">
                    <div class="ui form">
                        <div class="ui field">
                            <label for="article">Choisir l'article</label>
                            <div id="dropdownArticle" class="ui search selection dropdown">
                                <input id="inputArticle" name="article" type="hidden" value="{{ old('article') }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Article</div>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="article" class="ui segment">
                    @if (count($articles) > 0)

                            @component('admin.articles.list_article', ['articles' => $articles])
                            @endcomponent

                    @else
                        @component('components.message_simple')
                            @slot('type')
                                info
                            @endslot

                            Pas d'article à afficher.
                        @endcomponent
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{Html::script('js/views/admin/articles/index.js')}}
@endpush
