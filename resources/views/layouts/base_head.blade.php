<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('pageTitle') - Série-All</title>
<meta name="description" content="@yield('pageDescription')" />

@yield('og')

<link rel="icon" href="{{ $folderImages }}logo_v2.ico">

<!-- CSS -->
{{ Html::style('https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css') }}
{{ Html::style('/css/libs/jquery-ui.css') }}
{{ Html::style('/css/libs/jquery.dataTables.min.css') }}

@stack('style')
<link rel="stylesheet" type="text/css" href="/slick/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="/slick/slick/slick-theme.css"/>

{{ Html::style('/css/fontawesome-free-5.8.2-web/css/all.min.css') }}
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
