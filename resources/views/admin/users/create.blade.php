@extends('layouts.admin')

@section('breadcrumbs')
<a href="{{ route('admin') }}" class="section">
    Administration
</a>
<i class="right angle icon divider"></i>
<a href="{{ route('admin.users.index') }}" class="section">
    Utilisateurs
</a>
<i class="right angle icon divider"></i>
<div class="active section">
    Ajouter un nouvel utilisateur
</div>
@endsection

@section('content')
<div class="ui grid">
    <div class="ui height wide column">
        <h1 class="ui header" id="admin-titre">
            Ajouter un utilisateur
        </h1>
    </div>
</div>

<div class="ui centered grid">
    <div class="fifteen wide column segment">
        <div class="ui segment">
            <form class="ui form" action="{{ route('admin.users.store') }}" method="post">
                {{ csrf_field() }}

                <div class="ui two fields">
                    <div class="ui field {{ $errors->has('username') ? ' error' : '' }}">
                        <label for="username">Nom d'utilisateur</label>
                        <input id="username" name="username" value="{{ old('username') }}">

                        @if ($errors->has('username'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('username') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="ui field {{ $errors->has('role') ? ' error' : '' }}">
                        <label for="role">Rôle</label>
                        <select id="role" name="role" class="ui dropdown">
                            <option
                                value="1">Administrateur
                            </option>
                            <option
                                value="2">Rédacteur
                            </option>
                            <option
                                value="3">Membre VIP
                            </option>
                            <option
                                selected
                                value="4">Membre
                            </option>
                        </select>

                        @if ($errors->has('role'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('role') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="ui two fields">
                    <div class="field {{ $errors->has('password') ? ' error' : '' }}">
                        <label>Mot de passe</label>
                        <input name="password" placeholder="Mot de passe" type="password">

                        @if ($errors->has('password'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="field {{ $errors->has('password_confirmation') ? ' error' : '' }}">
                        <label>Confirmer le mot de passe</label>
                        <input name="password_confirmation" placeholder="Confirmer le mot de passe" type="password">

                        @if ($errors->has('password_confirmation'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="ui two fields">
                    <div class="ui field {{ $errors->has('email') ? ' error' : '' }}">
                        <label>Adresse E-mail</label>
                        <input name="email" placeholder="Adresse e-mail" type="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="ui field {{ $errors->has('edito') ? ' error' : '' }}">
                        <label for="edito">Edito</label>
                        <textarea id="edito" name="edito">{{ old('edito') }}</textarea>
                        @if ($errors->has('edito'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('edito') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="ui two fields">
                    <div class="ui field {{ $errors->has('antispoiler') ? ' error' : '' }}">
                        <label>Antispoiler</label>
                        <div id="dropdown-antispoiler" class="ui fluid search selection dropdown">
                            <input name="antispoiler" type="hidden" value="{{ old('antispoiler') }}">
                            <i class="dropdown icon"></i>
                            <span class="text">Choisir</span>
                            <div class="menu">
                                <div class="item" data-value="1">
                                    <i class="checkmark icon"></i>
                                    Oui
                                </div>
                                <div class="item" data-value="0">
                                    <i class="remove icon"></i>
                                    Non
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('antispoiler'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('antispoiler') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="ui field {{ $errors->has('website') ? ' error' : '' }}">
                        <label for="website">Site Internet</label>
                        <input id="website" name="website" value="{{ old('website') }}">

                        @if ($errors->has('website'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('website') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="ui two fields">
                    <div class="ui field {{ $errors->has('twitter') ? ' error' : '' }}">
                        <label for="twitter">Twitter</label>
                        <input id="twitter" name="twitter" value="{{ old('twitter') }}">

                        @if ($errors->has('twitter'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('twitter') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="ui field {{ $errors->has('facebook') ? ' error' : '' }}">
                        <label for="facebook">Facebook</label>
                        <input id="facebook" name="facebook" value="{{ old('facebook') }}">

                        @if ($errors->has('facebook'))
                        <div class="ui red message">
                            <strong>{{ $errors->first('facebook') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <button class="ui green button">Créer l'utilisateur</button>
            </form>
        </div>
    </div>
</div>
@endsection