<!-- Страница регистрации - AgroCare Ultra -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    .register-page {
        min-height: 100vh;
        display: flex;
        background: #070605;
        font-family: 'Inter', sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* ---- АУРА ---- */
    .reg-aura {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    .reg-blob-1 {
        position: absolute;
        width: 80vw;
        height: 80vw;
        border-radius: 50%;
        background: radial-gradient(circle, #849483 0%, transparent 70%);
        opacity: 0.12;
        top: -30%;
        right: -20%;
        filter: blur(120px);
    }

    .reg-blob-2 {
        position: absolute;
        width: 60vw;
        height: 60vw;
        border-radius: 50%;
        background: radial-gradient(circle, #b4a18a 0%, transparent 70%);
        opacity: 0.15;
        bottom: -20%;
        left: -10%;
        filter: blur(100px);
    }

    /* ---- ЛЕВАЯ ПАНЕЛЬ (БРЕНДИНГ) ---- */
    .reg-brand-panel {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 56px 64px;
        position: relative;
        z-index: 10;
        border-right: 1px solid rgba(255, 255, 255, 0.04);
        background: linear-gradient(to bottom, rgba(7, 6, 5, 0.5), transparent);
    }

    .reg-brand-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(180, 161, 138, 0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(180, 161, 138, 0.02) 1px, transparent 1px);
        background-size: 60px 60px;
        mask-image: radial-gradient(ellipse at 40% 50%, black 20%, transparent 80%);
        pointer-events: none;
    }

    .reg-logo {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        position: relative;
        z-index: 2;
    }

    .reg-logo-dot {
        width: 5px;
        height: 5px;
        background: #b4a18a;
        border-radius: 50%;
    }

    .reg-logo span {
        font-size: 13px;
        font-weight: 900;
        color: #fff;
        letter-spacing: 0.05em;
    }

    /* Текст + устройства - ГОРИЗОНТАЛЬНЫЙ ЛЕЙАУТ */
    .reg-brand-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 80px;
        position: relative;
        z-index: 2;
        margin-top: -40px;
    }

    .reg-brand-text-block {
        flex: 1;
        max-width: 600px;
    }

    .reg-headline {
        font-family: 'Playfair Display', serif;
        font-size: clamp(60px, 8vw, 110px);
        line-height: 0.85;
        color: #fff;
        font-style: italic;
        letter-spacing: -0.05em;
        margin-bottom: 24px;
    }

    .reg-headline span {
        display: block;
        font-style: normal;
        font-weight: 900;
        background: linear-gradient(to right, #849483, #fff, #b4a18a);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-top: 10px;
    }

    .reg-copy {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.45);
        line-height: 1.6;
        max-width: 440px;
        letter-spacing: 0.01em;
    }

    /* ---- 3D МОКАПЫ УСТРОЙСТВ ---- */
    .reg-devices {
        display: flex;
        align-items: center;
        gap: 24px;
        perspective: 2000px;
        flex-shrink: 0;
    }

    .reg-device-tablet {
        width: 280px;
        height: 380px;
        background: #0d0d0c;
        border-radius: 32px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow:
            0 60px 120px rgba(0, 0, 0, 0.9),
            inset 0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 0 30px rgba(132, 148, 131, 0.05);
        position: relative;
        transform: rotateY(22deg) rotateX(8deg);
        overflow: hidden;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .reg-device-phone {
        width: 155px;
        height: 310px;
        background: #080808;
        border-radius: 36px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow:
            0 40px 100px rgba(0, 0, 0, 0.8),
            inset 0 0 0 1px rgba(255, 255, 255, 0.1);
        position: relative;
        transform: rotateY(32deg) rotateX(5deg) translateZ(60px);
        margin-left: -110px;
        overflow: hidden;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .reg-screen {
        position: absolute;
        inset: 6px;
        background: #050505;
        border-radius: 26px;
        overflow: hidden;
    }

    .reg-screen::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 20%, rgba(132, 148, 131, 0.15) 0%, transparent 60%);
        pointer-events: none;
        z-index: 1;
    }

    .reg-reflection {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 40%, rgba(255, 255, 255, 0.02) 100%);
        pointer-events: none;
        z-index: 20;
    }

    /* Holographic Scanline Effect */
    .scanline {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, transparent, rgba(132, 148, 131, 0.2), transparent);
        z-index: 10;
        pointer-events: none;
        animation: scanMove 4s linear infinite;
    }

    @keyframes scanMove {
        0% {
            top: -5%;
        }

        100% {
            top: 105%;
        }
    }

    /* Internal UI Styles */
    .ui-gauge {
        width: 120px;
        height: 120px;
        position: relative;
        margin: 0 auto 20px;
    }

    .gauge-svg {
        transform: rotate(-90deg);
    }

    .gauge-bg {
        stroke: rgba(255, 255, 255, 0.05);
    }

    .gauge-fill {
        stroke: #849483;
        stroke-dasharray: 251.2;
        stroke-dashoffset: 75;
        filter: drop-shadow(0 0 8px rgba(132, 148, 131, 0.5));
    }

    .gauge-val {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .val-num {
        font-size: 24px;
        font-weight: 900;
        color: #fff;
        line-height: 1;
    }

    .val-unit {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.3);
        text-transform: uppercase;
        margin-top: 4px;
    }

    .ui-card-sm {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .ui-label-sm {
        font-size: 8px;
        font-weight: 800;
        color: rgba(132, 148, 131, 0.6);
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .ui-data-sm {
        font-size: 14px;
        font-weight: 700;
        color: #fff;
    }

    .ui-bar-graph {
        display: flex;
        align-items: flex-end;
        gap: 4px;
        height: 40px;
    }

    .u-bar {
        flex: 1;
        background: rgba(132, 148, 131, 0.2);
        border-radius: 2px;
        transition: height 0.3s ease;
    }

    .u-bar.active {
        background: #849483;
        box-shadow: 0 0 10px rgba(132, 148, 131, 0.3);
    }

    .pulse-dot {
        width: 6px;
        height: 6px;
        background: #849483;
        border-radius: 50%;
        position: relative;
    }

    .pulse-dot::after {
        content: '';
        position: absolute;
        inset: -4px;
        border: 1px solid #849483;
        border-radius: 50%;
        animation: pulseRing 1.5s infinite;
    }

    @keyframes pulseRing {
        0% {
            transform: scale(0.5);
            opacity: 1;
        }

        100% {
            transform: scale(3.5);
            opacity: 0;
        }
    }

    .reg-form-panel {
        width: 580px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 64px;
        position: relative;
        z-index: 10;
        overflow-y: auto;
    }

    .reg-form-inner {
        width: 100%;
        max-width: 420px;
    }

    .reg-eyebrow {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.4em;
        text-transform: uppercase;
        color: #849483;
        margin-bottom: 12px;
    }

    .reg-title {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
        letter-spacing: -0.02em;
    }

    .reg-subtitle {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.3);
        margin-bottom: 40px;
    }

    /* Поля ввода */
    .reg-field {
        margin-bottom: 20px;
    }

    .reg-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: rgba(255, 255, 255, 0.4);
        margin-bottom: 10px;
    }

    .reg-input-wrap {
        position: relative;
    }

    .reg-input {
        width: 100%;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 14px;
        padding: 16px 20px 16px 50px;
        font-size: 15px;
        color: #fff;
        outline: none;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .reg-input:focus {
        border-color: #849483;
        background: rgba(255, 255, 255, 0.04);
        box-shadow: 0 0 0 4px rgba(132, 148, 131, 0.1);
    }

    .reg-input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.15);
        transition: 0.3s;
    }

    .reg-input:focus~.reg-input-icon {
        color: #849483;
    }

    /* Выбор роли в стиле премиальных карточек */
    .role-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 12px;
    }

    .role-card {
        background: rgba(255, 255, 255, 0.015);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 14px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .role-card:hover {
        background: rgba(255, 255, 255, 0.03);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .role-card.active {
        background: rgba(132, 148, 131, 0.08);
        border-color: #849483;
        box-shadow: inset 0 0 20px rgba(132, 148, 131, 0.05);
    }

    .role-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.03);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.4);
    }

    .role-card.active .role-icon {
        background: #849483;
        color: #000;
    }

    .role-name {
        font-size: 12px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.5);
    }

    .role-card.active .role-name {
        color: #fff;
    }

    .reg-submit {
        width: 100%;
        padding: 18px;
        background: #fff;
        color: #000;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        margin-top: 32px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .reg-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(132, 148, 131, 0.2);
        background: #849483;
        color: #fff;
    }

    .reg-footer {
        margin-top: 32px;
        text-align: center;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.25);
    }

    .reg-footer a {
        color: #849483;
        text-decoration: none;
        font-weight: 700;
        transition: 0.3s;
    }

    .reg-footer a:hover {
        color: #fff;
    }

    @media (max-width: 1024px) {
        .reg-brand-panel {
            display: none;
        }

        .reg-form-panel {
            width: 100%;
            padding: 48px 24px;
        }
    }

    /* --- MOBILE ADAPTIVE REGISTER --- */
    @media (max-width: 1024px) {
        .register-page {
            flex-direction: column;
            overflow-y: auto;
        }

        .reg-brand-panel {
            padding: 40px 24px;
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            min-height: auto;
        }

        .reg-brand-content {
            flex-direction: column;
            gap: 40px;
            text-align: center;
            margin-top: 0;
        }

        .reg-headline {
            font-size: 52px;
        }

        .reg-copy {
            margin: 0 auto;
        }

        .reg-devices {
            display: none;
            /* Hide 3D mockery on small screens */
        }

        .reg-auth-panel {
            min-height: auto;
            border-radius: 40px 40px 0 0;
            margin-top: -20px;
        }
    }
