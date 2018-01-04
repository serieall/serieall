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

    <h2>Votre réponse :</h2>
    <form class="ui form" action="{{ route('admin.contacts.reply') }}" method="POST">
        {{ csrf_field() }}

        <input name="id" type="hidden" value="{{ $contact->id }}">
        <input name="email" type="hidden" value="{{ $contact->email }}">
        <input name="admin_id" type="hidden" value="{{ Auth::user()->id }}">

        <textarea name="admin_message"
            @if(!is_null($contact->admin_id))
                  disabled
            @endif
        >{{ $contact->admin_message }}</textarea>

        <br />
        <br />


        <button class="ui
        @if(!is_null($contact->admin_id))
                disabled
        @endif
        positive button">Envoyer le message</button>
    </form>

    <p class="ui info message">
        La suite de la conversation s'effectuera via le compte mail de l'association.
    </p>
@endsection