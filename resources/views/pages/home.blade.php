@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="containerSlider">

        <div data-am-fadeshow="next-prev-navigation">

            <!-- Radio -->
            <input type="radio" name="css-fadeshow" id="slide-1" />
            <input type="radio" name="css-fadeshow" id="slide-2" />
            <input type="radio" name="css-fadeshow" id="slide-3" />

            <!-- Slides -->
            <div class="fs-slides">
                @foreach($articlesUne as $article)
                    <div class="fs-slide" style="background-image: url({{ $article->image }});">
                        <!-- Add content to images (sample) -->
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-family: sans-serif; text-align: center; text-shadow: 0 0 20px rgba(0,0,0,0.5);">
                            <h1>{{ $article->name }}</h1>
                            <p>{{ $article->intro }}</p>
                            <p>{{ $article->users->username }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Quick Navigation -->
            <div class="fs-quick-nav">
                <label class="fs-quick-btn" for="slide-1"></label>
                <label class="fs-quick-btn" for="slide-2"></label>
                <label class="fs-quick-btn" for="slide-3"></label>
            </div>

            <!-- Prev Navigation -->
            <div class="fs-prev-nav">
                <label class="fs-prev-btn" for="slide-1"></label>
                <label class="fs-prev-btn" for="slide-2"></label>
                <label class="fs-prev-btn" for="slide-3"></label>
            </div>

            <!-- Next Navigation -->
            <div class="fs-next-nav">
                <label class="fs-next-btn" for="slide-1"></label>
                <label class="fs-next-btn" for="slide-2"></label>
                <label class="fs-next-btn" for="slide-3"></label>
            </div>

        </div>

    </div>

@endsection
