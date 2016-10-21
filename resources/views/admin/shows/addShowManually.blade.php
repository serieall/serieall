@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('adminIndex') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('adminShow.index') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter une série
    </div>
@endsection

@section('content')
    <div class="ui button">Activate Tab</div>
    <div class="ui tab" data-tab="tab-name">
        <!-- Tab Content !-->
    </div>

    <script>
        $('.ui.button')
                .on('click', function() {
                    // programmatically activating tab
                    $.tab('change tab', 'tab-name');
                })
        ;
    </script>
@endsection