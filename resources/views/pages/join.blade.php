@extends('layouts.app')

@section('pageTitle', 'Nous rejoindre')
@section('pageDescription', 'Comment faire pour nous rejoindre ?')

@section('content')
    <div class="ten wide column">
        <div class="ui segment article">
            <h1>Rejoindre l'équipe</h1>
            <p>
                Vous pouvez nous contacter par email si :

                <ul>
                    <li>vous voulez nous suggérer une amélioration / constater un bug</li>
                    <li>vous souhaitez devenir rédacteur sur serieall.fr</li>
                    <li>vous êtes intéressés par un espace publicitaire sur le site</li>
                    <li>vous voulez nous proposer un partenariat (nous étudions toute demande)</li>
                    <li>vous avez quelque chose de complètement différent à nous dire</li>
                </ul>

            Contactez nous par mail : <a href="mailto:serieall.fr@gmail.com">serieall.fr@gmail.com</a>. <br>
            Ou via le <a href="{{route('contact')}}">formulaire de contact</a>.

            </p>
        </div>
    </div>
@endsection