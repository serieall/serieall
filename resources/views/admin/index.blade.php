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
                Là où il y a quelques infos.
            </div>
        </h1>
    </div>

    <p></p>

    <div class="ui compact piled segment">
        <h2>
            Les 10 dernières actions
        </h2>

        <table class="ui collapsing celled table">
            <thead>
                <tr>
                    <th>Nom de l'action</th>
                    <th>Objet modifié</th>
                    <th>ID de l'objet</th>
                    <th>Utilisateur</th>
                    <th>Date</th>
                </tr>
            </thead>

            @foreach($logs as $log)
                <tr>
                    <td><a href="{{ route('admin.logs.view', $log->id) }}">{{ $log->job }}</a></td>
                    <td>{{ $log->object }}</td>
                    <td>
                        @if($log->object_id != 0)
                            {{$log->object_id }}
                        @else
                            All
                        @endif
                    </td>
                    <td>
                        @if(!is_null($log->user) || $log->user != 0)
                            {{ $log->user->username }}
                        @else
                            System
                        @endif
                    </td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach

            </table>
        </div>
@endsection