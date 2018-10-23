@extends('layouts.admin')

@section('pageTitle', 'Admin - Utilisateurs')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Commentaires
    </div>
@endsection

@section('content')
    <div class="ui basic modal" style="position: relative">
        <div class="content">
            <div class="ui two column very relaxed grid">
                <div class="ui center aligned column">
                    <a href="{{ route('admin.comments.indexShows') }}">
                        <button class="ui massive inverted icon blue button"><i class="tv icon"></i> Avis sur les séries</button>
                    </a>
                </div>
                <div class="ui center aligned column">
                    <button class="ui massive inverted icon green button"><i class="file text outline icon"></i> Avis sur les articles</button>
                </div>
            </div>
            <div class="ui vertical divider t-white">
                ou
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.ui.modal')
            .modal('setting', 'transition', 'vertical flip')
            .modal({inverted: true})
            .modal('show')
            .modal('setting', 'closable', false)
    </script>
@endpush