<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('pageTitle') - Série-All</title>
<meta name="description" content="@yield('pageDescription')" />

@yield('og')


<link rel="icon" href="{{ $folderImages }}logo_v2.ico">

<!-- CSS -->
{{ Html::style('https://cdn.jsdelivr.net/npm/semantic-ui@2.4.1/dist/semantic.min.css') }}
{{ Html::style('https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css') }}
{{ Html::style('//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css') }}
{{ Html::style('//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css') }}
<link rel="stylesheet" type="text/css" href="/slick/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="/slick/slick/slick-theme.css"/>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
{{ Html::style('/css/style.css') }}

<!-- Matomo -->
<script type="text/javascript">
  var _paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//analytics.serieall.fr/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
