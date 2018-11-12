@extends('layouts.app')

@section('pageTitle', 'Séries TV')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlock" class="fourteen wide column">
            <div class="ui segment">
                <h1>Liste des séries</h1>
                <div class="ui search labeled icon dropdown button channels">
                    <i class="tv icon"></i>
                    <span class="text">Filtrer sur les chaines</span>
                    <div class="menu">
                    </div>
                </div>
                <div class="ui search labeled icon dropdown button nationalities">
                    <i class="globe icon"></i>
                    <span class="text">Filtrer sur les nationalités</span>
                    <div class="menu">
                    </div>
                </div>
                <div class="ui search labeled icon dropdown button genres">
                    <i class="folder icon"></i>
                    <span class="text">Filtrer sur les genres</span>
                    <div class="menu">
                    </div>
                </div>

                <div class="ui floating labeled icon dropdown button">
                    <i class="sort icon"></i>
                    <span class="text">Trier</span>
                    <div class="menu">
                        <div class="item" data-value="1">
                            <i class="sort alphabet down icon"></i>
                            Par nom de série
                        </div>
                        <div class="item" data-value="2">
                            <i class="clock icon"></i>
                            Par date de sortie
                        </div>
                        <div class="item" data-value="2">
                            <i class="clock icon"></i>
                            Par date de sortie
                        </div>
                    </div>
                </div>
                <div class="ui basic segment">
                    @include('shows.index_cards')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ Html::script('/js/views/shows/index.js') }}
@endpush
