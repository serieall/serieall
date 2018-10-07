@extends('layouts.app')

@section('pageTitle', 'Profil de ' . $user->username)

@section('content')
    <div class="ui ten wide column">
        <div class="ui center aligned">
            <div class="ui stackable compact pointing menu">
                <a class="item" href="{{ route('user.profile', $user->username ) }}">
                    <i class="user icon"></i>
                    Profil
                </a>
                <a class=" active item">
                    <i class="star icon"></i>
                    Notes
                </a>
                <a class="item">
                    <i class="comment icon"></i>
                    Avis
                </a>
                <a class="item">
                    <i class="tv icon"></i>
                    Séries
                </a>
                <a class="item">
                    <i class="ordered list icon"></i>
                    Classement
                </a>
                @if(Auth::check())
                    @if($user->username == Auth::user()->username)
                        <a class="item" href="{{ route('user.profile.parameters', $user->username ) }}">
                            <i class="settings icon"></i>
                            Paramètres
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="ui segment">
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
        </div>

        <div class="chartMean column">
            {!! $chart->html() !!}
        </div>

        <div class="ui segment">
            <h2>Moyennes détaillées des séries</h2>
            <div class="ui grid">
                <div class="row">
                    <div class="sixteen wide column divMiddleAligned">
                        <div>
                            <i class="filter icon"></i>Trier par : <a class="action" href="{{route('user.profile.rates', [$user->user_url, 'avg'])}}">Moyenne</a>
                            - <a class="action" href="{{route('user.profile.rates', [$user->user_url, 'showname'])}}">Série</a>
                            - <a class="action" href="{{route('user.profile.rates', [$user->user_url, 'nb_rate'])}}">Nombre de notes</a>
                        </div>
                    </div>
                    {{--TODO: Add search in rates--}}
                    {{--<div class="eight wide column right aligned">--}}
                        {{--<div class="ui icon input">--}}
                            {{--<input type="text" placeholder="Search...">--}}
                            {{--<i class="inverted circular search link icon"></i>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>

        <div id="cardsRates" class="ui four cards">
            @include('users.rates_cards')
        </div>
    </div>
@endsection

@section('scripts')
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
@endsection

{!! Charts::scripts() !!}
{!! $chart->script() !!}

