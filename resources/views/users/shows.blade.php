@extends('layouts.app')

@section('pageTitle', 'Profil de ' . $user->username)

@section('content')
    <div class="ui ten wide column">
        <div class="ui center aligned">
            <div class="ui stackable compact pointing menu">
                <a class="item" href="{{ route('user.profile', $user->user_url ) }}">
                    <i class="user icon"></i>
                    Profil
                </a>
                <a class="item" href="{{ route('user.profile.rates', $user->user_url ) }}">
                    <i class="star icon"></i>
                    Notes
                </a>
                <a class="item" href="{{ route('user.profile.comments', $user->user_url ) }}">
                    <i class="comment icon"></i>
                    Avis
                </a>
                <a class="active item">
                    <i class="tv icon"></i>
                    Séries
                </a>
                <a class="item" href="{{ route('user.profile.ranking', $user->user_url ) }}">
                    <i class="ordered list icon"></i>
                    Classement
                </a>
                @if(Auth::check())
                    @if($user->username == Auth::user()->username)
                        <a class="item" href="{{ route('user.profile.planning', $user->user_url ) }}">
                            <i class="calendar icon"></i>
                            Mon planning
                        </a>
                        <a class="item" href="{{ route('user.profile.notifications', $user->user_url ) }}">
                            <i class="alarm icon"></i>
                            Notifications
                        </a>
                        <a class="item" href="{{ route('user.profile.parameters', $user->user_url ) }}">
                            <i class="settings icon"></i>
                            Paramètres
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="ui segment">
            <div class="ui items">
                <div class="ui grid stackable">
                    <div class="eight wide column">
                        <div class="ui items">
                            <div class="item">
                        <span class="ui tiny image">
                            <img src="{{ Gravatar::src($user->email) }}">
                        </span>
                                <div class="content">
                                    <a class="header">{{ $user->username }}</a><br />
                                    {!! roleUser($user->role) !!}
                                    <div class="description">
                                        <p>"<i>{{ $user->edito }}"</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui statistic">
                            <div class="label">
                                <i class="tv icon"></i>
                                {{ $time_passed_shows }} devant l'écran
                            </div>
                        </div>
                    </div>
                    <div class="ui center aligned eight wide column">
                        <div class="ui three statistics">
                            <div class="ui statistic">
                                <div class="label">
                                    Moyenne
                                </div>
                                <div class="value">
                                    {!! affichageNote($avg_user_rates->avg) !!}
                                </div>
                            </div>
                            <div class="ui statistic">
                                <div class="label">
                                    Nombre de notes
                                </div>
                                <div class="value">
                                    {{$avg_user_rates->nb_rates}}
                                </div>
                            </div>
                            <div class="ui statistic">
                                <div class="label">
                                    Nombre d'avis
                                </div>
                                <div class="value">
                                    {{$nb_comments}}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="ui mini three statistics">
                            <div class="statistic">
                                <div class="value">
                                    <i class="green smile icon"></i>
                                    @if($comment_fav)
                                        {{ $comment_fav->total }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="label">
                                    Favorables
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="grey meh icon"></i>
                                    @if($comment_neu)
                                        {{ $comment_neu->total }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="label">
                                    Neutres
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="red frown icon"></i>
                                    @if($comment_def)
                                        {{ $comment_def->total }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="label">
                                    Défavorables
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($user->facebook) || !empty($user->twitter) || !empty($user->website))
                <h3>Ses liens :</h3>
                @if(!empty($user->facebook))
                    <button class="ui facebook button" onclick="window.location.href='https://www.facebook.com/{{ $user->facebook }}'">
                        <i class="facebook icon"></i>
                        Facebook
                    </button>
                @endif

                @if(!empty($user->twitter))
                    <button class="ui twitter button" onclick="window.location.href='https://www.twitter.com/{{ $user->twitter }}'">
                        <i class="twitter icon"></i>
                        Twitter
                    </button>
                @endif

                @if(!empty($user->website))
                    <button class="ui grey button" onclick="window.location.href='{{ $user->website }}'">
                        <i class="at icon"></i>
                        Site Internet
                    </button>
                @endif
            @endif
        </div>
        <div class="ui segment">
            <h1 class="ui header t-darkBlueSA">
                Séries en cours
                <span class="sub header">
                    Ce sont les séries en cours de visionnage, qu'elles soient terminées ou non. Elles apparaissent dans votre planning personnalisé.
                </span>
            </h1>

            <div id="InProgressBox">
                @include('users.shows_cards')
            </div>

            <p></p>

            <form id="formInProgress" class="ui form" method="POST" action="{{ route('user.followshow') }}">
                {{ csrf_field() }}

                <input name="state" type="hidden" value="1">

                <div class="two fields">
                    <div class="ui fluid multiple search selection dropdown" id="InProgressShows">
                        <input name="shows" type="hidden">
                        <i class="dropdown icon"></i>
                        <div class="default text">Choisir une ou plusieurs séries</div>
                        <div class="menu">
                        </div>
                    </div>
                    <div class="ui red message hidden"></div>

                    <button type="submit" class="positive ui button">
                        Ajouter
                    </button>
                </div>
            </form>

            <h1 class="ui header t-darkBlueSA">
                Séries en pause
                <span class="sub header">
                    Ce sont les séries que vous suivez et qui vont reprendre prochainement.
                </span>
            </h1>
            @if(count($on_break_shows) == 0)
                @component('components.message_simple', ['type' => 'info'])
                    Pas de séries en pause
                @endcomponent
            @endif
            <div id="cardsRates" class="ui five cards stackable">
                @foreach($on_break_shows as $show)
                    @component('components.cards.followed_shows_cards', ['show' => $show])
                    @endcomponent
                @endforeach
            </div>

            <p></p>

            {{--<form class="ui form" action="">--}}
                {{--<div class="two fields">--}}
                    {{--<div class="ui fluid multiple search selection dropdown" id="OnBreakShows">--}}
                        {{--<input name="in_progress" type="hidden">--}}
                        {{--<i class="dropdown icon"></i>--}}
                        {{--<div class="default text">Choisir une ou plusieurs séries</div>--}}
                        {{--<div class="menu">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@component('components.buttons.button', ['type' => 'positive'])--}}
                        {{--Ajouter--}}
                    {{--@endcomponent--}}
                {{--</div>--}}
            {{--</form>--}}

            <h1 class="ui header t-darkBlueSA">
                Séries terminées
                <span class="sub header">
                    Ce sont les séries terminées que vous avez regardées entièrement.
                </span>
            </h1>
            @if(count($completed_shows) == 0)
                @component('components.message_simple', ['type' => 'info'])
                    Pas de séries terminées
                @endcomponent
            @endif
            <div id="cardsRates" class="ui five cards stackable">
                @foreach($completed_shows as $show)
                    @component('components.cards.followed_shows_cards', ['show' => $show])
                    @endcomponent
                @endforeach
            </div>

            <p></p>

            {{--<form class="ui form" action="">--}}
                {{--<div class="two fields">--}}
                    {{--<div class="ui fluid multiple search selection dropdown" id="CompletedShows">--}}
                        {{--<input name="in_progress" type="hidden">--}}
                        {{--<i class="dropdown icon"></i>--}}
                        {{--<div class="default text">Choisir une ou plusieurs séries</div>--}}
                        {{--<div class="menu">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@component('components.buttons.button', ['type' => 'positive'])--}}
                        {{--Ajouter--}}
                    {{--@endcomponent--}}
                {{--</div>--}}
            {{--</form>--}}

            <h1 class="ui header t-darkBlueSA">
                Séries à voir
                <span class="sub header">
                     Ce sont les séries que vous avez prévu de regarder prochainement.
                </span>
            </h1>
            @if(count($to_see_shows) == 0)
                @component('components.message_simple', ['type' => 'info'])
                    Pas de séries à voir
                @endcomponent
            @endif
            <div id="cardsRates" class="ui five cards stackable">
                @foreach($to_see_shows as $show)
                    @component('components.cards.followed_shows_cards', ['show' => $show])
                    @endcomponent
                @endforeach
            </div>

            <p></p>

            {{--<form class="ui form" action="">--}}
                {{--<div class="two fields">--}}
                    {{--<div class="ui fluid multiple search selection dropdown" id="ToSeeShows">--}}
                        {{--<input name="in_progress" type="hidden">--}}
                        {{--<i class="dropdown icon"></i>--}}
                        {{--<div class="default text">Choisir une ou plusieurs séries</div>--}}
                        {{--<div class="menu">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@component('components.buttons.button', ['type' => 'positive'])--}}
                        {{--Ajouter--}}
                    {{--@endcomponent--}}
                {{--</div>--}}
            {{--</form>--}}

            <h1 class="ui header t-darkBlueSA">
                Séries abandonnées
                <span class="sub header">
                      Ce sont les séries que vous avez abandonnées avant la fin. Expliquez-nous la raison.
                </span>
            </h1>
            @if(count($abandoned_shows) == 0)
                @component('components.message_simple', ['type' => 'info'])
                    Pas de séries abandonées
                @endcomponent
            @endif
            <div id="cardsRates" class="ui items stackable">
                @foreach($abandoned_shows as $show)
                    @component('components.cards.abandoned_shows_cards', ['show' => $show])
                    @endcomponent
                @endforeach
            </div>

            <p></p>

            {{--<form class="ui form" action="">--}}
                {{--<div class="two fields">--}}
                    {{--<div class="ui fluid multiple search selection dropdown" id="AbandonedShows">--}}
                        {{--<input name="in_progress" type="hidden">--}}
                        {{--<i class="dropdown icon"></i>--}}
                        {{--<div class="default text">Choisir une ou plusieurs séries</div>--}}
                        {{--<div class="menu">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@component('components.buttons.button', ['type' => 'positive'])--}}
                        {{--Ajouter--}}
                    {{--@endcomponent--}}
                {{--</div>--}}
            {{--</form>--}}
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        InProgressBox = '.InProgressBox';
        OnBreakBox = '.OnBreakBox';
        CompletedBox = '.CompletedBox';
        AbandonedBox = '.AbandonedBox';
        ToSeeBox = '.ToSeeBox';

        $(document).ready(function() {
            $('#InProgressShows').dropdown({
                apiSettings: {
                    url: '/api/shows/list?name-lk=*{query}*',
                },
                fields: {
                    remoteValues: 'data',
                    value: 'id',
                },
                clearable: true
            });

            $('#OnBreakShows').dropdown({
                apiSettings: {
                    url: '/api/shows/list?name-lk=*{query}*',
                },
                fields: {
                    remoteValues: 'data',
                    value: 'id',
                },
                clearable: true
            });

            $('#CompletedShows').dropdown({
                apiSettings: {
                    url: '/api/shows/abandoned/list?name-lk=*{query}*',
                },
                fields: {
                    remoteValues: 'data',
                    value: 'id',
                },
                clearable: true
            });

            $('#ToSeeShows').dropdown({
                apiSettings: {
                    url: '/api/shows/list?name-lk=*{query}*',
                },
                fields: {
                    remoteValues: 'data',
                    value: 'id',
                },
                clearable: true
            });

            $('#AbandonedShows').dropdown({
                apiSettings: {
                    url: '/api/shows/list?name-lk=*{query}*',
                },
                fields: {
                    remoteValues: 'data',
                    value: 'id',
                },
                clearable: true
            });

            $(document).on('submit', '#formInProgress', function(e) {
                e.preventDefault();

                $(InProgressBox).addClass('loading');
                $(OnBreakBox).addClass('loading');
                $(CompletedBox).addClass('loading');
                $(AbandonedBox).addClass('loading');
                $(ToSeeBox).addClass('loading');

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json"
                }).done(function (data) {
                    // On insére le HTML
                    $(InProgressBox).html(data);
                    $(OnBreakBox).html(data);
                    $(CompletedBox).html(data);
                    $(AbandonedBox).html(data);
                    $(ToSeeBox).html(data);

                    $(InProgressBox).removeClass('loading');
                    $(OnBreakBox).removeClass('loading');
                    $(CompletedBox).removeClass('loading');
                    $(AbandonedBox).removeClass('loading');
                    $(ToSeeBox).removeClass('loading');

                }).fail(function () {
                    alert('La série n\'a pas pu être ajoutée.');
                    $(InProgressBox).removeClass('loading');
                });
            });
        });
    </script>
@endpush