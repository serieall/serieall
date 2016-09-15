@extends('layouts.admin')

@section('breadcrumbs')
    <li>
        <a href="{{ url('/admin') }}">
            Administration
        </a>
    </li>
    <li>
        Séries
    </li>
@endsection

@section('content')
    <div>
        <h1 id="content-h1-admin" class="txtcenter">Séries</h1>

        {!! $links !!}
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Chaines</th>
                    <th>Nationalités</th>
                    <th>Nombre de saisons</th>
                    <th>Nombre d'épisodes</th>
                </tr>
            </thead>
        @foreach($shows as $show)
            <tr>
                <td>
                    {{ $show->name }}
                </td>
                <td>
                    prout
                </td>
                <td>
                    prout
                </td>
                <td>
                    {{ $show->NB_SAISONS }}
                </td>
                <td>
                    {{ $show->NB_EPISODES }}
                </td>

            </tr>
        @endforeach
        </table>
    </div>
@endsection