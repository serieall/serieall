@extends('layouts.app')

@section('pageTitle', $article->name)
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlockShow" class="eleven wide column">
            <div class="ui segment">
                <h1>{{ $article->name }}</h1>

                {{ $article->intro }}

                {!! $article->content !!}
            </div>
        </div>
        <div id="RightBlockShow">

        </div>
    </div>
@endsection

@section('scripts')
@endsection
