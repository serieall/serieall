@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profil de {{ $user->username }}</div>
                </div>
                @if(Auth::user()->id == $user->id)
                    <p>prout</p>
                @endif

            </div>
        </div>
    </div>
@endsection
