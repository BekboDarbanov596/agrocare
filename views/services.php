<?php
/**
 * Services View - Ultra-premium Editorial Catalog
 * Theme: Ivory, Sage, and Midnight
 */
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@400;700;900&display=swap');

    :root {
        --h-accent: #b4a18a;
        --h-accent-sage: #849483;
        --h-bg: #050505;
        --glass-bg: rgba(255, 255, 255, 0.015);
        --glass-border: rgba(255, 255, 255, 0.05);
    }

    body {
        background-color: var(--h-bg);
        overflow-x: hidden;
        font-family: 'Inter', sans-serif;
    }

    /* Cinematic Aura Background */
    .aura-container {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        overflow: hidden;
    }

    .aura-blob {
        position: absolute;
        width: 80vw;
        height: 80vw;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.15;
        mix-blend-mode: screen;
        will-change: transform;
    }

    .aura-1 {
        background: radial-gradient(circle, var(--h-accent) 0%, transparent 70%);
        top: -20%;
        left: -20%;
    }

    .aura-2 {
        background: radial-gradient(circle, var(--h-accent-sage) 0%, transparent 70%);
        bottom: -20%;
        right: -20%;
    }

    .services-wrapper {
        position: relative;
        z-index: 10;
        padding-top: 60px;
    }

    /* Editorial Hero */
    .editorial-hero {
        min-height: 85vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0 8%;
        position: relative;
    }

    .eyebrow {
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.6em;
        text-transform: uppercase;
        color: var(--h-accent);
        margin-bottom: 32px;
        opacity: 0.8;
    }

    .editorial-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(54px, 10vw, 160px);
        line-height: 0.9;
        font-weight: 400;
        color: #fff;
        font-style: italic;
        margin-bottom: 60px;
        letter-spacing: -0.04em;
    }

    .editorial-title span {
        display: block;
        font-style: normal;
        font-weight: 900;
        color: var(--h-accent);
        background: linear-gradient(to right, var(--h-accent), #fff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 48px;
        margin-top: 40px;
    }

    .hero-meta {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.5);
        max-width: 440px;
        line-height: 1.7;
        font-weight: 400;
    }

    .scroll-indicator {
        font-size: 10px;
        opacity: 0.4;
        letter-spacing: 0.3em;
        text-transform: uppercase;
        font-weight: 700;
    }

    /* Grid Section */
    .catalog-section {
        padding: 100px 8% 150px;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 60px;
    }

    .editorial-card {
        text-decoration: none;
        position: relative;
        background: rgba(255, 255, 255, 0.01);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 2px;
        padding: 80px;
        min-height: 650px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: border-color 0.6s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.6s ease;
        contain: paint;
    }

    .editorial-card:hover {
        border-color: rgba(180, 161, 138, 0.3);
        background: rgba(255, 255, 255, 0.02);
    }

    .card-highlight {
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(180, 161, 138, 0.1) 0%, transparent 70%);
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.6s ease;
        z-index: 1;
        transform: translate(-50%, -50%);
    }

    .editorial-card:hover .card-highlight {
        opacity: 1;
    }

    .card-number {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-style: italic;
        color: var(--h-accent);
        margin-bottom: 80px;
        font-weight: 300;
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 56px;
        line-height: 1.05;
        color: #fff;
        margin-bottom: 32px;
        letter-spacing: -0.02em;
        font-weight: 400;
    }

    .card-desc {
        font-size: 17px;
        color: rgba(255, 255, 255, 0.4);
        line-height: 1.8;
        max-width: 360px;
        margin-bottom: auto;
    }

    .card-action {
        margin-top: 80px;
        display: flex;
        align-items: center;
        gap: 20px;
        color: #fff;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        transition: color 0.4s ease;
    }

    .card-action span {
        width: 30px;
        height: 1px;
        background: var(--h-accent);
        transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .editorial-card:hover .card-action span {
        width: 70px;
        background: #fff;
    }

    .card-visual {
        position: absolute;
        top: 80px;
        right: 80px;
        width: 140px;
        height: 140px;
        opacity: 0.15;
        transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .editorial-card:hover .card-visual {
        opacity: 0.5;
        transform: scale(1.15) rotate(10deg);
    }

    /* Tooltip/Cursor */
    .cursor-dot {
        width: 8px;
        height: 8px;
        background: var(--h-accent);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 10000;
        transform: translate(-50%, -50%);
        mix-blend-mode: difference;
    }

    @media (max-width: 1200px) {
        .editorial-card {
            padding: 60px;
            min-height: 550px;
        }

        .card-title {
            font-size: 44px;
        }
    }

    @media (max-width: 1024px) {
        .catalog-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .editorial-hero {
            padding: 0 6%;
            min-height: 70vh;
        }

        .catalog-section {
            padding: 80px 6% 100px;
        }

        .editorial-title {
            font-size: 80px;
        }
    }

    @media (max-width: 768px) {
        .editorial-title {
            font-size: 56px;
        }

        .hero-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 32px;
        }

        .editorial-card {
            padding: 48px 32px;
            min-height: auto;
        }

        .card-title {
            font-size: 38px;
        }

        .card-visual {
            width: 80px;
            height: 80px;
            top: 48px;
            right: 32px;
        }

        .card-number {
            margin-bottom: 60px;
        }

        .card-action {
            margin-top: 60px;
        }
    }
</style>

<div class="aura-container">
    <div class="aura-blob aura-1" id="aura1"></div>
    <div class="aura-blob aura-2" id="aura2"></div>
</div>

<div class="cursor-dot" id="cursor"></div>

<div class="services-wrapper">
    <section class="editorial-hero">
        <div class="eyebrow" data-gsap="eyebrow">Цифровой интеллект AgroCare</div>
        <h1 class="editorial-title" data-gsap="title">
            Исключительные <span>Технологии</span>
        </h1>

        <div class="hero-footer" data-gsap="footer">
            <div class="hero-meta">
                Мы объединяем экспериментальный искусственный интеллект с глубокой агрономической экспертизой для
                создания устойчивого будущего. Точность за гранью воображения.
            </div>
            <div class="scroll-indicator">
                Листайте, чтобы исследовать / v2026
            </div>
        </div>
    </section>

    <section class="catalog-section">
        <div class="catalog-grid">
            <!-- Card 01 -->
            <a href="#" class="editorial-card" data-gsap="card">
                <div class="card-highlight"></div>
                <div class="card-number">01</div>
                <div class="card-visual">
                    <svg viewBox="0 0 100 100" fill="none" stroke="var(--h-accent)" stroke-width="0.8">
                        <circle cx="50" cy="50" r="40" stroke-dasharray="4,4" />
                        <path d="M50 15 L50 85 M15 50 L85 50" opacity="0.4" />
                        <rect x="30" y="30" width="40" height="40" transform="rotate(45 50 50)" />
                    </svg>
                </div>
                <h2 class="card-title">Нейронное<br>Зондирование Полей</h2>
                <p class="card-desc">Глубокий анализ морфологии почвы с использованием субтермальных датчиков и систем
                    слияния спутниковых данных.</p>
                <div class="card-action">
                    Исследовать технологию <span></span>
                </div>
            </a>

            <!-- Card 02 -->
            <a href="#" class="editorial-card" data-gsap="card">
                <div class="card-highlight"></div>
                <div class="card-number">02</div>
                <div class="card-visual">
                    <svg viewBox="0 0 100 100" fill="none" stroke="var(--h-accent-sage)" stroke-width="0.8">
                        <path d="M25 50 Q 50 15 75 50 T 25 50" />
                        <circle cx="50" cy="50" r="12" fill="var(--h-accent-sage)" opacity="0.15" />
                        <line x1="10" y1="50" x2="90" y2="50" stroke-dasharray="6,6" />
                    </svg>
                </div>
                <h2 class="card-title">Биометрический<br>Синтез</h2>
                <p class="card-desc">Телеметрия здоровья животных в реальном времени, позволяющая предсказывать
                    метаболические сдвиги до их внешнего проявления.</p>
                <div class="card-action">
                    Исследовать технологию <span></span>
                </div>
            </a>

            <!-- Card 03 -->
            <a href="#" class="editorial-card" data-gsap="card">
                <div class="card-highlight"></div>
                <div class="card-number">03</div>
                <div class="card-visual">
                    <svg viewBox="0 0 100 100" fill="none" stroke="var(--h-accent)" stroke-width="0.8">
                        <rect x="25" y="25" width="50" height="50" stroke-dasharray="2,4" />
                        <path d="M25 25 L75 75 M75 25 L25 75" />
                        <circle cx="50" cy="50" r="2" fill="var(--h-accent)" />
                    </svg>
                </div>
                <h2 class="card-title">Предиктивная<br>Логика Урожая</h2>
                <p class="card-desc">Циклы сбора урожая, оптимизированные глобальными моделями ИИ на основе анализа
                    мировых цепочек поставок.</p>
                <div class="card-action">
                    Исследовать технологию <span></span>
                </div>
            </a>

            <!-- Card 04 -->
            <a href="#" class="editorial-card" data-gsap="card">
                <div class="card-highlight"></div>
                <div class="card-number">04</div>
                <div class="card-visual">
                    <svg viewBox="0 0 100 100" fill="none" stroke="var(--h-accent-sage)" stroke-width="0.8">
                        <path d="M15 85 L35 15 L55 85 L75 15 L95 85" />
                        <line x1="15" y1="85" x2="95" y2="85" opacity="0.3" />
                    </svg>
                </div>
                <h2 class="card-title">Автономный<br>Контроль Потоков</h2>
                <p class="card-desc">Саморегулируемые сети ирригации и распределения ресурсов с нулевыми
                    эксплуатационными затратами человека.</p>
                <div class="card-action">
                    Исследовать технологию <span></span>
                </div>
            </a>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cursor = document.getElementById('cursor');

        // Custom Cursor
        window.addEventListener('mousemove', (e) => {
            gsap.to(cursor, {
                x: e.clientX,
                y: e.clientY,
                duration: 0.1,
                ease: "power2.out"
            });
        });

        // Entrance Animations
        const tl = gsap.timeline({ defaults: { ease: "expo.out", duration: 2 } });

        tl.from('[data-gsap="eyebrow"]', { y: 40, opacity: 0, duration: 1.5 })
            .from('[data-gsap="title"]', { y: 80, opacity: 0, skewY: 5 }, "-=1.2")
            .from('[data-gsap="footer"]', { opacity: 0, y: 20 }, "-=1.4");

        // Card Reveals
        document.querySelectorAll('[data-gsap="card"]').forEach((card, i) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: "top 90%",
                },
                y: 100,
                opacity: 0,
                duration: 1.8,
                ease: "expo.out",
                delay: i % 2 * 0.2
            });

            // Card Magnetic Effect
            const highlight = card.querySelector('.card-highlight');
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                gsap.to(highlight, { x: x, y: y, duration: 0.6 });

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const moveX = (x - centerX) / centerX * 10;
                const moveY = (y - centerY) / centerY * -10;

                gsap.to(card, {
                    rotateX: moveY,
                    rotateY: moveX,
                    duration: 0.5,
                    ease: "power2.out"
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, { rotateX: 0, rotateY: 0, duration: 1, ease: "expo.out" });
            });
        });

        // Aura Parallax
        gsap.to('#aura1', {
            yPercent: 30,
            scrollTrigger: { scrub: true }
        });
        gsap.to('#aura2', {
            yPercent: -30,
            scrollTrigger: { scrub: true }
        });
    });
</script>