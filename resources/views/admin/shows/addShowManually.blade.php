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
    <div class="ui centered grid">
        <div class="ten wide column segment">
            <div class="ui tabular menu">
                <div class="item" data-tab="tab-name">Tab Name</div>
                <div class="item" data-tab="tab-name2">Tab Name 2</div>
            </div>
            <div class="ui tab" data-tab="tab-name">
                <!-- Tab Content !-->
            </div>
            <div class="ui tab" data-tab="tab-name2">
                <!-- Tab Content !-->
            </div>
        </div>
    </div>
@endsection