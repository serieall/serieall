@extends('layouts.app')

@section('pageTitle', 'Contact')
@section('pageDescription', 'Formulaire de contact de l\'équipe de Série-All.')

@section('content')
    <div class="ten wide column">
        <div class="ui segment">
            <h1>Formulaire de contact</h1>
            <form class="ui form" action="{{ route('contact.send') }}" method="POST">
                {{ csrf_field() }}
                <div class="ui required field {{ $errors->has('name') ? ' error' : '' }}">
                    <label>Prénom ou pseudo</label>
                    <input name="name" placeholder="Votre prénom ou pseudo" value="{{ old('name') }}">

                    @if ($errors->has('name'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="ui required field {{ $errors->has('email') ? ' error' : '' }}">
                    <label>E-Mail</label>
                    <input name="email" placeholder="Votre adresse E-Mail" type="email" value="{{ old('email') }}">

                    @if ($errors->has('email'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="ui required field {{ $errors->has('objet') ? ' error' : '' }}">
                    <label>Objet</label>
                    <input name="objet" placeholder="L'objet de votre demande" value="{{ old('objet') }}">

                    @if ($errors->has('objet'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('objet') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="ui required field {{ $errors->has('message') ? ' error' : '' }}">
                    <label for="message">Message</label>
                    <textarea id="message" name="message">{{ old('message') }}</textarea>

                    @if ($errors->has('message'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('message') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="ui required field {{ $errors->has('captcha') ? ' error' : '' }}">
                    <img src="{{ captcha_src() }}" id="captcha_image">
                    <span id="reload_captcha" class="ui icon" data-tooltip="Changer l'image">
                            <i class="sync icon"></i>
                        </span>

                    <label for="captcha">Entrer le code</label>
                    <input type="text" name="captcha">
                    @if ($errors->has('captcha'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </div>
                    @endif
                </div>

                <button class="ui positive button">Envoyer</button>
            </form>
        </div>
    </div>
@endsection