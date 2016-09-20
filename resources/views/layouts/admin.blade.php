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
<body>
    <div class="ui top attached menu">
        <a class="item">
            <i class="fa fa-bars"></i>
        </a>
    </div>


    <div class="ui bottom attached segment pushable">
        <div class="ui visible inverted left vertical sidebar menu">
            <a class="item">
                <i class="home icon"></i>
                Home
            </a>
            <a class="item">
                <i class="block layout icon"></i>
                Topics
            </a>
            <a class="item">
                <i class="smile icon"></i>
                Friends
            </a>
            <a class="item">
                <i class="calendar icon"></i>
                History
            </a>
        </div>

        <div class="pusher">
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

        $('.fa-bars')
                .sidebar({
                    context: $('.bottom.segment')
                })
                .sidebar('hide')
        ;
    </script>

</body>
</html>