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
        <h1 id="content-h1-admin" class="txtcenter">Liste des séries</h1>

        {!! $links !!}
        <input id="search" name="search" placeholder="Start typing here" type="text" data-list=".list">
        <table class="tableSearch">
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
                    @foreach($show->channels as $channel)
                        {{ $channel->name }}
                    @endforeach
                </td>
                <td>
                    @foreach($show->nationalities as $nationality)
                        {{ $nationality->name }}
                    @endforeach
                </td>
                <td>
                    {{ $show->seasons_count }}
                </td>
                <td>
                    {{ $show->episodes_count }}
                </td>
            </tr>
        @endforeach
        </table>
    </div>
@endsection

<script type="text/javascript">
    $(document).ready(function(){
        $('table.search-table').tableSearch({
            searchText:'Search Table',
            searchPlaceHolder:'Input Value'
        });
    });
</script>