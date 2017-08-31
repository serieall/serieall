@extends('layouts.fiche')

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
                        <a class="item" href="{{ route('show.seasons', [$showInfo['show']->show_url, $seasonInfo->name]) }}">
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
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant, $IDEpisodeSuivant]) }}
                                        @else
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant]) }}
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
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent, $IDEpisodePrecedent]) }}
                                        @else
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent]) }}
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
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent, $IDEpisodePrecedent]) }}
                                        @else
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodePrecedent]) }}
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
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant, $IDEpisodeSuivant]) }}
                                        @else
                                            {{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $numeroEpisodeSuivant]) }}
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
                    S{{ $seasonInfo->name }}E{{ $episodeInfo->numero }} -
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
                <p>
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
                                    {{ $episodeInfo->diffusion_us }}
                                </td>
                            @endif
                            @if($episodeInfo->diffusion_fr != '0000-00-00')
                                <td>
                                    {{ $episodeInfo->diffusion_fr }}
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
                                Réalisateurs
                            </th>
                            <th>
                                Scénaristes
                            </th>
                            <th>
                                Guests
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
            <div id="ListAvis" class="ui segment">
                <h1>Derniers avis sur l'épisode</h1>
                <div class="ui stackable grid">
                    <div class="row">
                        <div class="center aligned three wide column">
                            <img class="ui tiny image" src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            <span>Youkoulayley</span><br />
                            <span class="ui red text">Administrateur</span>
                        </div>
                        <div class="AvisBox center aligned twelve wide column">
                            <table class="ui grey left border table">
                                <tr>
                                    <td class="ui grey text AvisStatus">Avis neutre</td>
                                    <td class="right aligned">Déposé le 26/05/2017 à 9h53</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="AvisResume">
                                        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam
                                            dicta dolorem excepturi non nulla, obcaecati quo rerum sequi sint? Ab
                                            cumque deserunt doloribus iste, molestias provident quia repellat
                                            repellendus soluta?
                                        </div>
                                        <div>A culpa eius esse laboriosam neque nobis odio, sapiente. Aliquam
                                            animi, at consectetur earum eos itaque iure modi nisi nulla odio
                                            perspiciatis ...
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui grey text">10 réponses</td>
                                    <td class="LireAvis"><a>Lire l'avis complet ></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="center aligned three wide column">
                            <img class="ui tiny image" src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            <span>Youkoulayley</span><br />
                            <span class="ui red text">Administrateur</span>
                        </div>
                        <div class="AvisBox center aligned twelve wide column">
                            <table class="ui green left border table">
                                <tr>
                                    <td class="ui green text AvisStatus">Avis favorable</td>
                                    <td class="right aligned">Déposé le 26/05/2017 à 9h53</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="AvisResume">
                                        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam
                                            dicta dolorem excepturi non nulla, obcaecati quo rerum sequi sint? Ab
                                            cumque deserunt doloribus iste, molestias provident quia repellat
                                            repellendus soluta?
                                        </div>
                                        <div>A culpa eius esse laboriosam neque nobis odio, sapiente. Aliquam
                                            animi, at consectetur earum eos itaque iure modi nisi nulla odio
                                            perspiciatis ...
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui grey text">10 réponses</td>
                                    <td class="LireAvis"><a>Lire l'avis complet ></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="three wide column">

                        </div>
                        <div class="twelve wide column">
                            <div class="ui DarkBlueSerieAll button">
                                <i class="write icon"></i> Ecrire un avis
                            </div>
                            <a class="AllAvis" href="#"><p>Toutes les avis ></p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_right')
    <div class="ui stackable grid">
        <div class="row">
            <div class="ui segment center aligned">
                @if($episodeInfo->moyenne > $noteGood)
                    <p class="NoteSeason ui green text">
                @elseif($episodeInfo->moyenne > $noteNeutral && $episodeInfo->moyenne < $noteGood)
                    <p class="NoteSeason ui gray text">
                @else
                    <p class="NoteSeason ui red text">
                        @endif
                        {{ $episodeInfo->moyenne }}
                    </p>
                    <p>
                        {{ $episodeInfo->nbnotes }} notes
                    </p>

                    <div class="ui divider"></div>

                    @if(Auth::Check())
                        <form class="ui form">
                            <select class="ui compact search dropdown">
                                <option value="">Note</option>
                                @for($i = 1; $i <= 20 ;$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <button class="ui button">Valider</button>
                        </form>
                    @else
                        Vous devez être connecté pour pouvoir noter l'épisode.
                    @endif

                    <div class="ui divider"></div>

                    <div class="ui feed">
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div id="LastArticles" class="ui segment">
                <h1>Derniers articles sur l'épisode</h1>
                <div class="ui stackable grid">
                    <div class="row">
                        <div class="center aligned four wide column">
                            <img src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Affiche {{ $showInfo['show']->name }}" />
                        </div>
                        <div class="eleven wide column">
                            <a><h2>Critique 01.03</h2></a>
                            <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="center aligned four wide column">
                            <img src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Affiche {{ $showInfo['show']->name }}" />
                        </div>
                        <div class="eleven wide column">
                            <a><h2>Critique 01.02</h2></a>
                            <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="center aligned four wide column">
                            <img src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Affiche {{ $showInfo['show']->name }}" />
                        </div>
                        <div class="eleven wide column">
                            <a><h2>Critique 01.01</h2></a>
                            <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                        </div>
                    </div>
                </div>
                <a href="#"><p class="AllArticles">Tous les articles ></p></a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.ui.top.attached.tabular.menu .item')
            .tab()
        ;
    </script>
@endsection