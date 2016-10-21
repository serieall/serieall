@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('adminIndex') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('adminShow.index') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter une série manuellement
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter une série manuellement
        <div class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </div>
    </h1>

    <div class="ui pointing secondary menu">
        <a class="item active" data-tab="first">First</a>
        <a class="item" data-tab="second">Second</a>
        <a class="item" data-tab="third">Third</a>
    </div>
    <div class="ui bottom attached tab segment active" data-tab="first">
        First
    </div>
    <div class="ui bottom attached tab segment" data-tab="second">
        Second
    </div>
    <div class="ui bottom attached tab segment" data-tab="third">
        Third
    </div>

    <script>
        $('.menu .item')
                .tab()
        ;
    </script>
@endsection