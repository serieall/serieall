<div class="ui segment">
    <div class="ui grid stackable" id="linkedArticles">
        <div class="row">
            <div id="LastArticles" class="ui segment">
                <h1>Derniers articles sur l'épisode</h1>
                <div class="ui stackable grid">
                    @foreach($articles_linked as $article)
                        <div class="row">
                            <div class="center aligned four wide column">
                                <img src="{{ $article->image }}" />
                            </div>
                            <div class="eleven wide column">
                                <a><h2>{{ $article->title }}</h2></a>
                                <p class="ResumeArticle">{{ $article->intro }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="#">
                    <button class="ui right floated button">
                        Tous les articles
                        <i class="right arrow icon"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
