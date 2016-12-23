@extends('layouts.admin')
@section('breadcrumbs')
    <div class="active section">
        Administration
    </div>
@endsection

@section('content')
    <div>
        <h1 class="ui header">
            {{ $log->job }} - {{ $log->object }} /
            @if($log->object_id != 0)
                {{$log->object_id }}
            @else
                All
            @endif
        </h1>
        <div class="sub header">
            Lancé par
            @if(!is_null($log->user))
                {{ $log->user->username }}
            @else
                System
            @endif
        </div>
    </div>

    <p></p>

    <table class="ui very compact table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Message</th>
            </tr>
        </thead>

        @foreach($log->logs as $log)
            <tr>
                <td class="collapsing">{{ $log->created_at }}</td>
                <td>{{ $log->message }}</td>
            </tr>
        @endforeach

    </table>
@endsection