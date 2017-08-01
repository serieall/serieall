@extends('layouts.app')

@section('content')
    <div class="ten wide column">
        <div class="ui centered stackable grid">
            <div class="ui stackable secondary menu">
                    <div class="ui stackable grid">
                        <a class="active item" data-tab="home">Profil</a>
                        <a class="item" data-tab="parameters">Paramètres</a>
                    </div>
            </div>

            <div class="ui row">
                <div class="ui tab" data-tab="home">

                </div>
                <div class="ui tab" data-tab="parameters">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.ui.stackable.secondary.menu .item')
            .tab({
                path: 'profil/{{ $user->username }}/',
                auto: true
            })
        ;
    </script>
@endsection