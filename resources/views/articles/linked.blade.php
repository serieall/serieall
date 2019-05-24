<div id="LastArticles" class="ui segment">
    @if($type_article == "Show")
        <h1>Derniers articles sur la série</h1>
    @elseif($type_article == "Season")
        <h1>Derniers articles sur la saison</h1>
    @else
        <h1>Articles similaires</h1>
    @endif
    <div class="ui grid stackable">
        <div class="column">
            @if($articles_linked->count() > 0)
                @foreach($articles_linked as $article)
                    <div class="row objectArticle">
                        <div class="ui grid stackable">
                            <div class="center aligned four wide column">
                                <img src="{{ $article->image }}" alt=""/>
                            </div>
                            <div class="eleven wide column">
                                <a href="{{ route("article.show", $article->article_url) }}"><h2>{{ $article->name }}</h2></a>
                                <p class="ResumeArticle">{{ $article->intro }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row objectArticle">
                    <div class="ui message info">
                        Aucun article similaire.
                    </div>
                </div>
            @endif

            <div class="row button">
                <a href="{{ route('article.index') }}">
                    <button class="ui right floated button">
                        Tous les articles
                        <i class="right arrow icon"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>