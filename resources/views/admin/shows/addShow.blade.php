@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ url('/admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ url('/admin/series') }}" class="section">
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
        <div class="eight wide column segment">
            <form class="ui form" method="POST" action="{{ route('admin.show.store') }}">
                {{ csrf_field() }}

                <div class="two fields">
                    <div class="field">
                        <label>ID de la série sur TheTVDV</label>
                        <input name="thetvdb_id" placeholder="TheTVDV ID" type="text">
                    </div>
                    <div class="disabled field">
                        <label>Nom de la série</label>
                        <input placeholder="Le nom de la série apparait ici" disabled="" tabindex="-1" type="text">
                    </div>
                </div>


            </form>
        </div>
    </div>

@endsection