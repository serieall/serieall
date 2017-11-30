@extends('layouts.admin')

@section('pageTitle', 'Admin - Logs')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.system') }}" class="section">
        Système
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.contacts') }}" class="section">
        Contacts
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        {{ $contact->objet }}
    </div>
@endsection

@section('content')
    <div>
        <h1 class="ui header">
            {{ $contact->objet }} - {{ $contact->name }}
        </h1>
    </div>

    <p></p>

    <h2>Message de l'utilisateur :</h2>
    <div class="ui segment">
        {{ $contact->message }}
    </div>

    <form class="ui form" action="" method="POST">
        {{ csrf_field() }}

        <input name="admin_id" type="hidden" value="{{ Auth::user()->id }}">

        <textarea>

        </textarea>
        <br />

        <button class="ui disabled button">Envoyer le message</button>
    </form>
@endsection