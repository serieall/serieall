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
{{ Html::style('/semantic/semantic_perso.css') }}
{{ Html::style('/css/font-awesome.css') }}

<!-- Javascript -->
    {{ Html::script('/js/jquery.js') }}
    {{ Html::script('/js/datatables.js') }}
    {{ Html::script('/semantic/semantic.js') }}

</head>
<body>


<div class="ui left fixed vertical menu">
    <div class="item">
        <img class="ui mini image" src="/images/logo.png">
    </div>
    <a class="item">Features</a>
    <a class="item">Testimonials</a>
    <a class="item">Sign-in</a>
</div>

@yield('content')



</body>
</html>