<!DOCTYPE html>
<html lang="en" id="html-admin">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SérieAll BETA</title>
    <link rel="icon" href="images/logo_v2.ico">

    <!-- CSS -->
    {{ Html::style('/semantic/semantic.css') }}
    {{ Html::style('/css/font-awesome.css') }}

    <!-- Javascript -->
    {{ Html::script('/js/jquery.js') }}
    {{ Html::script('/js/datatables.js') }}
    {{ Html::script('/semantic/semantic.js') }}

</head>
<body id="body-admin">
    <div class="ui top attached demo menu">
        <a class="item">
            <i class="fa fa-bars"></i>
        </a>
    </div>
    <div class="ui bottom attached segment pushable">
        <div style="" class="ui inverted labeled icon left inline vertical sidebar menu uncover visible">
            <a class="item">
                Home
            </a>
            <a class="item">
                Topics
            </a>
            <a class="item">
                Friends
            </a>
            <a class="item">
                History
            </a>
        </div>
        <div class="pusher dimmed">
            <div class="ui basic segment">
                <article id="article-admin" class="fr w85 pam">
                    @yield('content')
                </article>
            </div>
        </div>
    </div>

    <script>
        @yield('scripts')

        $('.dropdown')
                .dropdown()
        ;

        $('.ui.sidebar')
                .sidebar({
                    context: $('.bottom.segment')
                })
                .sidebar('attach events', '.menu .item')
        ;
    </script>

</body>
</html>