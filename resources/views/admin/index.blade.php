@extends('layouts.admin')
@section('header')
    <header id="header-admin" class="fr w90 pas">
        <div id="header-grid-admin" class="grid-2-1">
            <ul id="header-beadcrumbs-admin" class="fl">
                <li>
                    <a href="#">
                        Administration
                    </a>
                </li>
                <li class="active">
                    Séries
                </li>
            </ul>
            <div id="header-user-admin" class="txtright fr">
                {{ Auth::user()->username }}
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div>
        <h1 id="content-h1-admin" class="txtcenter">Bienvenue sur l'interface d'administration de Série-All.</h1>
        <p class="txtcenter">Veuillez choisir une section dans la partie de gauche.</p>
    </div>
@endsection