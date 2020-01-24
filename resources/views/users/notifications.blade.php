@extends('layouts.app')

@section('pageTitle', 'Profil de ' . $user->username)

@section('content')
    <div class="ui ten wide column">
        <div class="ui segment">
            @if(count($unread_notifications) != 0)
                <button class="markAllasRead ui basic button">Tout marquer comme lu</button>
            @endif

            <div class="ui feed">
                @if($notifications->count() != 0)
                    @foreach($notifications as $notif)
                        <div class="event">
                        <div class="label">
                            <img src="{{ affichageAvatar($notif->data['user_id']) }}" alt="Avatar de {{ affichageUsername($notif->data['user_id']) }}">
                        </div>
                        <div class="content">
                            <div class="date">{!! formatDate('full', $notif->created_at)!!}</div>
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
                @else
                    <div class="ui placeholder segment">
                        <div class="ui icon header">
                            <i class="frown outline icon"></i>
                            Pas encore de notifications. Notez, commentez et échanger avec les autres membres pour remplir cette page !
                        </div>
                    </div>
                @endif
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