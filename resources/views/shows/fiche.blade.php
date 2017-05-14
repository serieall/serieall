@extends('layouts.app')

@section('content')

    <div id="topImage" class="row">
        <div class="sixteen wide column">
            <img src="{{ $folderShows }}{{ $show->show_url }}.jpg" alt="Banniere {{ $show->name }}" />
        </div>
    </div>


@endsection
