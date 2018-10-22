<table id="tableAdmin" class="ui sortable selectable celled table">
    <thead>
    <tr>
        @foreach($headers as $header)
            <th>{{$header}}</th>
        @endforeach
    </tr>
    </thead>
    {{ $slot }}
</table>

@push('scripts')
    {{ Html::script('/js/components/tables/table_admin.js') }}
@endpush