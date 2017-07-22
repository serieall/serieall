@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="six wide column">
            <div class="ui pilled segment">
                <!-- Si je suis un invité -->
                @if (Auth::guest())
                    Voici le profil de {{ $user->username }}, mais étant invité, vous n'avez pas accès au contenu.
                <!-- Si je suis connecté et que je suis l'utilisateur en question -->
                @elseif(Auth::user()->id == $user->id)
                    <h1 class="div-center">Modification de votre mot de passe</h1>
                    <br />

                    <form class="ui form" method="POST" action="{{ route('user.changepassword') }}">
                        {{ csrf_field() }}

                        <div class="field {{ $errors->has('password') ? ' error' : '' }}">
                            <label>Ancien mot de passe</label>
                            <input name="password" placeholder="Mot de passe" type="password" value="{{ old('password') }}">

                            @if ($errors->has('password'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('new_password') ? ' error' : '' }}">
                            <label>Nouveau mot de passe</label>
                            <input name="new_password" placeholder="Mot de passe" type="password" value="{{ old('new_password') }}">

                            @if ($errors->has('new_password'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('new_password_confirmation') ? ' error' : '' }}">
                            <label>Confirmer le nouveau mot de passe</label>
                            <input name="new_password_confirmation" placeholder="Mot de passe" type="password" value="{{ old('new_password_confirmation') }}">

                            @if ($errors->has('new_password_confirmation'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="div-center">
                            <button class="positive ui button" type="submit">Valider</button>
                        </div>
                    </form>
                <!-- Si je suis connecté mais que je ne suis pas l'utilisateur -->
                @else
                    Mais vous n'êtes pas {{ $user->username }} ! Mais au moins vous êtes connecté. Bien.
                @endif
            </div>
        </div>
    </div>
@endsection
