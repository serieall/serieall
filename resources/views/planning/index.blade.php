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


@push('style')
    {{ Html::style('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css') }}
@endpush

@push('scripts')
    {!! $calendar->script() !!}
@endpush