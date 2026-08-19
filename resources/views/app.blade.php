<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon-white.svg') }}" media="(prefers-color-scheme: dark)" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Qemt Najd</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">

    @php
        $gtmId = config('services.gtm.id');
        $metaPixelId = config('services.meta.pixel_id');
        $tiktokPixelId = config('services.tiktok.pixel_id');
        $snapchatPixelId = config('services.snapchat.pixel_id');
    @endphp

    @if ($gtmId)
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    <!-- End Google Tag Manager -->
    @endif

    @if ($metaPixelId)
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $metaPixelId }}');
    fbq('track', 'PageView');
    </script>
    <!-- End Meta Pixel Code -->
    @endif

    @if ($tiktokPixelId)
    <!-- TikTok Pixel Code Start -->
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
    var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
    ;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};

      ttq.load('{{ $tiktokPixelId }}');
      ttq.page();
    }(window, document, 'ttq');
    </script>
    <!-- TikTok Pixel Code End -->
    @endif

    @if ($snapchatPixelId)
    <!-- Snap Pixel Code -->
    <script type='text/javascript'>
    (function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()
    {a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};
    a.queue=[];var s='script';r=t.createElement(s);r.async=!0;
    r.src=n;var u=t.getElementsByTagName(s)[0];
    u.parentNode.insertBefore(r,u);})(window,document,
    'https://sc-static.net/scevent.min.js');

    snaptr('init', '{{ $snapchatPixelId }}', {
    'user_email': ''
    });

    snaptr('track', 'PAGE_VIEW');
    </script>
    <!-- End Snap Pixel Code -->
    @endif

    @if (file_exists(public_path('hot')))
        @viteReactRefresh
        @vite('resources/react/main.tsx')
    @elseif (file_exists(public_path('build/manifest.json')))
        @vite('resources/react/main.tsx')
    @elseif (file_exists(public_path('index.html')))
        @php
            $indexHtml = file_get_contents(public_path('index.html'));
            preg_match_all('/<link[^>]+rel="(?:stylesheet|modulepreload)"[^>]*>/i', $indexHtml, $cssMatches);
            preg_match_all('/<script[^>]+type="module"[^>]*><\/script>/i', $indexHtml, $jsMatches);

            $transformAsset = function(string $tag): string {
                return preg_replace_callback('/(href|src)="([^"]+)"/i', function(array $m): string {
                    $attr = $m[1];
                    $val = $m[2];
                    if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://') || str_starts_with($val, '//')) {
                        return $m[0];
                    }
                    $cleaned = ltrim(preg_replace('#^/+(?:qamet/public/)?#i', '', $val), '/');
                    return $attr . '="' . asset($cleaned) . '"';
                }, $tag);
            };

            $renderedCss = array_map($transformAsset, $cssMatches[0] ?? []);
            $renderedJs = array_map($transformAsset, $jsMatches[0] ?? []);
        @endphp
        @if (!empty($renderedCss))
            {!! implode("\n    ", $renderedCss) !!}
        @endif
        @if (!empty($renderedJs))
            {!! implode("\n    ", $renderedJs) !!}
        @endif
    @endif
</head>
<body>
    @if ($gtmId)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    @if ($metaPixelId)
    <!-- Meta Pixel (noscript) -->
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $metaPixelId }}&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel (noscript) -->
    @endif

        <div id="root"></div>
    </body>
</html>
