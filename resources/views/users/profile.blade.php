@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profil de {{ $user->username }}</div>

                    @if (Auth::guest())
                        <div class="panel-body">
                            Mais tu n'es pas {{ $user->username }} !
                        </div>
                    @elseif(Auth::user()->id == $user->id)
                        <div class="panel-body">
                            C'est bien ton compte. T'es balèze.
                        </div>
                    @else
                        <div class="panel-body">
                            Mais tu n'es pas {{ $user->username }} ! Mais au moins t'es connecté, c'est bien.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
