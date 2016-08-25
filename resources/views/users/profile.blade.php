@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profil de {{ $user->username }}</div>

                    <!-- Si je suis un invité -->
                    @if (Auth::guest())
                        <div class="panel-body">

                        </div>
                    <!-- Si je suis connecté et que je suis l'utilisateur en question -->
                    @elseif(Auth::user()->id == $user->id)
                        <div class="panel-body">
                            Pour changer de mot de passe, clique sur le bouton ci-dessous. Ton ancien mot de passe te sera demandé.
                            <form class="center form-horizontal" role="form" method="GET" action="{{ url('profil/' . Auth::user()->username . '/changepassword') }}">
                                {{ csrf_field() }}

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @if (session('warning'))
                                    <div class="alert alert-warning">
                                        {{ session('warning') }}
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-key"></i> Changer mon mot de passe
                                </button>
                        </div>
                    <!-- Si je suis connecté mais que je ne suis pas l'utilisateur -->
                    @else
                        <div class="panel-body">
                            Mais tu n'es pas {{ $user->username }} ! Mais au moins t'es connecté, c'est bien.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
