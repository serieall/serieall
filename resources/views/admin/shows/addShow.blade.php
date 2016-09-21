@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ url('/admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ url('/admin/series') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Ajouter une série
    </div>
@endsection

@section('content')
    <h1 class="ui header" id="admin-titre">
        Ajouter une série
        <div class="sub header">
            Remplir le formulaire ci-dessous pour ajouter une nouvelle série
        </div>
    </h1>


    <div class="ui grid">
        <div class="four wide column">

        </div>
        <div class="eight wide column">
            <form class="ui form">
                <div class="field">
                    <label>First Name</label>
                    <input name="first-name" placeholder="First Name" type="text">
                </div>
                <div class="field">
                    <label>Last Name</label>
                    <input name="last-name" placeholder="Last Name" type="text">
                </div>
                <div class="field">
                    <div class="ui checkbox">
                        <input class="hidden" tabindex="0" type="checkbox">
                        <label>I agree to the Terms and Conditions</label>
                    </div>
                </div>
                <button class="ui button" type="submit">Submit</button>
            </form>
        </div>
        <div class="four wide column">

        </div>
    </div>

@endsection

