<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Cairo', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .bg-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 0;
        }
        .bg-image {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; z-index: -1;
        }
        .content {
            position: relative; z-index: 1;
            max-width: 600px; padding: 40px 24px;
        }
        .icon {
            font-size: 64px; margin-bottom: 24px;
            opacity: 0.9;
        }
        h1 {
            font-size: 36px; font-weight: 800;
            margin-bottom: 16px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        p {
            font-size: 18px; line-height: 1.7;
            opacity: 0.9;
            text-shadow: 0 1px 4px rgba(0,0,0,0.3);
        }
        .divider {
            width: 60px; height: 3px; margin: 24px auto;
            background: rgba(255,255,255,0.5); border-radius: 2px;
        }
    </style>
</head>
<body>
    @if(!empty($image))
    <img src="{{ asset('storage/' . $image) }}" alt="" class="bg-image">
    @else
    <div style="position:fixed;top:0;left:0;width:100%;height:100%;background:linear-gradient(135deg,#0f172a 0%,#1e293b 50%,#334155 100%);z-index:-1;"></div>
    @endif
    <div class="bg-overlay"></div>

    <div class="content">
        <div class="icon">
            <i class="bi bi-tools"></i>
        </div>
        <h1>{{ $title }}</h1>
        <div class="divider"></div>
        <p>{{ $message }}</p>
    </div>
</body>
</html>
