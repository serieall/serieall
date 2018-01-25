<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('pageTitle') - Série-All Bêta</title>
<meta name="description" content="@yield('pageDescription')" />

<link rel="icon" href="{{ $folderImages }}logo_v2.ico">

<!-- CSS -->
{{ Html::style('https://cdn.jsdelivr.net/npm/semantic-ui@2.2.13/dist/semantic.min.css') }}
{{ Html::style('https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css') }}
{{ Html::style('//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css') }}
{{ Html::style('/css/style.css') }}
{{ Html::style('/css/semantic_perso.css') }}
{{ Html::style('/css/slider/style.css') }}
{{ Html::style('/spoiler/spoiler.css') }}
{!! Charts::styles() !!}

<!-- Piwik -->
<script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//analytics.journeytotheit.ovh/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>
<noscript><p><img src="//analytics.journeytotheit.ovh/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->