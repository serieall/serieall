@extends('layouts.app')

@section('pageTitle', 'Association')

@section('content')
    <iframe class="association" id="haWidget" allowtransparency="true" scrolling="auto" src="https://www.helloasso.com/associations/association-serie-all/adhesions/adhesion-2022/widget" style="width: 100%; height: 750px; border: none;" onload="window.scroll(0, this.offsetTop)"></iframe>
@endsection

@push('scripts')
@endpush