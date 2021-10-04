@extends('layouts.app')

@section('pageTitle', 'Association')

@section('content')
    <div class="association-who ui b-lightBlueSA inverted fluid segment">
        <div class="wrap">
            <p class="d-center t-bold t-darkBlueSA"> Qui sommes-nous ? </p>
            <p class="d-center description t-darkBlueSA">
                L'association Série-All a pour objet l’hébergement virtuel d’un site internet participatif serieall.fr favorisant le
                partage sur l’univers des séries télévisées à travers : <br />
            </p>

            <ul class="t-darkBlueSA">
                <li>
                    la mise à disposition gratuite d’une base de données de séries télévisées comportant des fiches
                    série/saison/épisode détaillées ;
                </li>
                <li>
                    la création d’un profil personnel sur inscription gratuite permettant de noter et de laisser des avis sur
                    des séries, de commenter les critiques et dossiers du webzine, de créer un planning personnalisé selon
                    les séries renseignées ;
                </li>
                <li>
                    l’hébergement d’un webzine publiant des news, articles, dossiers, bilans, podcasts... ou tout autre
                    support original accessible gratuitement ;
                </li>
                <li>
                    l’hébergement d’un forum gratuit permettant aux membres d’échanger sur tous thèmes.
                </li>
             </ul>

            <p class="d-center description t-darkBlueSA">
                Ainsi que tous les autres moyens susceptibles de concourir à la réalisation de son objet. <br />

                L'association Série-All est disjointe de la Rédaction du site serieall.fr, et n'a pas autorité sur elle : seule
                l'équipe rédactionnelle du site peut prendre les décisions ayant directement trait au contenu et à la ligne
                éditoriale du site. L’association Série-All peut exprimer son avis uniquement à titre consultatif.
            </p>
        </div>
    </div>

    <iframe class="association" id="haWidget" allowtransparency="true" scrolling="auto" src="https://www.helloasso.com/associations/association-serie-all/adhesions/adhesion-2022/widget" style="width: 100%; height: 750px; border: none;" onload="window.scroll(0, this.offsetTop)"></iframe>
@endsection

@push('scripts')
@endpush