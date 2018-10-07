@extends('layouts.admin')

@section('pageTitle', 'Admin - Episodes')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.system') }}" class="section">
        Système
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.slogans') }}" class="section">
        Slogans
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        {{trim($slogan->message, 10) . "..."}}
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="adminTitre">
        {{trim($slogan->message, 50) . "..."}}
        <span class="sub header">
            Modifier le slogan
        </span>
    </h1>

    <div class="ui centered grid">
        <div class="fifteen wide column segment">
            <div class="ui segment">
                <form class="ui form" action="{{ route('admin.slogans.update') }}" method="POST">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $slogan->id }}">

                    <div class="ui field {{ $errors->has('message') ? ' error' : '' }}">
                        <label for="message">
                            Slogan
                        </label>
                        <textarea name="message" id="message">{{ $slogan->message }}</textarea>

                        @if ($errors->has('message'))
                            <div class="ui red message">
                                <strong>{{ $errors->first('message') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui two fields">
                        <div class="ui field {{ $errors->has('source') ? ' error' : '' }}">
                            <label for="source">Slogan</label>
                            <input id="source" name="source" value="{{ $slogan->source }}">

                            @if ($errors->has('source'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('source') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="ui field {{ $errors->has('url') ? ' error' : '' }}">
                            <label for="url">Saison</label>
                            <input id="url" name="url" value="{{ $slogan->url }}">

                            @if ($errors->has('url'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button class="ui green button">Modifier</button>
                </form>
            </div>
        </div>
    </div>
@endsection
