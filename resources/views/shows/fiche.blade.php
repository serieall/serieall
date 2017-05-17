@extends('layouts.app')

@section('content')

    <div id="topImageShow"  class="row nobox">
        <div class="column">
            <img src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Bannière {{ $show->name }}" />
        </div>
    </div>

    <div id="menuFiche" class="row">
        <div class="column">
            <div class="ui fluid six item stackable menu">
                <a class="active item">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="item">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="item">
                    <i class="big list icon"></i>
                    Informations détaillées
                </a>
                <a class="item">
                    <i class="big comments icon"></i>
                    Avis
                </a>
                <a class="item">
                    <i class="big write icon"></i>
                    Articles
                </a>
                <a class="item">
                    <i class="big line chart icon"></i>
                    Statistiques
                </a>
            </div>
        </div>
    </div>

    <div class="row ui stackable grid">
        <div class="ten wide column">
            <div class="ui stackable grid">
                <div class="row">
                    <div class="ui segment">
                        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aperiam architecto
                            blanditiis consequatur cum dignissimos dolorem ea esse in magni nesciunt possimus, quibusdam
                            quis quos repellendus sit sunt. At, quos!
                        </div>
                        <div>Commodi, libero nihil. Ab blanditiis debitis ducimus maxime omnis placeat temporibus?
                            Aspernatur corporis, cumque deserunt dolor dolorum error exercitationem fugiat ipsam labore
                            libero quaerat totam, veritatis voluptatum. A accusamus, soluta!
                        </div>
                        <div>Animi, cum earum error fugiat natus possimus praesentium tempora voluptatibus. Accusantium
                            animi architecto at commodi dolorem id ipsa iusto magni nisi officiis, pariatur perferendis
                            sapiente sed sequi ut, vel, voluptate.
                        </div>
                        <div>Dignissimos eaque iste modi pariatur tempora ullam, vel. Accusamus aperiam architecto eaque
                            eveniet itaque laudantium nisi nulla officia pariatur quibusdam, quisquam repellendus
                            similique unde veniam voluptatibus. Deleniti dicta dolor iusto.
                        </div>
                        <div>Accusamus aliquid aut deleniti dolores, explicabo facere hic id illum laboriosam maxime
                            minus nobis, numquam quae quidem quisquam repellendus ut voluptatem! Ducimus eveniet facere
                            fugit ipsam. Ea sed soluta tempora.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">
                        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aspernatur, cumque id
                            modi officia quae repudiandae temporibus vitae. Consequuntur facilis in mollitia nulla
                            officiis pariatur quis sunt ullam, unde voluptates.
                        </div>
                        <div>Accusamus accusantium animi aperiam consequatur dignissimos dolore dolorem dolores, dolorum
                            ea eligendi enim harum ipsam maiores molestiae non odit placeat quasi quibusdam tempora
                            voluptate. Aliquam aspernatur dolorem eligendi qui quisquam.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="four wide column">
            <div class="ui stackable grid">
                <div class="row">
                    <div class="ui segment">
                        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid cumque doloribus ea error
                            excepturi exercitationem expedita explicabo iusto libero mollitia nulla obcaecati, officiis
                            pariatur quas ratione similique suscipit unde voluptatum!
                        </div>
                        <div>Architecto assumenda, atque deleniti dolores ea eius enim eos ex ipsum iure laudantium
                            molestiae mollitia nulla officia pariatur perspiciatis porro praesentium provident quam qui
                            repellendus, repudiandae sit soluta ut vel?
                        </div>
                        <div>A accusamus adipisci atque beatae cum, dolor facere laboriosam laborum non nulla porro quod
                            repellat soluta sunt tempore vel voluptas voluptate. Aperiam eum harum nesciunt obcaecati
                            quibusdam sint unde vitae.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
