@extends('layouts.admin')

@section('pageTitle', 'Admin - Utilisateurs')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Utilisateurs
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="adminTitre">
                    Utilisateurs
                    <span class="sub header">
                    Liste de tous les utilisateurs de Série-All
                </span>
                </h1>
            </div>
            <div class="ui height wide column">
                <form action="{{ route('admin.users.create') }}">
                    <button class="ui right floated green button">
                        <i class="ui add icon"></i>
                        Ajouter un nouvel utilisateur
                    </button>
                </form>
            </div>
        </div>

        <div class="ui centered grid">
            <div class="fifteen wide column segment">
                <div class="ui segment">
                    <div class="ui form">
                        <div class="ui field">
                            <label for="user">Choisir l'utilisateur</label>
                            <div id="dropdownUser" class="ui search selection dropdown">
                                <input id="inputUser" name="show" type="hidden" value="{{ old('user') }}">
                                <i class="dropdown icon"></i>
                                <div class="default text">Utilisateur</div>
                                <div class="menu">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="user" class="ui segment">
                    @component('components.message_simple')
                        @slot('type')
                            info
                        @endslot

                        Pas d'utilisateur à afficher.
                    @endcomponent
                </div>
            </div>
        </div>

@endsection

@push('scripts')
    {{Html::script('js/views/admin/users/index.js')}}
@endpush

