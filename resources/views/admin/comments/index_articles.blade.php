@extends('layouts.admin')

@section('pageTitle', 'Admin - Avis')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.comments.index') }}" class="section">
        Commentaires
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Articles
    </div>
@endsection

@section('content')
    <div class="ui grid">
        <div class="ui height wide column">
            <h1 class="ui header" id="adminTitre">
                Modérer les avis d'articles
            </h1>
        </div>
    </div>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <div class="ui form">
                   @component('components.dropdowns.dropdown_article')
                   @endcomponent
                </div>
            </div>
            <div id="comment" class="ui segment">
                @include('admin.comments.info_message')
            </div>
        </div>
    </div>
@endsection