</style>

<div class="register-page">
    <div class="reg-aura">
        <div class="reg-blob-1"></div>
        <div class="reg-blob-2"></div>
    </div>

    <!-- Левая панель -->
    <div class="reg-brand-panel">
        <div class="reg-brand-grid"></div>

        <a href="/" class="reg-logo">
            <div class="reg-logo-dot"></div>
            <span>АГРО АИ</span>
        </a>

        <div class="reg-brand-content">
            <!-- ДИВАЙСЫ СЛЕВА -->
            <div class="reg-devices">
                <!-- ТАБЛЕТКА - СМАРТ ДАШБОРД -->
                <div class="reg-device-tablet" id="lTablet">
                    <div class="reg-screen">
                        <div class="scanline"></div>
                        <div style="padding: 24px; display: flex; flex-direction: column;">
                            <!-- Header UI -->
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                                <div style="display: flex; gap: 6px;">
                                    <div
                                        style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444; opacity: 0.6;">
                                    </div>
                                    <div
                                        style="width: 8px; height: 8px; border-radius: 50%; background: #eab308; opacity: 0.6;">
                                    </div>
                                    <div
                                        style="width: 8px; height: 8px; border-radius: 50%; background: #22c55e; opacity: 0.6;">
                                    </div>
                                </div>
                                <div
                                    style="font-size: 9px; font-weight: 800; color: rgba(255,255,255,0.2); letter-spacing: 0.2em;">
                                    LIVE SYSTEM.OS</div>
                            </div>

                            <!-- Gauge -->
                            <div class="ui-gauge">
                                <svg class="gauge-svg" viewBox="0 0 100 100">
                                    <circle class="gauge-bg" cx="50" cy="50" r="40" fill="none" stroke-width="6">
                                    </circle>
                                    <circle class="gauge-fill" cx="50" cy="50" r="40" fill="none" stroke-width="6"
                                        id="gaugeFill"></circle>
                                </svg>
                                <div class="gauge-val">
                                    <span class="val-num">84%</span>
                                    <span class="val-unit">Почва</span>
                                </div>
                            </div>

                            <!-- Dashboard Cards -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div class="ui-card-sm">
                                    <div class="ui-label-sm">Влажность</div>
                                    <div class="ui-data-sm">42.8%</div>
                                    <div class="ui-bar-graph">
                                        <div class="u-bar" style="height: 40%;"></div>
                                        <div class="u-bar active" style="height: 70%;"></div>
                                        <div class="u-bar" style="height: 50%;"></div>
                                        <div class="u-bar" style="height: 85%;"></div>
                                    </div>
                                </div>
                                <div class="ui-card-sm">
                                    <div class="ui-label-sm">Азот N2</div>
                                    <div class="ui-data-sm">12.5 mg</div>
                                    <div style="display: flex; align-items: center; gap: 8px; margin-top: auto;">
                                        <div class="pulse-dot"></div>
                                        <span style="font-size: 10px; font-weight: 900; color: #849483;">Норма</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reg-reflection"></div>
                </div>

                <!-- ТЕЛЕФОН - ЖИВОЙ МОНИТОРИНГ -->
                <div class="reg-device-phone" id="lPhone">
                    <div class="reg-screen">
                        <div class="scanline" style="animation-delay: 2s;"></div>
                        <div style="padding: 20px; display: flex; flex-direction: column; height: 100%;">
                            <div
                                style="display: flex; justify-content: space-between; font-size: 9px; font-weight: 900; color: rgba(255,255,255,0.4); margin-bottom: 20px;">
                                <span>9:41</span>
                                <span>LTE</span>
                            </div>

                            <div
                                style="background: rgba(132,148,131,0.1); border-radius: 14px; padding: 16px; margin-bottom: 20px; border: 1px solid rgba(132,148,131,0.2);">
                                <div class="ui-label-sm" style="margin-bottom: 12px;">Анализ поля #04</div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div
                                        style="height: 6px; background: rgba(132,148,131,0.3); border-radius: 3px; width: 100%;">
                                    </div>
                                    <div
                                        style="height: 6px; background: rgba(132,148,131,0.3); border-radius: 3px; width: 70%;">
                                    </div>
                                    <div
                                        style="height: 6px; background: rgba(132,148,131,0.3); border-radius: 3px; width: 85%;">
                                    </div>
                                </div>
                            </div>

                            <div
                                style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 16px;">
                                <div
                                    style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #849483; display: flex; align-items: center; justify-content: center; position: relative;">
                                    <div
                                        style="width: 40px; height: 40px; border-radius: 50%; background: #849483; opacity: 0.2; animation: pulseRing 2s infinite;">
                                    </div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#849483"
                                        stroke-width="2" style="position: absolute;">
                                        <path d="M12 2v20M2 12h20"></path>
                                    </svg>
                                </div>
                                <div style="text-align: center;">
                                    <div
                                        style="font-size: 11px; font-weight: 900; color: #fff; text-transform: uppercase;">
                                        Сканирование</div>
                                    <div style="font-size: 8px; color: rgba(255,255,255,0.3); margin-top: 4px;">
                                        Обнаружена зона дефицита</div>
                                </div>
                            </div>

                            <div
                                style="height: 40px; background: rgba(255,255,255,0.03); border-radius: 12px; margin-top: auto; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 800; color: #849483; border: 1px dashed rgba(132,148,131,0.4);">
                                ПОДРОБНЕЕ
                            </div>
                        </div>
                    </div>
                    <div class="reg-reflection"></div>
                </div>
            </div>

            <!-- ТЕКСТ СПРАВА -->
            <div class="reg-brand-text-block">
                <div class="reg-headline">Создайте<br><span>Будущее</span></div>
                <p class="reg-copy">Присоединяйтесь к эквайрингу передовых агротехнологий. Масштабируйте производство,
                    оптимизируйте ресурсы и управляйте результатами в реальном времени.</p>
            </div>
        </div>

        <div style="font-size: 11px; color: rgba(255,255,255,0.15); text-transform: uppercase;">AgroCare &copy; 2026
        </div>
    </div>

    <!-- Правая панель (Форма) -->
    <div class="reg-form-panel">
        <div class="reg-form-inner">
            <div class="reg-eyebrow">Начните сейчас</div>
            <h1 class="reg-title">Регистрация</h1>
            <p class="reg-subtitle">Создайте аккаунт для доступа к инструментам Agro AI</p>

            <form id="registerForm">
                <div class="reg-field">
                    <label class="reg-label">Email адрес</label>
                    <div class="reg-input-wrap">
                        <svg class="reg-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        <input type="email" class="reg-input" id="email" placeholder="example@agro.ai" required>
                    </div>
                </div>

                <div class="reg-field">
                    <label class="reg-label">Телефон</label>
                    <div class="reg-input-wrap">
                        <svg class="reg-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        <input type="tel" class="reg-input" id="phone" placeholder="+996 --- --- ---">
                    </div>
                </div>

                <div class="reg-field">
                    <label class="reg-label">Выберите вашу роль</label>
                    <div class="role-grid">
                        <div class="role-card active" data-role="farmer">
                            <div class="role-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                                </svg></div>
                            <div class="role-name">Фермер</div>
                        </div>
                        <div class="role-card" data-role="agronomist">
                            <div class="role-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v20M2 12h20" />
                                    <path d="m12 2 4 4-4-4-4 4" />
                                </svg></div>
                            <div class="role-name">Агроном</div>
                        </div>
                        <div class="role-card" data-role="veterinarian">
                            <div class="role-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                                </svg></div>
                            <div class="role-name">Ветеринар</div>
                        </div>
                        <div class="role-card" data-role="manager">
                            <div class="role-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg></div>
                            <div class="role-name">Менеджер</div>
                        </div>
                    </div>
                    <input type="hidden" id="role" value="farmer">
                </div>

                <div class="reg-field">
                    <label class="reg-label">Пароль</label>
                    <div class="reg-input-wrap">
                        <svg class="reg-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <input type="password" class="reg-input" id="password" placeholder="Минимум 6 символов"
                            required>
                    </div>
                </div>

                <button type="submit" class="reg-submit" id="regBtn">
                    <span>Зарегистрироваться</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </button>
            </form>

            <div class="reg-footer">
                Уже есть аккаунт? <a href="/login">Войти</a>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        // Выбор роли
        const cards = document.querySelectorAll('.role-card');
        const roleInput = document.getElementById('role');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                roleInput.value = card.dataset.role;
            });
        });

        // GSAP анимации
        if (typeof gsap !== 'undefined') {
            const tl = gsap.timeline({ defaults: { ease: "expo.out" } });
            tl.from(".reg-form-inner > *", { opacity: 0, y: 30, duration: 1, stagger: 0.08 }, 0.1)
                .from(".reg-headline", { opacity: 0, x: -40, duration: 1.4 }, 0.05)
                .from(".reg-copy", { opacity: 0, y: 20, duration: 1 }, 0.35)
                .from(".reg-device-tablet", { opacity: 0, x: -30, rotateY: -30, duration: 1.5 }, 0.4)
                .from(".reg-device-phone", { opacity: 0, x: 30, rotateY: 40, duration: 1.5 }, 0.55);

            // Анимация GUI внутри устройств
            gsap.from("#gaugeFill", {
                strokeDashoffset: 251.2,
                duration: 2,
                delay: 1.5,
                ease: "power2.out"
            });

            gsap.to(".u-bar", {
                height: (i, el) => Math.random() * 60 + 20 + "%",
                duration: 1.5,
                repeat: -1,
                yoyo: true,
                stagger: 0.1,
                ease: "sine.inOut"
            });

            // Мягкий параллакс для устройств по мыши
            const brandPanel = document.querySelector('.reg-brand-panel');
            if (brandPanel) {
                brandPanel.addEventListener('mousemove', e => {
                    const r = brandPanel.getBoundingClientRect();
                    const x = (e.clientX - r.left) / r.width - 0.5;
                    const y = (e.clientY - r.top) / r.height - 0.5;
                    gsap.to(".reg-device-tablet", {
                        rotateY: 22 + x * 15,
                        rotateX: 8 - y * 10,
                        duration: 0.6,
                        ease: "power2.out"
                    });
                    gsap.to(".reg-device-phone", {
                        rotateY: 32 + x * 20,
                        rotateX: 5 - y * 8,
                        duration: 0.6,
                        ease: "power2.out"
                    });
                });

                brandPanel.addEventListener('mouseleave', () => {
                    gsap.to(".reg-device-tablet", { rotateY: 22, rotateX: 8, duration: 1 });
                    gsap.to(".reg-device-phone", { rotateY: 32, rotateX: 5, duration: 1 });
                });
            }
        }

        // Обработка формы
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = document.getElementById('regBtn');
            const formData = {
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                password: document.getElementById('password').value,
                role: document.getElementById('role').value
            };

            btn.style.pointerEvents = 'none';
            btn.querySelector('span').textContent = 'Создаем аккаунт...';

            fetch('/api/auth/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        btn.querySelector('span').textContent = 'Успешно!';
                        setTimeout(() => { window.location.href = '/dashboard'; }, 500);
                    } else {
                        alert('Ошибка: ' + (data.error || 'Ошибка регистрации'));
                        btn.style.pointerEvents = '';
                        btn.querySelector('span').textContent = 'Зарегистрироваться';
                    }
                })
                .catch(err => {
                    console.error(err);
                    btn.style.pointerEvents = '';
                    btn.querySelector('span').textContent = 'Зарегистрироваться';
                });
        });
    })();
</script>