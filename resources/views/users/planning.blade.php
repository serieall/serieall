@extends('layouts.app')

@section('pageTitle', 'Profil de ' . $user->username)

@section('content')
    <div class="ui ten wide column">
        <div class="ui segment">
            {!! $calendar->calendar() !!}
        </div>
    </div>
@endsection

@push('style')
    {{ Html::style('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css') }}
@endpush

@push('scripts')
    <script src="/js/libs/fullcalendar.min.js"></script>
    {!! $calendar->script() !!}
@endpush