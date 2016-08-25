@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profil de {{ $user->username }}</div>
                </div>
                @if (Auth::guest())
                    <div class="panel-body">
                        <p>Mais tu n'es pas {{ $user->username }} !</p>
                    </div>
                @elseif(Auth::user()->id == $user->id)
                    <div class="panel-body">
                        <p>C'est bien ton compte. T'es balèze.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
