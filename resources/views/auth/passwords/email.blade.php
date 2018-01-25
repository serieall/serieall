@extends('layouts.app')

@section('pageTitle', 'Réinialisation du mot de passe')

<!-- Main Content -->
@section('content')
    <div class="row">
        <div class="six wide column">
            <div class="ui pilled segment">
                <h1 class="d-center">Réinitialiser le mot de passe</h1>
                <form class="ui form" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}

                    <div class="field {{ $errors->has('email') ? ' error' : '' }}">
                        <label>Adresse E-mail</label>
                        <input name="email" placeholder="Adresse e-mail" type="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="d-center">
                        <button class="positive ui button" type="submit">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
