@extends('layouts.admin')
@section('header')
    <header id="header-admin" class="fr w90 pas">
        <div id="header-grid-admin" class="grid-2-1">
            <div id="header-beadcrumbs-admin" class="fl">
                Administration
            </div>
            <div id="header-user-admin" class="txtright fr">
                {{ Auth::user()->username }}
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div>
        <h1 id="content-h1-admin" class="txtcenter">Bienvenue sur l'interface d'administration de Série-All.</h1>
        <p class="txtcenter">Veuillez choisir une section dans la partie de gauche.</p>



        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vehicula, mi vitae dapibus blandit, magna nisl dictum ante, et tempus enim leo ut lorem. Pellentesque consequat, arcu vitae suscipit ultricies, orci justo mollis risus, at consectetur neque ante eget ipsum. Curabitur ac elit in dolor lacinia hendrerit hendrerit non lacus. Donec vitae suscipit velit. In dapibus laoreet pulvinar. Pellentesque id sagittis magna. Nunc tristique velit ac tristique interdum. Donec venenatis ultricies mi eget sodales. Donec sollicitudin justo id nulla luctus imperdiet. Cras eu posuere neque, non mollis massa. Aenean hendrerit sem ut vestibulum sollicitudin. Donec pellentesque tempus ipsum quis mollis. <br />

        Quisque pretium magna nulla, eget consectetur ante aliquet commodo. Quisque ac tellus accumsan, vulputate turpis vel, condimentum ipsum. Nulla nunc ipsum, efficitur id nunc at, volutpat feugiat dolor. Morbi id metus tellus. Pellentesque consequat mi at nunc vestibulum hendrerit. Vivamus sit amet enim urna. Vivamus quis ornare felis, ut sollicitudin neque. Aenean congue ex a tortor pulvinar, vel eleifend enim gravida. Nam feugiat accumsan laoreet. Curabitur interdum sagittis massa, eu viverra velit dapibus fermentum. <br />

        Ut et sapien quis purus mattis molestie quis non metus. Praesent congue molestie cursus. Donec eu consequat eros, nec ultricies arcu. Pellentesque consectetur varius feugiat. Nullam elit arcu, vestibulum sit amet urna ut, pharetra fringilla tellus. Pellentesque elementum pulvinar tortor in tincidunt. Vestibulum commodo magna porttitor, ultricies mauris id, vestibulum nibh. Ut malesuada facilisis tortor ac sagittis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam at pulvinar ex. Duis aliquam, eros non elementum rhoncus, nibh tellus scelerisque ipsum, vitae tristique neque diam sed velit. Vivamus venenatis dolor ac vehicula suscipit. Nullam euismod quam nisl, id blandit metus rhoncus et. Etiam dictum ligula nisi, nec sagittis sem gravida vitae. Praesent lacinia ex at lacus pulvinar, ultricies ornare magna dictum. Nunc malesuada risus eleifend risus facilisis condimentum.<br />

        Suspendisse libero odio, bibendum in finibus eget, lobortis ultricies orci. Vivamus elementum neque est, vel lacinia nibh dapibus et. Nam fringilla rutrum ipsum. Sed vitae mollis felis. Vivamus vel massa lectus. Sed eget sem at nulla scelerisque venenatis a a turpis. Nunc a orci accumsan diam faucibus dapibus in semper eros. Praesent tempus ornare diam, nec convallis libero molestie eget. Maecenas vitae urna non orci vulputate egestas et a nulla. Nunc ullamcorper varius massa, sed posuere purus aliquet vel. Integer quis tellus a sapien vehicula elementum. Etiam a erat magna. Ut at leo turpis. In fermentum consectetur erat, vel ornare quam placerat vitae. Nam ac luctus nisi. Proin lacinia magna blandit tincidunt suscipit.<br />

        Pellentesque vitae ex consectetur, suscipit ante et, venenatis dolor. Etiam sagittis eros non semper pharetra. Pellentesque arcu magna, congue a massa at, placerat maximus orci. Sed commodo, purus ut elementum placerat, purus dolor vulputate elit, vitae elementum justo libero sed diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In malesuada mi eu odio accumsan, vel cursus leo ullamcorper. Integer venenatis nisi id ante venenatis, at semper velit rhoncus. Morbi congue risus dignissim odio venenatis scelerisque. Nullam dignissim, eros in malesuada congue, nisi enim fringilla turpis, non viverra nulla quam quis nisi. Ut volutpat ipsum in turpis euismod rutrum. <br />
    </div>
@endsection