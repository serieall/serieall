@extends('layouts.fiche')

@section('pageTitle', 'Statistiques - ' . $showInfo['show']->name)

@section('content_fiche_middle')
    <div id="LeftBlock">
        <div class="ui segment">
            <h1>Meilleurs épisodes de la série</h1>

            @foreach($topEpisodes as $episode)
                @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                    <a href="{{ route('episode.fiche', [$episode->show_url, $episode->season_name, $episode->numero, $episode->id]) }}">{{$episode->sname}} / {{ sprintf('%02s', $episode->season_name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection
