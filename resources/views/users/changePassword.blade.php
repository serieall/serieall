@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Changement de mot de  passe pour {{ $user->username }}</div>

                <!-- Si je suis un invité -->
                @if (Auth::guest())
                <div class="panel-body">
                    Mais dis donc. Qu'est-ce que t'essaies de faire ?
                </div>
                <!-- Si je suis connecté et que je suis l'utilisateur en question -->
                @elseif(Auth::user()->id == $user->id)
                <div class="panel-body">
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/profil' . Auth::user()->username . 'changepassword') }}">
                        <div class="form-group{{ $errors->has('password_old') ? ' has-error' : '' }}">
                            <label for="password_old" class="col-md-4 control-label">Ancien mot de passe</label>

                            <div class="col-md-6">
                                <input id="password_old" type="password" class="form-control" name="password_old">

                                @if ($errors->has('password_old'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_old') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Nouveau mot de passe</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmation du nouveau mot de passe</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-key"></i> Changer le mot de passe
                                </button>
                            </div>
                        </div>
                </div>
                <!-- Si je suis connecté mais que je ne suis pas l'utilisateur -->
                @else
                <div class="panel-body">
                    Mais dis donc. Qu'est-ce que t'essaies de faire ?
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
