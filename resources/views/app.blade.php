<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Qemt Najd</title>
    <link rel="preload" as="image" href="/images/home_hero.webp" fetchpriority="high" />
    @if (file_exists(public_path('hot')))
        @viteReactRefresh
        @vite('resources/react/main.tsx')
    @elseif (file_exists(public_path('build/manifest.json')))
        @vite('resources/react/main.tsx')
    @elseif (file_exists(public_path('index.html')))
        @php
            $indexHtml = file_get_contents(public_path('index.html'));
            preg_match_all('/<link[^>]+rel="(?:stylesheet|modulepreload)"[^>]*>/i', $indexHtml, $cssMatches);
            preg_match('/<script[^>]+src="\/assets\/store\/[^"]+"[^>]*><\/script>/i', $indexHtml, $jsMatches);
        @endphp
        @if (!empty($cssMatches[0]))
            {!! implode("\n    ", $cssMatches[0]) !!}
        @endif
        @if (!empty($jsMatches[0]))
            {!! $jsMatches[0] !!}
        @endif
    @endif
</head>
<body>
    <div id="root"></div>
    <script src="https://cdn.jsdelivr.net/npm/lazysizes@5.3.2/lazysizes.min.js" async></script>
</body>
</html>
