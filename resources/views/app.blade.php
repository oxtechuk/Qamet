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
        @endphp
        @if (!empty($cssMatches[0]))
            {!! implode("\n    ", $cssMatches[0]) !!}
        @endif
        @if (!empty($jsMatches[0]))
            {!! implode("\n    ", $jsMatches[0]) !!}
        @endif
    @endif
</head>
<body>
    <div id="root"></div>
    <script src="https://cdn.jsdelivr.net/npm/lazysizes@5.3.2/lazysizes.min.js" async></script>
</body>
</html>
