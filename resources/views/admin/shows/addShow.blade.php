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
        Ajouter une série
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter une série
        <div class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </div>
    </h1>
    <div class="ui centered grid">
        <div class="ten wide column segment">
            <form class="ui form" method="POST" action="{{ route('adminShow.store', $thetvdb_id) }}">
                {{ csrf_field() }}

                <div class="two fields">
                    <div class="field">
                        <label>ID de la série sur TheTVDV</label>
                        <input name="thetvdb_id" placeholder="TheTVDV ID" type="text">
                    </div>
                    <button class="positive ui button">Vérifier</button>
                </div>
                <button class="positive ui button" type="submit">Créer la série</button>
            </form>
        </div>
    </div>

@endsection