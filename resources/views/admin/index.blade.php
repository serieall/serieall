@extends('layouts.admin')
@section('header_left')
    <li>
        <a href="#">
            Administration
        </a>
    </li>
    <li class="active">
        Séries
    </li>
@endsection

@section('header_right')
    <li>
        {{ Auth::user()->username }}
    </li>
@endsection

@section('content')
    <div>
        <h1 id="content-h1-admin" class="txtcenter">Bienvenue sur l'interface d'administration de Série-All.</h1>
        <p class="txtcenter">Veuillez choisir une section dans la partie de gauche.</p>
    </div>
@endsection