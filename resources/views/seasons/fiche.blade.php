@extends('layouts.fiche')

@section('pageTitle', 'S' . $seasonInfo->name . ' - ' . $showInfo['show']->name)

@section('menu_fiche')
    <div id="menuListSeasons" class="row">
        <div class="column ficheContainer">
            <div class="ui segment">
                <div class="ui stackable secondary menu">
                    <div id="seasonsLine" class="ui stackable grid">
                        @foreach($showInfo['show']->seasons as $season)
                            <a class="
                                @if($seasonInfo->name == $season->name)
                                    active
                                @endif
                                    item" href="{{ route('season.fiche', [$showInfo['show']->show_url, $season->name]) }}">Saison {{ $season->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_left')
    <div class="ui stackable grid">
        <div class="row">
            <div id="ListSeasons" class="ui segment">
                <h1>Liste des épisodes</h1>
                    <table class="ui padded table center aligned">
                        @foreach($seasonInfo->episodes as $episode)
                            <tr>
                                <td class="left aligned">
                                    {!! affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $episode->numero, $episode->id, true, true) !!}
                                </td>
                                <td class="left aligned">
                                    {{ afficheEpisodeName($episode, false, false) }}
                                </td>
                                <td>
                                    @if($episode->diffusion_us != "0000-00-00")
                                        {!! formatDate('long', $episode->diffusion_us) !!}
                                    @else
                                        <span class="t-grey">Pas de date</span>
                                    @endif
                                </td>
                                <td>
                                    @if($episode->moyenne < 1)
                                        <p class="t-black">
                                            -
                                        </p>
                                    @else
                                        {!! affichageNote($episode->moyenne) !!}
                                    @endif
                                </td>
                                <td>
                                    {{ affichageCountThumb($episode->comments->where('thumb', '=', 1)->first()) }}
                                    <i class="green smile large icon"></i>

                                    {{ affichageCountThumb($episode->comments->where('thumb', '=', 2)->first()) }}
                                    <i class="grey meh large icon"></i>

                                    {{ affichageCountThumb($episode->comments->where('thumb', '=', 3)->first()) }}
                                    <i class="red frown large icon"></i>
                                </td>
                            </tr>
                        @endforeach
                    </table>
            </div>
        </div>

        <div class="row">
            <div class="chartMean column">
                {!! $chart->container() !!}
            </div>
        </div>

        <div class="row">
            @include('comments.all_avis_fiche')
        </div>
    </div>
@endsection

@section('content_fiche_right')
    <div class="ui stackable grid">
        <div class="row">
            <div class="ui segment center aligned">
                @if($seasonInfo->moyenne < 1)
                    <p class="NoteSeason">
                        -
                    </p>
                    <p>
                        Pas encore de notes
                    </p>
                @else
                    @if($seasonInfo->moyenne >= $noteGood)
                        <p class="NoteSeason t-green">
                    @elseif($seasonInfo->moyenne >= $noteNeutral && $seasonInfo->moyenne < $noteGood)
                        <p class="NoteSeason t-grey">
                    @else
                        <p class="NoteSeason t-red">
                    @endif
                            {{ $seasonInfo->moyenne }}
                    </p>
                    <p>
                        {{ $seasonInfo->nbnotes }}
                        @if($seasonInfo->nbnotes <= 1)
                            note
                        @else
                            notes
                        @endif
                    </p>
                @endif

                <div class="ui divider"></div>

                <div class="ui feed showMoreOrLess">
                    @foreach($ratesSeason['users'] as $rate)
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src($rate['user']['email']) }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', $rate['user']['user_url']) }}" class="user">
                                        {{ $rate['user']['username'] }}
                                    </a>
                                    a noté {!! affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $rate['episode']['numero'], $rate['episode']['id'], true, false) !!} - {!! affichageNote($rate['rate']) !!}

                                    <div class="date">{!! formatDate('short', $rate['updated_at']) !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="fadeDiv fadeShowMoreOrLess"></div>
                <div><button class="ui button slideShowMoreOrLess">Voir plus</button></div>
            </div>
        </div>

        <div class="row">
            @include('articles.linked')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var $divView = $('.showMoreOrLess');
            var innerHeight = $divView.removeClass('showMoreOrLess').height();
            $divView.addClass('showMoreOrLess');

            if(innerHeight < 220) {
                $('.fadeShowMoreOrLess').remove();
                $('.slideShowMoreOrLess').remove();
                $divView.removeClass('showMoreOrLess');
            }

            $('.slideShowMoreOrLess').click(function() {
                $('.showMoreOrLess').animate({
                    height: (($divView.height() == 220)? innerHeight  : "220px")
                }, 500);

                if($divView.height() == 220) {
                    $('.slideShowMoreOrLess').text('Voir moins');
                    $('.fadeDiv').removeClass('fadeShowMoreOrLess');
                }
                else {
                    $('.slideShowMoreOrLess').text('Voir plus');
                    $('.fadeDiv').addClass('fadeShowMoreOrLess');
                }
                return false;
            });
        });

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
@endpush

<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
{!! $chart->script() !!}

