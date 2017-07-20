@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="five wide column">
            <form class="ui form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="field {{ $errors->has('username') ? ' error' : '' }}">
                    <label>Nom d'utilisateur</label>
                    <input name="username" placeholder="Nom d'utilisateur" type="text" value="{{ old('username') }}">

                    @if ($errors->has('username'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('username') }}</strong>
                        </div>
                    @endif
                </div>

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

                <div class="ui section divider"></div>

                <div class="field {{ $errors->has('g-recaptcha-response') ? ' error' : '' }}">
                    {!! app('captcha')->display($attributes = []) !!}

                    @if ($errors->has('g-recaptcha-response'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="field {{ $errors->has('cgu') ? ' error' : '' }}">
                    <div class="ui checkbox">
                        <input type="checkbox" name="cgu">
                        <label for="cgu">J'ai lu et j'accepte les conditions générales d'utilisation</label>
                    </div>

                    @if ($errors->has('cgu'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('cgu') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="div-center">
                    <button class="positive ui button" type="submit">S'incrire !</button>
                </div>
            </form>
        </div>
    </div>
@endsection
