@extends('layouts.fiche')

@section('pageTitle', affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $episodeInfo->numero, $episodeInfo->id, false, false) . ' - ' . $showInfo['show']->name)
@section('pageDescription', 'Informations sur la série ' . $showInfo['show']->name)

@section('menu_fiche')
    <div id="menuListSeasons" class="row">
        <div class="column ficheContainer">
            <div class="ui segment">
                <div class="ui stackable secondary menu">
                    <div id="seasonsLine" class="ui stackable grid">
                        <a class="item" href="{{ route('season.fiche', [$showInfo['show']->show_url, $seasonInfo->name]) }}">
                            <i class="browser icon"></i>
                            Liste des saisons
                        </a>

                        @foreach($seasonInfo->episodes as $index => $episode)
                            @if($episode->id == $episodeInfo->id)
                                @if($index == 0)
                                    <?php
                                        if(isset($seasonInfo->episodes[$index + 1])) {
                                            $numeroEpisodeSuivant = $seasonInfo->episodes[$index + 1]->numero;
                                            $IDEpisodeSuivant = $seasonInfo->episodes[$index + 1]->id;
                                        ?>
                                            <a class="item" href="
                                                @if($numeroEpisodeSuivant == 0)
                                                    {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant, $IDEpisodeSuivant]) }}
                                                @else
                                                    {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant]) }}
                                                @endif
                                            ">
                                                Episode suivant
                                                <i class="right chevron icon"></i>
                                            </a>
                                        <?php } ?>
                                @elseif($index == $totalEpisodes )
                                    <?php
                                        if(isset($seasonInfo->episodes[$index - 1])) {
                                            $numeroEpisodePrecedent = $seasonInfo->episodes[$index - 1]->numero;
                                            $IDEpisodePrecedent = $seasonInfo->episodes[$index - 1]->id;
                                        ?>
                                        <a class="item" href="
                                            @if($numeroEpisodePrecedent == 0)
                                                {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent, $IDEpisodePrecedent]) }}
                                            @else
                                                {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent]) }}
                                            @endif
                                        ">
                                            <i class="left chevron icon"></i>
                                            Episode précédent
                                        </a>
                                    <?php } ?>
                                @else
                                    <?php
                                        if(isset($seasonInfo->episodes[$index - 1])) {
                                            $numeroEpisodePrecedent = $seasonInfo->episodes[$index - 1]->numero;
                                            $IDEpisodePrecedent = $seasonInfo->episodes[$index - 1]->id;
                                        ?>
                                            <a class="item" href="
                                                @if($numeroEpisodePrecedent == 0)
                                                    {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent, $IDEpisodePrecedent]) }}
                                                @else
                                                    {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent]) }}
                                                @endif
                                            ">
                                                <i class="left chevron icon"></i>
                                                Episode précédent
                                            </a>
                                        <?php } ?>

                                    <?php
                                        if(isset($seasonInfo->episodes[$index + 1])) {
                                            $numeroEpisodeSuivant = $seasonInfo->episodes[$index + 1]->numero;
                                            $IDEpisodeSuivant = $seasonInfo->episodes[$index + 1]->id;
                                        ?>
                                            <a class="item" href="
                                                @if($numeroEpisodeSuivant == 0)
                                                    {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant, $IDEpisodeSuivant]) }}
                                                @else
                                                    {{ route('episode.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant]) }}
                                                @endif
                                            ">
                                                Episode suivant
                                                <i class="right chevron icon"></i>
                                            </a>

                                        <?php } ?>
                                @endif
                            @endif
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
            <div id="episodeDetails" class="ui segment">
                <h1>
                    @if(!empty($episodeInfo->picture))
                        <img class="ui right floated medium image" src="{{ config('thetvdb.imageUrl') }}{{ $episodeInfo->picture }}"  alt="Image illustrative de l'épisode">
                    @endif
                    {!! affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $episodeInfo->numero, $episodeInfo->id, false, false) !!} -
                    @if(!empty($episodeInfo->name_fr))
                        {{ $episodeInfo->name_fr }}
                    @else
                        {{ $episodeInfo->name }}
                    @endif
                </h1>
                <h2 class="ui episode titreen">
                    @if(!empty($episodeInfo->name_fr))
                        {{ $episodeInfo->name }}
                    @endif
                </h2>

                <p class="episodeResume">
                    @if(empty($episodeInfo->resume_fr))
                        @if(empty($episodeInfo->resume))
                            Pas de résumé pour l'instant ...
                        @else
                            {{ $episodeInfo->resume }}
                        @endif
                    @else
                        {{ $episodeInfo->resume_fr }}
                    @endif

                </p>
                <p>
                <i class="calendar icon"></i><b>Diffusion originale</b> :
                    @if($episodeInfo->diffusion_us != '0000-00-00')
                        {!! formatDate('long', $episodeInfo->diffusion_us) !!}
                    @endif
                </p>

                <div class="ui accordion">
                    <div class="title">
                    <i class="dropdown icon"></i>
                    Cliquez pour voir plus d'informations sur l'épisode
                    </div>
                    <div class="content">
                        <p class="transition visible" style="padding-left: 15px;">
                                <i class="calendar icon"></i><b>Diffusion française</b> :
                                @if($episodeInfo->diffusion_fr != '0000-00-00')
                                    {!! formatDate('long', $episodeInfo->diffusion_fr) !!}
                                @endif

                                <br />

                                <i class="camera icon"></i><b>Réalisat.eur.rice.s</b> :
                                @foreach($episodeInfo->directors as $director)
                                    {{ $director->name }}

                                    @if(!$loop->last)
                                    ,
                                    @endif
                                @endforeach

                                <br />

                                <i class="file icon"></i><b>Scénariste.s</b> :
                                @foreach($episodeInfo->writers as $writer)
                                    {{ $writer->name }}

                                    @if(!$loop->last)
                                    ,
                                    @endif
                                @endforeach

                                <br />

                                <i class="users icon"></i><b>Guest.s</b> :
                                @foreach($episodeInfo->guests as $guest)
                                    {{ $guest->name }}

                                    @if(!$loop->last)
                                    ,
                                    @endif
                                @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('comments.all_avis_fiche')
        </div>
    </div>
@endsection

@section('content_fiche_right')
    <div class="ui stackable grid">
        @if(Auth::check() && Auth::user()->role <= 3)
            <div class="row">
                <a style="width: 100%" href="{{ route('admin.episodes.edit', $episodeInfo->id) }}">
                    <button class="ui fluid blueSA button">
                        <i class="pencil alternate icon"></i>
                        Modifier l'épisode dans l'admin
                    </button>
                </a>
            </div>
        @endif
        <div class="row">
            <div class="ui segment center aligned">
                @if($episodeInfo->moyenne < 1)
                    <p class="NoteSeason">
                        -
                    </p>
                    <p>
                        Pas encore de notes
                    </p>
                @else
                    @if($episodeInfo->moyenne >= $noteGood)
                        <p class="NoteSeason t-green">
                    @elseif($episodeInfo->moyenne >= $noteNeutral && $episodeInfo->moyenne < $noteGood)
                        <p class="NoteSeason ui t-grey">
                    @else
                        <p class="NoteSeason ui t-red">
                    @endif
                            {{ $episodeInfo->moyenne }}
                        </p>
                        <p>
                            {{ $episodeInfo->nbnotes }}
                            @if($episodeInfo->nbnotes <= 1)
                                note
                            @else
                                notes
                            @endif
                        </p>
                @endif

                    <div class="ui divider"></div>

                    @if(Auth::Check())
                        <form id="RateEpisode" class="ui form" action="{{ route('episode.rate') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="inline fields">
                            <input type="hidden" class="episode_id" name="episode_id" value="{{ $episodeInfo->id }}">
                            <div class="ui red message hidden"></div>

                            <div class="ui field {{ $errors->has('note') ? ' error' : '' }}">
                                <label for="note">Noter l'épisode</label>
                                <select id="note" name="note" class="note ui compact search dropdown" required>
                                    <option value="@if(isset($rateUser)) {{ $rateUser }} @else  {{ old('note') }} @endif">
                                        @if(isset($rateUser))
                                            {{ $rateUser }}
                                        @else
                                            @if(old('note'))
                                                {{ old('note') }}
                                            @else
                                                Note
                                            @endif
                                        @endif
                                    </option>
                                    @for($i = 20; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div class="ui red message hidden"></div>
                            </div>
                                <button class="ui button">Valider</button>
                            </div>
                        </form>

                                <div class="ui center aligned">
                                    <button class="ui DarkBlueSerieAll button fluid WriteAvis">
                                        <i class="write icon"></i>
                                        @if(!isset($comments['user_comment']))
                                            Écrire un avis
                                        @else
                                            Modifier mon avis
                                        @endif
                                    </button>
                                </div>

                    @else
                            <a href="#" class="clickLogin">Connectez-vous</a> pour noter cet épisode
                    @endif

                    <div class="ui divider"></div>

                    <div class="ui feed">
                        @foreach($rates->users as $user)
                            <div class="event">
                                <div class="label">
                                    <img src="{{ Gravatar::src($user->email) }}"  alt="Avatar de {{$user->username}}">
                                </div>
                                <div class="content">
                                    <div class="summary">
                                        <a href="{{ route('user.profile', $user->user_url) }}" class="user">
                                            {{ $user->username }}
                                        </a>
                                        a noté cet épisode - {!! affichageNote($user->pivot->rate) !!}
                                        <div class="date"> {!! formatDate('short', $user->pivot->updated_at) !!}  </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>

        <div class="row">
            @include('articles.linked')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.ui.top.attached.tabular.menu .item')
            .tab()
        ;
        $('.ui.accordion')
            .accordion()
        ;

        // Submission
        $(document).on('submit', '#RateEpisode', function(e) {
            e.preventDefault();

            var rate = $('select#note').val();
            var episode_id = $('#RateEpisode .episode_id').val();
            console.log(episode_id);

            if( rate < 10 || rate > 15) {
                <?php if(!isset($comments['user_comment'])){ ?>
                    var needComment = false;
                    $('.ecrireAvis').removeClass("hidden");
                    $('.ui.modal.avis').modal('show');

                    $('#formAvis .note').val(rate);
                    $('#formAvis .episode_id').val(episode_id);
                    $('#formAvis .note').prop('disabled', false);
                    $('#formAvis .episode_id').prop('disabled', false);
                <?php } else { ?>
                    var needComment = true;
                <?php } ?>
            }
            else {
                var needComment = true;
            }

            if (needComment) {
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