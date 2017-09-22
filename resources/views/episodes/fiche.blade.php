@extends('layouts.fiche')

@section('pageTitle', affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $episodeInfo->numero, $episodeInfo->id, false, false) . ' - ' . $showInfo['show']->name)

@section('menu_fiche')
    <div id="menuFiche" class="menuFiche row">
        <div class="column">
            <div class="ui fluid six item stackable menu ficheContainer">
                <a class="item" href="{{ route('show.fiche', $showInfo['show']->show_url) }}">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="active item">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="item" href="{{ route('show.details', $showInfo['show']->show_url) }}">
                    <i class="big list icon"></i>
                    Informations détaillées
                </a>
                <a class="item">
                    <i class="big comments icon"></i>
                    Avis
                </a>
                <a class="item">
                    <i class="big write icon"></i>
                    Articles
                </a>
                <a class="item">
                    <i class="big line chart icon"></i>
                    Statistiques
                </a>
            </div>
        </div>
    </div>
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
                                @elseif($index == $totalEpisodes )
                                    <?php
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
                                @else
                                    <?php
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

                                    <?php
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
                <div class="ui divider"></div>

                <div class="ui top attached tabular menu">
                    <a class="active item" data-tab="first" >Informations sur l'épisode</a>
                    <a class="item" data-tab="second">Fiche technique</a>
                </div>
                <div class="ui bottom attached active tab segment" data-tab="first">
                    @if(!empty($episodeInfo->picture))
                        <div class="ui center aligned">
                            <img src="{{ $episodeInfo->picture }}">
                        </div>
                    @endif
                    <table class="ui center aligned table">
                        <thead>
                        <tr>
                            @if($episodeInfo->diffusion_us != '0000-00-00')
                                <th>
                                    <i class="calendar icon"></i>
                                    Diffusion originale
                                </th>
                            @endif
                            @if($episodeInfo->diffusion_fr != '0000-00-00')
                                <th>
                                    <i class="calendar icon"></i>
                                    Diffusion française
                                </th>
                            @endif
                        </tr>
                        </thead>
                        <tr>
                            @if($episodeInfo->diffusion_us != '0000-00-00')
                                <td>
                                    {!! formatDate('long', $episodeInfo->diffusion_us) !!}
                                </td>
                            @endif
                            @if($episodeInfo->diffusion_fr != '0000-00-00')
                                <td>
                                    {!! formatDate('long', $episodeInfo->diffusion_fr) !!}
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>
                <div class="ui bottom attached tab segment" data-tab="second">
                    <table class="ui table">
                        <thead>
                        <tr>
                            <th>
                                Réalisateur(s)
                            </th>
                            <th>
                                Scénariste(s)
                            </th>
                            <th>
                                Guest(s)
                            </th>
                        </tr>
                        </thead>
                        <tr>
                            <td>
                                @foreach($episodeInfo->directors as $director)
                                    {{ $director->name }}
                                    <br />
                                @endforeach
                            </td>
                            <td>
                                @foreach($episodeInfo->writers as $writer)
                                    {{ $writer->name }}
                                    <br />
                                @endforeach
                            </td>
                            <td>
                                @foreach($episodeInfo->guests as $guest)
                                    {{ $guest->name }}
                                    <br />
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
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
                        <p class="NoteSeason ui green text">
                    @elseif($episodeInfo->moyenne >= $noteNeutral && $episodeInfo->moyenne < $noteGood)
                        <p class="NoteSeason ui gray text">
                    @else
                        <p class="NoteSeason ui red text">
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
                    @else
                        Vous devez être connecté pour pouvoir noter l'épisode.
                    @endif

                    <div class="ui divider"></div>

                    <div class="ui feed">
                        @foreach($rates->users as $user)
                            <div class="event">
                                <div class="label">
                                    <img src="{{ Gravatar::src($user->email) }}">
                                </div>
                                <div class="content">
                                    <div class="summary">
                                        <a href="{{ route('user.profile', $user->username) }}" class="user">
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
            <div id="LastArticles" class="ui segment">
                <h1>Derniers articles sur l'épisode</h1>
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
                <a href="#">
                    <button class="ui right floated button">
                        Tous les articles
                        <i class="right arrow icon"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.ui.top.attached.tabular.menu .item')
            .tab()
        ;

        // Submission
        $(document).on('submit', '#RateEpisode', function(e) {
            e.preventDefault();

            var rate = $('select#note').val();
            var episode_id = $('#RateEpisode .episode_id').val();
            console.log(episode_id);

            if( rate < 10 || rate > 15) {
                <?php if (!isset($comments['user_comment'])){ ?>
                    var needComment = false;
                    $('.ecrireAvis').removeClass("hidden");
                    $('.ui.modal').modal('show');

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

                        $.each(data.responseJSON, function (key, value) {
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