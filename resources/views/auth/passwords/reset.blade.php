@extends('layouts.app')

@section('pageTitle', 'Réinialisation du mot de passe')

@section('content')
    <div class="row">
        <div class="six wide column">
            <div class="ui pilled segment">
                <h1 class="div-center">Réinitialiser le mot de passe</h1>
                <form class="ui form" role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="field {{ $errors->has('email') ? ' error' : '' }}">
                        <label>Adresse E-mail</label>
                        <input name="email" placeholder="Adresse e-mail" type="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="field {{ $errors->has('password') ? ' error' : '' }}">
                        <label>Mot de passe</label>
                        <input name="password" placeholder="Mot de passe" type="password" value="{{ old('password') }}">

                        @if ($errors->has('password'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="field {{ $errors->has('password_confirmation') ? ' error' : '' }}">
                        <label>Confirmer le mot de passe</label>
                        <input name="password_confirmation" placeholder="Confirmer le mot de passe" type="password" value="{{ old('password_confirmation') }}">

                        @if ($errors->has('password_confirmation'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="div-center">
                        <button class="positive ui button" type="submit">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
