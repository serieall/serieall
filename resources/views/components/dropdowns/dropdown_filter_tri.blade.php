<div class="ui floating labeled icon dropdown {{ $slot }} button">
    <i class="filter icon"></i>
    <span class="text">Filtrer</span>
    <div class="menu">
        <div class="item" data-value="all">
            <i class="comments icon"></i>
            Tous les avis
        </div>
        <div class="item" data-value="1">
            <i class="green smile icon"></i>
            Avis favorables
        </div>
        <div class="item" data-value="2">
            <i class="grey meh icon"></i>
            Avis neutres
        </div>
        <div class="item" data-value="3">
            <i class="red frown icon"></i>
            Avis défavorables
        </div>
    </div>
</div>

<div class="ui floating labeled icon dropdown {{ $slot }} button">
    <i class="sort icon"></i>
    <span class="text">Trier</span>
    <div class="menu">
        <div class="item" data-value="1">
            <i class="sort alphabet down icon"></i>
            Par nom de série
        </div>
        <div class="item" data-value="2">
            <i class="clock icon"></i>
            Par chronologie
        </div>
    </div>
</div>

@push('scripts')
    {{ Html::script('/js/components/dropdowns/dropdown_filter_tri.js') }}
@endpush