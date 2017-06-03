@extends('layouts.admin')
@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Système
    </div>
@endsection

@section('content')
    <div>
        <h1 class="ui header">
            Système
            <div class="sub header">
                L'endroit des gens qui n'ont pas peur des yeux
            </div>
        </h1>
    </div>

    <p></p>

    <div class="ui stackable grid">
        <div class="row">
            <div class="column">
                <a class="ui card" href="{{ route('admin.logs') }}">
                    <div class="content">
                        <div class="header"><i class="file text outline icon"></i>Logs</div>
                        <div class="description">
                            <p>Accéder à tous les logs de Série-All</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection