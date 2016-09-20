@extends('layouts.admin')
@section('breadcrumbs')
    <div class="active section">
        Administration
    </div>
@endsection

@section('content')
    <div>
        <h1 class="ui header">
            Bienvenue sur l'administration de Série-All
            <div class="sub header">
                Veuillez choisir une section dans la partie gauche.
            </div>
        </h1>

        <div class="ui action input">
            <input placeholder="Search..." type="text">
            <button class="ui button">Search</button>
        </div>
    </div>
@endsection