@extends('layouts.fiche')

@section('pageTitle', $showInfo['show']->name)

@section('menu_fiche')

@endsection

@section('content_fiche_left')
     <div class="ui stackable grid">
         <div class="row">
             <div id="ListSeasons" class="ui segment">
                 <h1>Liste des saisons</h1>
                 <table class="ui padded table center aligned">
                     @foreach($showInfo['seasons'] as $season)
                         <tr>
                             <td>
                                 <a href="{{ route('season.fiche', [$showInfo['show']->show_url, $season->name]) }}">Saison {{ $season->name }}</a>
                             </td>
                             <td>
                                 @if($season->moyenne < 1)
                                     -
                                 @else
                                     {!! affichageNote($season->moyenne) !!}
                                 @endif

                             </td>
                             <td>
                                 {{ affichageCountThumb($season->comments->where('thumb', '=', 1)->first()) }}
                                 <i class="green smile large icon"></i>

                                 {{ affichageCountThumb($season->comments->where('thumb', '=', 2)->first()) }}
                                 <i class="grey meh large icon"></i>

                                 {{ affichageCountThumb($season->comments->where('thumb', '=', 3)->first()) }}
                                 <i class="red frown large icon"></i>
                             </td>
                             <td>
                                 {{ $season->episodes_count }}
                                 @if($season->episodes_count == 1)
                                     épisode
                                 @else
                                     épisodes
                                 @endif
                             </td>
                         </tr>
                     @endforeach
                 </table>
                 <a href="{{ route('season.fiche', [$showInfo['show']->show_url, '1']) }}">
                     <button class="ui right floated icon button ListAll">
                         Toutes les saisons
                         <i class="right arrow icon"></i>
                     </button>
                 </a>
             </div>
         </div>

         <div class="row">
             <div class="chartMean column">
                 {!! $chart->html() !!}
             </div>
         </div>

         <div class="row">
             @include('comments.avis_fiche')
         </div>
     </div>
@endsection

@section('content_fiche_right')
     <div class="ui stackable grid">
         <div class="row">
             <div id="ButtonsActions">
                 <div class="ui segment">
                     <div class="ui fluid icon dropdown DarkBlueSerieAll button">
                         <span class="text"><i class="tv icon"></i>Actions sur la série</span>
                         <div class="menu">
                             <div class="item">
                                 <i class="play icon"></i>
                                 Je regarde la série
                             </div>
                             <div class="item">
                                 <i class="pause icon"></i>
                                 Je mets en pause la série
                             </div>
                             <div class="item">
                                 <i class="stop icon"></i>
                                 J'abandonne la série
                             </div>
                         </div>
                     </div>
                     <button class="ui fluid button">
                         <i class="calendar icon"></i>
                         J'ajoute la série dans mon planning
                     </button>
                 </div>
             </div>
         </div>
         <div class="row">
             <div id="LastArticles" class="ui segment">
                 <h1>Derniers articles sur la série</h1>
                 <div class="ui stackable grid">
                     <div class="row">
                         <div class="center aligned four wide column">
                             <img src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
                         </div>
                         <div class="eleven wide column">
                             <a><h2>Critique 01.03</h2></a>
                             <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                         </div>
                     </div>
                     <div class="row">
                         <div class="center aligned four wide column">
                             <img src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
                         </div>
                         <div class="eleven wide column">
                             <a><h2>Critique 01.02</h2></a>
                             <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                         </div>
                     </div>
                     <div class="row">
                         <div class="center aligned four wide column">
                             <img src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
                         </div>
                         <div class="eleven wide column">
                             <a><h2>Critique 01.01</h2></a>
                             <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                         </div>
                     </div>
                 </div>
                 <button class="ui right floated button">
                     Tous les articles
                     <i class="right arrow icon"></i>
                 </button>
             </div>
         </div>
         <div class="row">
             <div id="SimilarShows" class="ui segment">
                 <h1>Séries similaires</h1>
                 <div class="ui center aligned stackable grid">
                     <div class="row">
                         <div class="center aligned five wide column">
                             <img src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
                             <span>Série 1</span>
                         </div>
                         <div class="center aligned five wide column">
                             <img src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
                             <span>Série 2</span>
                         </div>
                         <div class="center aligned five wide column">
                             <img src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
                             <span>Série 3</span>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
@endsection

@section('scripts')
    <script>
        $('.ui.fluid.selection.dropdown').dropdown({forceSelection: true});

        $('.ui.modal.avis').modal('attach events', '.ui.button.WriteAvis', 'show');
        CKEDITOR.plugins.addExternal( 'spoiler', '/js/ckeditor/plugins/spoiler/plugin.js' );
        CKEDITOR.plugins.addExternal( 'wordcount', '/js/ckeditor/plugins/wordcount/plugin.js' );
        CKEDITOR.replace( 'avis' ,
            {
                extraPlugins: 'spoiler,wordcount',
                customConfig:'/js/ckeditor/config.js',
                wordcount: {
                    showCharCount: true,
                    showWordCount: false,
                    showParagraphs: false
                }
            });
        // Submission
        $(document).on('submit', '#formAvis', function(e) {
            e.preventDefault();

            var messageLength = CKEDITOR.instances['avis'].getData().replace(/<[^>]*>|\n|&nbsp;/g, '').length;
            var nombreCaracAvis = '{!! config('param.nombreCaracAvis') !!}';

            if(messageLength < nombreCaracAvis ) {
                $('.nombreCarac').removeClass("hidden");
            }
            else {
                $('.submit').addClass("loading");

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json"
                })
                    .done(function () {
                        window.location.reload(false);
                    })
                    .fail(function (data) {
                        $('.submit').removeClass("loading");

                        $.each(data.responseJSON.errors, function (key, value) {
                            var input = 'input[class="' + key + '"]';

                            $(input + '+div').text(value);
                            $(input + '+div').removeClass("hidden");
                            $(input).parent().addClass('error');
                        });
                    });
            }
        });
    </script>
@endsection

{!! Charts::scripts() !!}
{!! $chart->script() !!}