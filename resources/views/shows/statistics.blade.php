@extends('layouts.fiche')

@section('pageTitle', 'Statistiques - ' . $showInfo['show']->name)

@section('content_fiche_middle')
    <div id="LeftBlock">
        <div class="ui segment">
            <h1>Meilleurs épisodes de la série</h1>
            <div class="ui fluid card imageFirstClassement">
                <div class="image">
                    <img src="{{ ShowPicture($topEpisodes[0]->show->show_url) }}">
                </div>
            </div>
            @foreach($topEpisodes as $episode)
                @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                    <a href="{{ route('episode.fiche', [$episode->show->show_url, $episode->season->name, $episode->numero, $episode->id]) }}">{{$episode->show->name}} / {{ sprintf('%02s', $episode->season->name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection
