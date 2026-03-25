<div class="hero-wrap" style="padding: 0; background: #0e0c0b; min-height: 100vh;">
    <!-- Advanced Mesh System synced with Home -->
    <div class="hero-mesh-bg">
        <div class="mesh-blob blob-1"></div>
        <div class="mesh-blob blob-2"></div>
        <div class="mesh-blob blob-3"></div>
    </div>
    <div class="hero-smoke"></div>
    <div class="hero-depth-layer"></div>

    <div style="padding: 60px 24px; max-width: 1400px; margin: 0 auto; position: relative; z-index: 100;"
        class="animate-fade-in">
        <div style="margin-bottom: 64px;">
            <a href="/dashboard" class="nav-btn" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                Назад в Dashboard
            </a>
        </div>

        <style>
            :root {
                --h-bg: #0e0c0b;
                --h-accent: #b4a18a;
                --f-serif: 'Playfair Display', serif;
                --f-sans: 'Inter', sans-serif;
                --f-grotesk: 'Space Grotesk', sans-serif;
            }

            .hero-wrap {
                position: relative;
                overflow: hidden;
                color: #fff;
                font-family: var(--f-sans);
            }

            /* --- MESH SYSTEM --- */
            .hero-mesh-bg {
                position: absolute;
                inset: 0;
                z-index: 2;
                overflow: hidden;
                pointer-events: none;
            }

            .mesh-blob {
                position: absolute;
                border-radius: 50%;
                filter: blur(120px);
                opacity: 0.22;
                animation: blobFloat 40s ease-in-out infinite alternate;
                will-change: transform;
            }

            .blob-1 {
                width: 800px;
                height: 800px;
                background: radial-gradient(circle, rgba(180, 161, 138, 0.18) 0%, transparent 70%);
                top: -20%;
                left: -10%;
                animation-duration: 25s;
            }

            .blob-2 {
                width: 600px;
                height: 600px;
                background: radial-gradient(circle, rgba(134, 150, 137, 0.14) 0%, transparent 70%);
                bottom: -10%;
                right: 10%;
                animation-duration: 35s;
                animation-delay: -5s;
            }

            .blob-3 {
                width: 700px;
                height: 700px;
                background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, transparent 70%);
                top: 40%;
                right: -5%;
                animation-duration: 40s;
                animation-delay: -10s;
            }

            @keyframes blobFloat {
                0% {
                    transform: translate(0, 0) scale(1);
                }

                33% {
                    transform: translate(8%, 12%) scale(1.05);
                }

                66% {
                    transform: translate(-4%, 8%) scale(0.95);
                }

                100% {
                    transform: translate(4%, -4%) scale(1);
                }
            }

            .hero-smoke {
                position: absolute;
                inset: 0;
                background-image: url('https://www.transparenttextures.com/patterns/dark-leather.png');
                opacity: 0.03;
                mix-blend-mode: overlay;
                pointer-events: none;
                z-index: 3;
            }

            .hero-depth-layer {
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at 50% 50%, transparent 20%, rgba(0, 0, 0, 0.5) 100%);
                pointer-events: none;
                z-index: 4;
            }

            .nav-btn {
                background: var(--h-accent);
                color: #000 !important;
                padding: 12px 28px;
                border-radius: 100px;
                font-weight: 800;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                text-decoration: none;
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                box-shadow: 0 10px 20px rgba(180, 161, 138, 0.2);
            }

            .nav-btn:hover {
                background: #fff;
                transform: translateY(-2px);
                box-shadow: 0 15px 30px rgba(255, 255, 255, 0.2);
            }

            .vet-list-header h1 {
                font-family: var(--f-grotesk);
                font-size: clamp(48px, 6vw, 84px);
                font-weight: 800;
                line-height: 0.95;
                letter-spacing: -0.05em;
                margin-bottom: 24px;
                background: linear-gradient(180deg, #fff 0%, rgba(255, 255, 255, 0.4) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .vet-list-header p {
                font-size: 22px;
                color: rgba(255, 255, 255, 0.5);
                line-height: 1.6;
                max-width: 600px;
                margin-bottom: 80px;
                font-weight: 400;
            }

            /* --- HD PREMIUM CARD DESIGN --- */
            .premium-card {
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(255, 255, 255, 0.12);
                backdrop-filter: blur(40px);
                border-radius: 48px;
                padding: 40px;
                transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1);
                position: relative;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                height: 100%;
                /* Inner HD Glow */
                box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.05);
            }

            .premium-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 100%);
                opacity: 0;
                transition: opacity 0.8s ease;
                z-index: 0;
                pointer-events: none;
            }

            .premium-card:hover {
                background: rgba(255, 255, 255, 0.04);
                border-color: rgba(180, 161, 138, 0.4);
                transform: translateY(-12px) scale(1.02);
                box-shadow: 0 60px 100px rgba(0, 0, 0, 0.6), inset 0 2px 4px rgba(255, 255, 255, 0.1);
            }

            .premium-card:hover::before {
                opacity: 1;
            }

            .card-content {
                position: relative;
                z-index: 10;
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .vet-avatar-hd {
                width: 100px;
                height: 100px;
                background: #151515;
                border: 1px solid rgba(255, 255, 255, 0.15);
                border-radius: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--h-accent);
                font-weight: 800;
                font-size: 42px;
                margin-bottom: 32px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
                transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .premium-card:hover .vet-avatar-hd {
                transform: translateY(-5px) scale(1.05);
                border-color: var(--h-accent);
                box-shadow: 0 20px 45px rgba(180, 161, 138, 0.25);
            }

            .specialization-tag {
                font-size: 11px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.25em;
                color: var(--h-accent);
                margin-bottom: 12px;
                display: block;
                opacity: 0.8;
            }

            .vet-name {
                font-family: var(--f-grotesk);
                font-size: 32px;
                font-weight: 800;
                line-height: 1.1;
                letter-spacing: -0.02em;
                margin-bottom: 20px;
                color: #fff;
            }

            .rating-pill-hd {
                background: rgba(180, 161, 138, 0.12);
                color: var(--h-accent);
                padding: 8px 16px;
                border-radius: 100px;
                font-weight: 800;
                font-size: 14px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border: 1px solid rgba(180, 161, 138, 0.3);
                margin-bottom: 24px;
            }

            .vet-bio {
                font-size: 16px;
                color: rgba(255, 255, 255, 0.45);
                line-height: 1.8;
                margin-bottom: 40px;
                flex: 1;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .card-actions {
                display: grid;
                grid-template-columns: 1fr;
                gap: 12px;
                margin-top: auto;
            }

            .btn-u-primary-hd {
                background: #fff;
                color: #000;
                padding: 18px;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 800;
                text-decoration: none;
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                text-transform: uppercase;
                letter-spacing: 0.1em;
            }

            .btn-u-primary-hd:hover {
                background: var(--h-accent);
                color: #fff;
                transform: translateY(-3px);
                box-shadow: 0 15px 30px rgba(180, 161, 138, 0.3);
            }

            .btn-u-secondary-hd {
                background: rgba(255, 255, 255, 0.05);
                color: #fff;
                border: 1px solid rgba(255, 255, 255, 0.1);
                padding: 16px;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 700;
                text-decoration: none;
                transition: all 0.4s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-u-secondary-hd:hover {
                background: rgba(255, 255, 255, 0.12);
                border-color: rgba(255, 255, 255, 0.3);
                color: var(--h-accent);
            }

            /* --- 3-COLUMN GRID --- */
            .vets-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 32px;
                position: relative;
                z-index: 10;
            }

            @media (max-width: 1200px) {
                .vets-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 768px) {
                .vets-grid {
                    grid-template-columns: 1fr;
                }
            }

            .spinner {
                width: 60px;
                height: 60px;
                border: 3px solid rgba(255, 255, 255, 0.05);
                border-top: 3px solid var(--h-accent);
                border-radius: 50%;
                animation: spin 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
                margin: 150px auto;
                grid-column: 1 / -1;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* --- MOBILE ADAPTIVE GALLERY --- */
            @media (max-width: 768px) {
                .hero-wrap>div:first-child {
                    padding: 40px 20px !important;
                }

                .vet-list-header h1 {
                    font-size: 42px;
                    line-height: 1.1;
                }

                .vet-list-header p {
                    font-size: 16px;
                }

                .vet-grid-hd {
                    grid-template-columns: 1fr !important;
                    /* Force single column */
                    gap: 32px !important;
                }

                .vet-card-hd {
                    height: auto !important;
                    min-height: 480px;
                }
            }
        </style>

        <div class="vet-list-header">
            <h1>Экспертные<br><span
                    style="font-family: var(--f-serif); font-weight: 300; font-style: italic; color: var(--h-accent);">ветеринары</span>
            </h1>
            <p>Высший стандарт ветеринарной экспертизы. Консультации лучших специалистов для здоровья ваших подопечных.
            </p>
        </div>

        <div id="vetsList" class="vets-grid">
            <div class="spinner"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', loadVets);

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function loadVets() {
        const list = document.getElementById('vetsList');

        // Cinematic Header Entry
        gsap.from(".vet-list-header h1, .vet-list-header p", {
            opacity: 0,
            y: 50,
            duration: 1.4,
            stagger: 0.3,
            ease: "expo.out"
        });

        fetch('/api/veterinarians')
            .then(async r => {
                const text = await r.text();
                try {
                    return JSON.parse(text);
                } catch (e) {
                    throw new Error('Неверный ответ от сервера');
                }
            })
            .then(data => {
                if (!data.success || !data.veterinarians || data.veterinarians.length === 0) {
                    list.innerHTML = '<p style="color: rgba(255,255,255,0.3); text-align: center; padding: 150px; grid-column: 1/-1; font-size: 20px;">Нет доступных ветеринаров в данный момент</p>';
                    return;
                }

                list.innerHTML = data.veterinarians.map(vet => {
                    const spec = Array.isArray(vet.specialization) ? vet.specialization.join(', ') : (vet.specialization || 'Общая практика');
                    const name = vet.full_name || vet.phone || vet.email || 'Ветеринар';
                    const rating = vet.rating ? parseFloat(vet.rating).toFixed(1) : '5.0';
                    const consultations = parseInt(vet.total_consultations) || 0;
                    const bio = vet.bio ? vet.bio : 'Специалист высокого уровня с многолетним опытом работы в ведущих ветеринарных центрах.';
                    const userId = vet.user_id || '';

                    return `
                        <div class="premium-card vet-card" onclick="openChat('${userId}')">
                            <div class="card-content">
                                <div class="vet-avatar-hd">
                                    ${escapeHtml(name.charAt(0).toUpperCase())}
                                </div>
                                
                                <span class="specialization-tag">${escapeHtml(spec)}</span>
                                <h3 class="vet-name">${escapeHtml(name)}</h3>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                                    <div class="rating-pill-hd">⭐ ${rating}</div>
                                    <div style="font-size: 10px; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 800;">${consultations} СЕАНСОВ</div>
                                </div>
                                
                                <p class="vet-bio">${escapeHtml(bio)}</p>
                                
                                <div class="card-actions">
                                    <button class="btn-u-primary-hd" onclick="event.stopPropagation(); openChat('${userId}')">
                                        Начать консультацию
                                    </button>
                                    ${vet.phone ? `
                                        <a href="tel:${vet.phone}" class="btn-u-secondary-hd" onclick="event.stopPropagation()">
                                            Позвонить специалисту
                                        </a>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');

                // High-End GSAP "Blind Reveal" Animation
                gsap.from(".vet-card", {
                    opacity: 0,
                    y: 60,
                    scale: 0.95,
                    rotationX: -10,
                    duration: 1.2,
                    stagger: 0.15,
                    ease: "expo.out",
                    clearProps: "all"
                });
            })
            .catch(err => {
                list.innerHTML = `<p style="color: rgba(255,255,255,0.4); text-align: center; padding: 150px; grid-column: 1/-1;">Ошибка соединения. Пожалуйста, обновите страницу.</p>`;
            });
    }

    function openChat(userId) {
        window.location.href = `/chat-user/${userId}`;
    }
</script>