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
                        <a class="active item">
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
                Notifications
            </h1>

            @if(count($unread_notifications) != 0)
                <button class="markAllasRead ui basic button">Tout marquer comme lu</button>
            @endif

            <div class="ui feed">
                @foreach($notifications as $notif)
                    <div class="event">
                    <div class="label">
                        <img src="{{ affichageAvatar($notif->data['user_id']) }}" alt="Avatar de {{ affichageUsername($notif->data['user_id']) }}">
                    </div>
                    <div class="content">
                        <div class="date">{{ formatDate('full', $notif->created_at)}}</div>
                        <div class="summary">
                            @if(is_null($notif->read_at))
                                <div class="ui red horizontal label">New</div>
                            @endif
                                <a href="{{ route('user.profile', affichageUserUrl($notif->data['user_id'])) }}">{{ affichageUsername($notif->data['user_id']) }}</a>
                                {{ $notif->data['title'] }}
                            |
                            <a class="markAsRead"  id="{{ $notif->id }}" href="{{ $notif->data['url'] }}">
                                Voir le message
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                <p></p>
                <div class="d-center">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.markAsRead').click(function(e) {
                e.preventDefault();

                link = $(this);

                $.ajax({
                    method: 'post',
                    url: '/notification',
                    data: {'_token': "{{csrf_token()}}", 'notif_id': link.attr('id'), 'markUnread': false},
                    dataType: "json"
                }).done(function () {
                    window.location.href = $(link).attr('href');
                });
            });
        });
    </script>
@endpush