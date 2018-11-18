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
                                 @if($season->episodes_count === 1)
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
                 {!! $chart->container() !!}
             </div>
         </div>

         <div class="row">
             @include('comments.avis_fiche')
         </div>
     </div>
@endsection

@section('content_fiche_right')
     <div class="ui stackable grid">
         @if(Auth::check())
             <div class="row">
                 <div id="ButtonsActions">
                     <div class="ui segment">
                         <div id="actionShows" class="ui vertical fluid labeled icon buttons">
                             @include('shows.actions_show', ['show_id' => $showInfo['show']->id, 'completed_show' => $showInfo['show']->encours])
                         </div>
                         <div id="messageAction" class="ui hidden orange message"></div>
                     </div>
                 </div>
             </div>
         @endif
         <div class="row">
             @include('articles.linked')
         </div>
     </div>
@endsection

@push('scripts')
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

        $(document).on('submit', '.ui.form.noaction', function(e) {
            e.preventDefault();
        });

        $(document).on('submit', '.ui.form.followshow', function(e) {
            e.preventDefault()

            messageAction = '#messageAction'

            $(messageAction).text('');
            $(messageAction).addClass("hidden");

            actionShows = '#actionShows';

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            }).done(function (data) {
                // On insére le HTML
                $(actionShows).html(data);

                $(actionShows).removeClass('loading');
            }).fail(function () {
                $(messageAction).text('Impossible de modifier le statut de la série. Veuillez réessayer.');
                $(messageAction).removeClass("hidden");

                $(actionShows).removeClass('loading');
            });
        });

    </script>
@endpush

<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
{!! $chart->script() !!}