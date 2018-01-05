@extends('layouts.app')

@section('pageTitle', 'Contact')
@section('pageDescription', 'Les membres de l\'équipe de Série-All qui vous chouchoute au quotidien.')

@section('content')
    <div class="ten wide column">
        <div class="ui segment article">
            <h1>L'équipe Série-All</h1>

            Composée de personnes d'horizons plus ou moins variés, l'équipe de Série-All s'est donnée pour mission de vous offrir le contenu seriel le plus pertinent du web. Oui, rien que ça.
            Dans la mesure du possible, on essaye de rester objectif mais bon, il faut bien avouer que face à Joséphine Ange Gardien, c'est difficile (mais on fait des efforts).
            <br />
            <br />

            <h2>Les chefs</h2>
            <?php
                $chefs = array(
                    array(
                        'Username' => 'Galax',
                        'Email' => 'rikki-tikki@hotmail.fr',
                        'Role' => 'Rédacteur en chef',
                        'Quote' => "Vous aimez <strong>Doctor Who</strong> ? Ne le dites pas à Galax, sinon il va vous en parler pendant des heures. Remarquez, quoi que vous fassiez, il va vous en parler pendant des heures."
                    ),
                    array(
                        'Username' => 'Youkoulayley',
                        'Email' => 'bmayelle@hotmail.fr',
                        'Role' => 'Super Chef',
                        'Quote' => "Entre deux épisodes des <strong>Sopranos</strong>, il travaille avec amour, disponibilité et d'arrache pied à créer la légendaire Version 2 du site. Inutile de préciser que lui, il a un accès illimité à la boîte de Pépitos !"
                    )
                );
            ?>

            <p>
                Omniscients et omnipotents, ils dirigent d’une main de fer le site : développement, rédaction, modération, rien ne leur échappe. Ils sont
                toutefois accessibles et bienveillants et acceptent aussi bien les règlements par chèque que les espèces.
            </p>
            <br />

            <div class="ui grid">
                @foreach($chefs as $user)
                    @include('pages.user_and_quotes')
                @endforeach
            </div>

            <h2>La rédaction</h2>
            <?php
                $redac = array(
                    array(
                        'Username' => 'Altaïr',
                        'Email' => 'aurelie_bm@yahoo.fr',
                        'Role' => 'Rédactrice',
                        'Quote' => "Avec sa collègue Puck, elle se bat chaque jour pour que Série-All devienne une terre d'égalité entre hommes et femmes. Mais comme on dit : \"on en reparlera quand il faudra porter des choses lourdes\" (non, pas taper, désolé)."
                    ),
                    array(
                        'Username' => 'Antofisherb',
                        'Email' => 'antoninbonneau@hotmail.fr',
                        'Role' => 'Rédacteur',
                        'Quote' => "Il aime des mauvaises séries, mais il en regarde tellement que personne ne le voit. Il est également notre reporter de l'extrême, capable de prouesses de ninja pour nous récupérer un scoop !"
                    ),
                    array(
                        'Username' => 'Blip',
                        'Email' => 'filinn.blip@gmail.com',
                        'Role' => 'Relecteur',
                        'Quote' => "Personnage mystérieux, chasseur de fautes d'orthographe, son amour pour les <strong>Shadoks</strong> n'a d'égale que sa passion pour les E dans l'O."
                    ),
                    array(
                        'Username' => 'Cail1',
                        'Email' => 'cail1@hotmail.fr',
                        'Role' => 'Chinois et Rédacteur',
                        'Quote' => "Le sang et les luttes acharnées, c'est sa passion. C'est donc sans surprise qu'il critique <strong>The Walking Dead</strong> et se bat avec le site pour ajouter des séries dans la base de données. On ne sait toujours pas ce qui est le pire."
                    ),
                    array(
                        'Username' => 'CaptainFreeFrag',
                        'Email' => 'rob.zen@hotmail.fr',
                        'Role' => 'Rédacteur',
                        'Quote' => "Sur le forum, il est de toutes les discussions. Tant et si bien qu'on a eu l'impression qu'il était un rédacteur prolifique. En fait, il n'a critiqué que <strong>The Playboy Club</strong> et <strong>Boss</strong>."
                    ),
                    array(
                        'Username' => 'Gizmo',
                        'Email' => 'josselint@hotmail.fr',
                        'Role' => 'Rédacteur',
                        'Quote' => "Il est la touche vintage du site : <strong>Hercule Poirot</strong> et <strong>Arabesque</strong> n'ont aucun secret pour lui. Ajoutez à ça sa passion déraisonnée pour Laurent Ruquier, et il devient instantanément le meilleur ami de votre grand-mère !"
                    ),
                    array(
                        'Username' => 'Jojo76',
                        'Email' => 'jojoenforce@hotmail.fr',
                        'Role' => 'Gestionnaire de la base',
                        'Quote' => "Sa capacité à troller est devenue légendaire sur les internets. Chez nous, il se charge en plus de mettre à jour la base de données et les images de séries avec Cail1."
                    ),
                    array(
                        'Username' => 'Koss',
                        'Email' => 'costheboss_007@hotmail.com',
                        'Role' => 'Rédacteur',
                        'Quote' => "Koss a deux passions dans la vie : écrire des trucs sur le web et troller. Surtout troller en fait. Mais personne n'est dupe : on sait bien qu'il aime <strong>Breaking Bad</strong>."
                    ),
                    array(
                        'Username' => 'MarieLouise',
                        'Email' => 'opheliepouyette@hotmail.com',
                        'Role' => 'Relectrice',
                        'Quote' => "Relectrice dé article, L traque lé fOtes d'ortograf ke peuve fèr lé rédacteur. L ésite pas a lé... ouille... frappé ...aïe... avec son foué ... ouille - j'arrête ... en cuir s'ils ne rendent pas une copie impecabl... aïe..."
                    ),
                    array(
                        'Username' => 'Nicknackpadiwak',
                        'Email' => 'cedricbutstraen@aol.com',
                        'Role' => 'Rédacteur',
                        'Quote' => "Critique de l'extrême, il est aussi l'inventeur du <em>Vrickavrack</em>. Et non, nous non plus nous n'arrivons toujours pas à prononcer son nom."
                    ),
                    array(
                        'Username' => 'Puck',
                        'Email' => 'absinthe5@free.fr',
                        'Role' => 'Rédactrice',
                        'Quote' => "Chevalier de l'ordre du Larousse et gardienne du Petit Robert, elle traquait sans relâche les fautes d'ortographe et de grammaire. Aujourd'hui, elle critique quelques séries, pour peu que John Simm soit au casting."
                    ),
                    array(
                        'Username' => 'RasAlGhul',
                        'Email' => 'n.kaspar@wanadoo.fr',
                        'Role' => 'Rédacteur',
                        'Quote' => "Passionné de séries de super-héros, le nombre considérable d'articles qu'il écrit nous fait supposer deux choses : soit il exploite des enfants chinois dans son grenier, soit il porte lui-même un masque et des collants."
                    ),
                    array(
                        'Username' => 'Tan',
                        'Email' => 'morlak_ncr@hotmail.com',
                        'Role' => 'Rédacteur',
                        'Quote' => "Son rêve absolu est de se transformer en Pinkie Pie, l'un des poneys de <strong>My Little Pony : Friendship is Magic</strong>. En dehors de ça, c'est un garçon plutôt normal."
                    ),
                );
            ?>

            <p>
                Ils distillent avec intelligence et savoir-faire leur analyse des séries et des actualités : plus leur critique est pertinente et plus leur rémunération en Pépitos est importante. Autant dire qu’ils font plutôt du bon travail !
            </p>
            <br />

            <div class="ui grid">
                @foreach($redac as $user)
                    @include('pages.user_and_quotes')
                @endforeach
            </div>

            <h2>Les anciens</h2>
            <?php
            $anciens = array(
                array(
                    'Username' => 'Scarch',
                    'Email' => 'jango@aliceadsl.fr',
                    'Role' => 'Fondateur (à la retraite)',
                    'Quote' => "Créateur de la première version du site en 2009, il a eu l’honneur de critiquer <strong>Breaking Bad</strong>. Incapable se remettre de la fin de série, il a décidé de s'exiler dans un monastère au Tibet pour retrouver un semblant de spiritualité."
                ),
                array(
                    'Username' => 'Cad',
                    'Email' => 'cadeuh@gmail.com',
                    'Role' => 'Webmaster à la retraite',
                    'Quote' => "Capable de pirater les serveurs du FBI avec une Gameboy, il a créé le site actuel avant d'en devenir le responsable officiel. Depuis, il a délégué tout le boulot et passe la journée assis dans son fauteuil en cuir, à regarder son empire."
                ),
                array(
                    'Username' => 'Elpiolito',
                    'Email' => 'jojo.jumper@hotmail.fr',
                    'Role' => 'Webmaster à la retraite',
                    'Quote' => "Le saviez-vous ? Jadis, une marmotte était aux commandes du site. Et une marmotte susceptible en plus, surtout quand on critiquait le brushing de <strong>MacGyver</strong>. Mais personne n'était dupe : sous ses airs de vieux ronchon se cachait en fait un c&oelig;ur en guimauve..."
                ),
                array(
                    'Username' => 'Alanparish',
                    'Email' => 'alanparish45@hotmail.com',
                    'Role' => 'Rédacteur',
                    'Quote' => "Il était le recordman du nombre de critiques publiées à la bourre, à deux doigts d'être homologué par le Guinness World Records. Sinon, il a aimé la fin de <strong>Lost</strong> et de <strong>How I Met Your Mother</strong> : surprenant, n'est-il pas ?"
                ),
                array(
                    'Username' => 'Aureylien',
                    'Email' => 'aurelien.biedermann33@gmail.com',
                    'Role' => 'Rédacteur',
                    'Quote' => "Critique sur les pilotes et chinois à temps partiel, il rêvait de monter un harem réunissant les actrices les plus physiquement intelligentes. Le monde l'a rattrapé depuis."
                ),
                array(
                    'Username' => 'Bleak',
                    'Email' => 'hatworld89@gmail.com',
                    'Role' => 'Shérif',
                    'Quote' => "Ancien critique et Shérif du site (on raconte qu'il avait inspiré Morris pour Lucky Luke), il a été muté dans une autre province que celle de Série-All."
                ),
                array(
                    'Username' => 'Chuck44',
                    'Email' => 'ferry.antoine@gmail.com',
                    'Role' => 'Rédacteur',
                    'Quote' => "Grand fan de <strong>Chuck</strong> et d'Yvonne Strahovski, il a critiqué avec grand enthousiasme sa série préférée. Et quand celle-ci a quitté la grille des programmes de NBC, il a décidé de partir consoler Yvonne."
                ),
                array(
                    'Username' => 'Dewey',
                    'Email' => 'thedarkpheonix@hotmail.fr',
                    'Role' => 'Rédacteur',
                    'Quote' => "Le petit frère de Malcolm avait bien grandi ! Il regardait <strong>Star Trek</strong> et <strong>Game of Thrones</strong> et n'hésitait pas à critiquer ouvertement tout ce qui n'allait pas. Parce que oui, en grandissant, Dewey avait aussi perdu sa naïveté..."
                ),
                array(
                    'Username' => 'Fafa',
                    'Email' => 'stephane.blin10@wanadoo.fr',
                    'Role' => 'Rédacteur',
                    'Quote' => "Plus gros noteur du site, il aimait achever les séries minables à coup d'avis destructeurs. On soupçonne Mimie Mathy de lui avoir tendu une embuscade, ce qui expliquerait son absence."
                ),
                array(
                    'Username' => 'Funradiz',
                    'Email' => 'ludo_ajl@hotmail.fr',
                    'Role' => 'Rédacteur',
                    'Quote' => "50% homme, 50% femme, 100% radis, le créateur de <em>Fringe, histoires parallèles</em> nous a proposé ses services de temps à autre, notamment sur <strong>Dexter</strong> et <strong>True Blood</strong>."
                ),
                array(
                    'Username' => 'Gouloudrouioul',
                    'Email' => 'glounz@hotmail.fr',
                    'Role' => 'Rédacteur',
                    'Quote' => "Son pseudo improbable nous faisait penser à un animal sauvage. On ne doit pas être les seuls puisqu'on ne le voit que très rarement depuis l'ouverture de la chasse."
                ),
                array(
                    'Username' => 'Hayiana',
                    'Email' => 'hayiana@hotmail.fr',
                    'Role' => 'Rédactrice',
                    'Quote' => "Fan des beaux gosses vampires de <strong>The Vampire Diaries</strong>, elle a finalement succombé à leur charme et est partie les rejoindre."
                ),
                array(
                    'Username' => 'Leif',
                    'Email' => '002lp@wanadoo.fr',
                    'Role' => 'Ami de Google',
                    'Quote' => "Il s'occupait de nous référencer sur Google. Mais un jour, il a rencontré Desireless et est parti la suivre en tournée."
                ),
                array(
                    'Username' => 'Louna69',
                    'Email' => 'elisabethbetty965@msn.com',
                    'Role' => 'Rédactrice',
                    'Quote' => "Critique de <strong>Gossip Girl</strong> et de <strong>The Vampire Diaries</strong>, elle n'a pas résisté à l'overdose de potins, ragots et autres réjouissances adolescentes de ces deux séries."
                ),
                array(
                    'Username' => 'Marckoleptik',
                    'Email' => 'marckoleptik@gmail.com',
                    'Role' => 'Rédacteur d\'actualités',
                    'Quote' => "Ancien chinois en chef, il gérait les ajouts de nouvelles séries au site ainsi que la rédaction des actualités. Trop de pressions auront eu raison de lui."
                ),
                array(
                    'Username' => 'MoolFreet',
                    'Email' => 'gregoiredufour@neuf.fr',
                    'Role' => 'Rédacteur',
                    'Quote' => "Notre ancien homme à tout faire : il a critiqué plusieurs séries quand il était dans la rédaction, dont <strong>Community</strong>, <strong>Castle</strong> ou encore <strong>Glee</strong>. On raconte qu'il s'est reconverti dans le football depuis."
                ),
                array(
                    'Username' => 'Nero93140',
                    'Email' => 'nero93140@live.fr',
                    'Role' => 'Rédacteur',
                    'Quote' => "Grand fan des comics <strong>The Walking Dead</strong>, il a critiqué un temps la série d'AMC. Et puis les zombies l'ont finalement rattrapé et on ne l'a plus revu..."
                ),
                array(
                    'Username' => 'Poliis0n',
                    'Email' => 'julien.agar@live.fr',
                    'Role' => 'Gestion du planning',
                    'Quote' => "Également surnommé <em>le ninja du planning</em>, son action était aussi discrète qu'efficace : le planning était à jour toutes les semaines. Et un jour, on l'a remplacé par un robot : saloperie de capitalisme."
                ),
                array(
                    'Username' => 'OSS',
                    'Email' => 'dexter.morgan.om@hotmail.fr',
                    'Role' => 'Rédacteur',
                    'Quote' => "Comme son homonyme, il aimait se beurrer la biscotte et qu'on l'enduise d'huile. Actuellement, on pense qu'il doit être de nouveau en mission secrète au proche-Orient."
                ),
                array(
                    'Username' => 'Sanschiffre',
                    'Email' => 'sanschiffre@hotmail.fr',
                    'Role' => 'Gestion des séries',
                    'Quote' => "Amateur de grand n'importe quoi, il rajoutait discrètement toutes sortes de nanars sur le site en tentant de convertir les rédacteurs à sa cause. Il possèdait aussi un &oelig;il bionique capable de détecter les faux raccords."
                ),
                array(
                    'Username' => 'Sephja',
                    'Email' => 'madameerini@gmail.com',
                    'Role' => 'Rédacteur',
                    'Quote' => "Quand il ne s'occupait pas de ses alpagas, sa passion était la découverte de nanars australiens ou du dernier thriller suédois à la mode, qu'il s'empressait de faire découvrir à tout le monde."
                ),
                array(
                    'Username' => 'Spoon',
                    'Email' => 'nicolas.tassone@gmail.com',
                    'Role' => 'Rédacteur',
                    'Quote' => "Il fut un temps où il a critiqué <strong>Sons of Anarchy</strong> et <strong>Gossip Girl</strong>, soi-disant une preuve d'ouverture d'esprit. Depuis, il s'est rendu compte de son erreur et s'est exilé dans un monastère."
                ),
                array(
                    'Username' => 'Taoby',
                    'Email' => 'taoby1@hotmail.com',
                    'Role' => 'Rédacteur',
                    'Quote' => "Son intérêt pour les critiques ayant diminué de concert avec la qualité des épisodes de <strong>Dexter</strong>, cet expert de <em>Paint</em> a préféré arrêter. Il tient néanmoins une chronique sur des actrices méconnues du circuit traditionnel, à découvrir sur le forum."
                ),
            );
            ?>

            <p>
                Il fut un temps où eux aussi participaient activement au site. Malheureusement, ayant réussi à briser leurs chaînes, ils ont fui la cave des chinois. Certains restent toutefois présents sur le forum pour soutenir leurs compagnons.
            </p>
            <br />

            <div class="ui grid">
                @foreach($anciens as $user)
                    @include('pages.user_and_quotes')
                @endforeach
            </div>

        </div>
    </div>
@endsection