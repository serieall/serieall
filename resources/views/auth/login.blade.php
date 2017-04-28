@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="five wide column">
            <form class="ui form" method="POST" action="{{ url('/login') }}">
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

                <div class="field {{ $errors->has('password') ? ' error' : '' }}">
                    <label>Mot de passe</label>
                    <input name="password" placeholder="Mot de passe" type="password" value="{{ old('password') }}">

                    @if ($errors->has('password'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="field {{ $errors->has('remember') ? ' error' : '' }}">
                    <div class="ui checkbox">
                        <input type="checkbox" name="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>

                    @if ($errors->has('remember'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('remember') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="div-center">
                    <div class="ui large buttons">
                        <button class="ui positive button">Se connecter</button>
                        <div class="or"></div>
                        <a href="{{ url('/password/reset') }}" class="ui negative button">Mot de passe oublié</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
