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
                <a class=" active item">
                    <i class="star icon"></i>
                    Notes
                </a>
                <a class="item" href="{{ route('user.profile.comments', $user->user_url ) }}">
                    <i class="comment icon"></i>
                    Avis
                </a>
                <a class="item" href="{{ route('user.profile.shows', $user->user_url ) }}">
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
                        <div class="ui statistic">
                            <div class="label">
                                <i class="tv icon"></i>
                                {{ $time_passed_shows }} devant l'écran
                            </div>
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

        <div class="chartMean column">
            {!! $chart->container() !!}
        </div>

        <div class="ui segment">
            <h2>Moyennes détaillées des séries</h2>
            <div class="ui grid">
                <div class="row">
                    <div class="sixteen wide column divMiddleAligned">
                        <div>
                            <i class="filter icon"></i>Trier par : <a class="action" href="{{route('user.profile.rates', [$user->user_url, 'avg'])}}">Moyenne</a>
                            - <a class="action" href="{{route('user.profile.rates', [$user->user_url, 'nb_rate'])}}">Nombre de notes</a>
                            - <a class="action" href="{{route('user.profile.rates', [$user->user_url, 'showname'])}}">Série</a>
                            - <a class="action" href="{{route('user.profile.rates', [$user->user_url, 'time'])}}">Temps passé</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="cardsRates" class="ui four cards">
            @include('users.rates_cards')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.action', function (e) {
            e.preventDefault();

            $('#cardsRates').addClass('loading');
            getCards($(this).attr('href'));
        });

        function getCards(page) {
            let cardsRates = '#cardsRates';
            $.ajax({
                url: page,
               dataType: 'json'
            }).done(function (data) {
                // On insére le HTML
                $(cardsRates).html(data);

                $(cardsRates).removeClass('loading');
            }).fail(function () {
                alert('Les notes n\'ont pas été chargées.');
                $(cardsRates).removeClass('loading');
            });
        }
    </script>
@endpush
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
{!! $chart->script() !!}

