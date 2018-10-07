@extends('layouts.app')

@section('pageTitle', 'Planning')

@section('content')
    <div class="calendar ui fourteen wide column">
        <div class="ui segment">
            <h1>Planning des sorties</h1>
            <div class="ui message">
                En <span class="t-blueSA">bleu</span>: les sorties US <br>
                En <span class="t-grey">gris</span> : les sorties FR
            </div>

            <br />
            {!! $calendar->calendar() !!}
        </div>
    </div>
@endsection

@section('scripts')
    {!! $calendar->script() !!}
@endsection