@extends('layouts.app')

@section('pageTitle', 'Planning')

@section('content')
    <div class="calendar ui fourteen wide column">
        <div class="ui segment">
            <h1>Planning des sorties</h1>

            <br />
            {!! $calendar->calendar() !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $calendar->script() !!}
@endpush