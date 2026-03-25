<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= isset($title) ? htmlspecialchars($title) : 'AI Agro Care' ?></title>
    <meta name="theme-color" content="#0a0a0a">

    <!-- Primary PWA Meta -->
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="AgroCare">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">

    <!-- Splash Screens (Standardized boilerplate) -->
    <link rel="apple-touch-startup-image" href="/icons/icon-512x512.png">
    <!-- Fonts: Inter & Playfair Display for Editorial feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Space+Grotesk:wght@300..700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="/css/design-system.css?v=1.6">
    <link rel="stylesheet" href="/css/style.css?v=1.6">
    <link rel="stylesheet" href="/css/responsive.css?v=1.0">

    <style>
        /* Safe Area Handling for Premium PWA feel */
        :root {
            --safe-top: env(safe-area-inset-top);
            --safe-bottom: env(safe-area-inset-bottom);
        }
        body {
            padding-top: var(--safe-top);
            padding-bottom: var(--safe-bottom);
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            user-select: none;
        }
        .app-container {
            min-height: calc(100vh - var(--safe-top) - var(--safe-bottom));
        }
    </style>

    <!-- Animation Libs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
</head>

<body>
    <!-- Декоративный фон -->
    <canvas id="bgCanvas"
        style="position:fixed;top:0;left:0;width:100%;height:100%;z-index:0;pointer-events:none;"></canvas>

    <div class="app-container" style="position:relative;z-index:1;">
        {{content}}
    </div>

    <!-- SVG иконки -->
    <?php include __DIR__ . '/../../icons/icons.svg'; ?>

    <script src="/js/icons.js"></script>


    <script>
        // Декоративные звёзды/частицы на фоне
        (function () {
            const canvas = document.getElementById('bgCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            const stars = Array.from({ length: 35 }, () => ({
                x: Math.random(),
                y: Math.random(),
                r: Math.random() * 1.2 + 0.3,
                a: Math.random() * 0.5 + 0.2,
                speed: Math.random() * 0.0004 + 0.0001,
                phase: Math.random() * Math.PI * 2
            }));

            let rafId;
            function draw(t) {
                if (document.hidden) {
                    rafId = requestAnimationFrame(draw);
                    return;
                }
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                stars.forEach(s => {
                    const alpha = s.a * (0.6 + 0.4 * Math.sin(t * s.speed * 1000 + s.phase));
                    ctx.beginPath();
                    ctx.arc(s.x * canvas.width, s.y * canvas.height, s.r, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(200, 210, 255, ${alpha})`;
                    ctx.fill();
                });
                rafId = requestAnimationFrame(draw);
            }
            rafId = requestAnimationFrame(draw);
            document.addEventListener('visibilitychange', () => {
                if (document.hidden && rafId) {
                    cancelAnimationFrame(rafId);
                    rafId = 0;
                } else if (!document.hidden && !rafId) {
                    rafId = requestAnimationFrame(draw);
                }
            });
        })();

        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('SW Registered', reg))
                    .catch(err => console.error('SW Registration Failed', err));
            });
        }
    </script>
</body>

</html>