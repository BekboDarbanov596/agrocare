<!-- Страница входа - AgroCare Ultra -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    .login-page {
        min-height: 100vh;
        display: flex;
        background: #070605;
        font-family: 'Inter', sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* ---- АУРА ---- */
    .login-aura {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    .l-blob-1 {
        position: absolute;
        width: 70vw;
        height: 70vw;
        border-radius: 50%;
        background: radial-gradient(circle, #b4a18a 0%, transparent 70%);
        opacity: 0.15;
        top: -20%;
        left: -20%;
        filter: blur(100px);
    }

    .l-blob-2 {
        position: absolute;
        width: 50vw;
        height: 50vw;
        border-radius: 50%;
        background: radial-gradient(circle, #849483 0%, transparent 70%);
        opacity: 0.1;
        bottom: -15%;
        right: -10%;
        filter: blur(100px);
    }

    /* ---- ЛЕВАЯ ПАНЕЛЬ ---- */
    .login-brand-panel {
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

    .login-brand-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(180, 161, 138, 0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(180, 161, 138, 0.02) 1px, transparent 1px);
        background-size: 60px 60px;
        mask-image: radial-gradient(ellipse at 60% 50%, black 20%, transparent 75%);
        pointer-events: none;
    }

    .login-brand-logo {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        position: relative;
        z-index: 2;
    }

    .login-brand-logo-dot {
        width: 5px;
        height: 5px;
        background: #b4a18a;
        border-radius: 50%;
    }

    .login-brand-logo span {
        font-size: 13px;
        font-weight: 900;
        color: #fff;
        letter-spacing: 0.05em;
    }

    /* Текст + устройства */
    .login-brand-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 80px;
        position: relative;
        z-index: 2;
    }

    .login-brand-headline {
        font-family: 'Playfair Display', serif;
        font-size: clamp(60px, 8vw, 110px);
        line-height: 0.85;
        color: #fff;
        font-style: italic;
        letter-spacing: -0.05em;
        margin-bottom: 24px;
    }

    .login-brand-headline span {
        display: block;
        font-style: normal;
        font-weight: 900;
        background: linear-gradient(to right, #b4a18a, #fff, #849483);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-top: 10px;
    }

    .login-brand-copy {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.45);
        line-height: 1.6;
        max-width: 440px;
        margin-top: 24px;
        letter-spacing: 0.01em;
    }

    /* ---- 3D УСТРОЙСТВА ---- */
    .login-devices {
        display: flex;
        align-items: flex-end;
        gap: 28px;
        perspective: 2000px;
        position: relative;
        z-index: 2;
    }

    /* Смартфон */
    .l-phone {
        width: 155px;
        height: 310px;
        background: #080808;
        border-radius: 36px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow:
            0 40px 100px rgba(0, 0, 0, 0.8),
            inset 0 0 0 1px rgba(255, 255, 255, 0.1);
        position: relative;
        transform: rotateY(-32deg) rotateX(5deg) translateZ(60px);
        margin-left: -110px;
        overflow: hidden;
        flex-shrink: 0;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .l-screen {
        position: absolute;
        inset: 6px;
        background: #050505;
        border-radius: 26px;
        overflow: hidden;
    }

    .l-screen::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 30% 20%, rgba(180, 161, 138, 0.15) 0%, transparent 60%);
        pointer-events: none;
        z-index: 1;
    }

    .l-reflection {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 40%, rgba(255, 255, 255, 0.02) 100%);
        pointer-events: none;
        z-index: 20;
    }

    /* Планшет */
    .l-tablet {
        width: 280px;
        height: 380px;
        background: #0d0d0c;
        border-radius: 32px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow:
            0 60px 120px rgba(0, 0, 0, 0.9),
            inset 0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 0 30px rgba(180, 161, 138, 0.05);
        position: relative;
        transform: rotateY(-22deg) rotateX(8deg);
        overflow: hidden;
        flex-shrink: 0;
        margin-bottom: 20px;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Holographic Scanline Effect */
    .scanline {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, transparent, rgba(180, 161, 138, 0.2), transparent);
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
        stroke: #b4a18a;
        stroke-dasharray: 251.2;
        stroke-dashoffset: 75;
        filter: drop-shadow(0 0 8px rgba(180, 161, 138, 0.5));
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
        color: rgba(180, 161, 138, 0.6);
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
        background: rgba(180, 161, 138, 0.2);
        border-radius: 2px;
        transition: height 0.3s ease;
    }

    .u-bar.active {
        background: #b4a18a;
        box-shadow: 0 0 10px rgba(180, 161, 138, 0.3);
    }

    .pulse-dot {
        width: 6px;
        height: 6px;
        background: #b4a18a;
        border-radius: 50%;
        position: relative;
    }

    .pulse-dot::after {
        content: '';
        position: absolute;
        inset: -4px;
        border: 1px solid #b4a18a;
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

    /* Нотификация-карточка */
    .l-notif {
        position: absolute;
        bottom: 20px;
        left: -40px;
        width: 170px;
        background: rgba(15, 15, 15, 0.85);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(180, 161, 138, 0.3);
        border-radius: 18px;
        padding: 14px 16px;
        z-index: 50;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .l-tablet-screen {
        position: absolute;
        inset: 5px;
        background: #0d0d0d;
        border-radius: 15px;
        overflow: hidden;
        display: grid;
        grid-template-columns: 44px 1fr;
    }

    .l-tablet-sidebar {
        background: rgba(0, 0, 0, 0.4);
        border-right: 1px solid rgba(255, 255, 255, 0.03);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 14px 0;
        gap: 12px;
    }

    .l-tablet-sidebar-dot {
        width: 16px;
        height: 16px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 5px;
    }

    .l-tablet-sidebar-dot.active {
        background: rgba(180, 161, 138, 0.5);
    }

    .l-tablet-main {
        padding: 14px 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .l-tablet-row {
        height: 36px;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.02);
        display: flex;
        align-items: center;
        padding: 0 8px;
        gap: 6px;
    }

    .l-tablet-avatar {
        width: 18px;
        height: 18px;
        border-radius: 5px;
        background: linear-gradient(135deg, #b4a18a, #7a6e60);
        opacity: 0.6;
        flex-shrink: 0;
    }

    .l-tablet-line {
        height: 5px;
        background: rgba(255, 255, 255, 0.04);
        border-radius: 3px;
        flex: 1;
    }

    .l-tablet-badge {
        width: 26px;
        height: 12px;
        background: rgba(180, 161, 138, 0.2);
        border-radius: 4px;
        flex-shrink: 0;
    }

    .l-tablet-reflection {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 10;
    }

    /* Нотификация-карточка */
    .l-notif {
        position: absolute;
        bottom: -10px;
        left: -30px;
        width: 155px;
        background: rgba(20, 20, 20, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(180, 161, 138, 0.25);
        border-radius: 14px;
        padding: 10px 12px;
        z-index: 20;
    }

    .l-notif-title {
        font-size: 7px;
        font-weight: 700;
        color: #b4a18a;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 4px;
    }

    .l-notif-val {
        font-size: 16px;
        font-weight: 900;
        color: #fff;
        font-family: 'Space Grotesk', sans-serif;
    }

    .l-notif-label {
        font-size: 7px;
        color: rgba(255, 255, 255, 0.4);
        margin-top: 2px;
    }

    /* ---- ПРАВАЯ ПАНЕЛЬ (Форма) ---- */
    .login-form-panel {
        width: 500px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 56px 64px;
        position: relative;
        z-index: 10;
    }

    .login-form-inner {
        width: 100%;
        max-width: 360px;
    }

    .login-eyebrow {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.4em;
        text-transform: uppercase;
        color: #b4a18a;
        margin-bottom: 16px;
        opacity: 0.7;
    }

    .login-title {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
        letter-spacing: -0.02em;
        line-height: 1.1;
    }

    .login-subtitle {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.3);
        margin-bottom: 40px;
    }

    .l-field {
        margin-bottom: 18px;
    }

    .l-label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: rgba(255, 255, 255, 0.35);
        margin-bottom: 9px;
    }

    .l-input-wrapper {
        position: relative;
    }

    .l-input {
        width: 100%;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 14px;
        padding: 17px 20px 17px 50px;
        font-size: 15px;
        color: #fff;
        outline: none;
        font-family: 'Inter', sans-serif;
        transition: border-color 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
    }

    .l-input::placeholder {
        color: rgba(255, 255, 255, 0.18);
    }

    .l-input:focus {
        border-color: rgba(180, 161, 138, 0.5);
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0 0 0 4px rgba(180, 161, 138, 0.06);
    }

    .l-input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.18);
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .l-field:focus-within .l-input-icon {
        color: #b4a18a;
    }

    .l-submit {
        width: 100%;
        padding: 19px;
        background: #fff;
        color: #000;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        margin-top: 28px;
        letter-spacing: 0.02em;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        font-family: 'Inter', sans-serif;
    }

    .l-submit::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #b4a18a, #8c7a65);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .l-submit:hover::before {
        opacity: 1;
    }

    .l-submit:hover {
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(180, 161, 138, 0.25);
    }

    .l-submit>* {
        position: relative;
        z-index: 1;
    }

    .l-divider {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 28px 0;
        color: rgba(255, 255, 255, 0.15);
        font-size: 11px;
        letter-spacing: 0.1em;
    }

    .l-divider::before,
    .l-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255, 255, 255, 0.06);
    }

    .l-register-link {
        text-align: center;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.3);
    }

    .l-register-link a {
        color: #b4a18a;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease;
    }

    .l-register-link a:hover {
        color: #fff;
    }

    .l-error {
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
        color: #f87171;
        font-size: 13px;
        margin-bottom: 18px;
        display: none;
    }

    .l-error.visible {
        display: block;
    }

    /* Адаптивка */
    @media (max-width: 960px) {
        .login-brand-panel {
            padding: 40px 36px;
        }

        .login-devices {
            gap: 12px;
        }

        .l-tablet {
            width: 170px;
            height: 230px;
        }

        .l-phone {
            width: 110px;
            height: 200px;
        }

        .login-form-panel {
            width: 420px;
            padding: 40px 36px;
        }
    }

    @media (max-width: 768px) {
        .login-brand-panel {
            display: none;
        }

        .login-form-panel {
            width: 100%;
            padding: 60px 24px;
        }
    }

    /* --- MOBILE ADAPTIVE LOGIN --- */
    @media (max-width: 1024px) {
        .login-page {
            flex-direction: column;
            overflow-y: auto;
        }

        .login-brand-panel {
            padding: 40px 24px;
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            min-height: auto;
        }

        .login-brand-content {
            flex-direction: column;
            gap: 40px;
            text-align: center;
        }

        .login-brand-headline {
            font-size: 52px;
        }

        .login-brand-copy {
            margin: 0 auto;
        }

        .login-devices {
            display: none;
            /* Hide 3D mockery on small screens to save space */
        }

        .login-auth-panel {
            min-height: auto;
            border-radius: 40px 40px 0 0;
            margin-top: -20px;
        }
    }
</style>

<div class="login-page">
    <div class="login-aura">
        <div class="l-blob-1"></div>
        <div class="l-blob-2"></div>
    </div>

    <!-- Левая панель — Бренд + Устройства -->
    <div class="login-brand-panel" id="loginBrandPanel">
        <div class="login-brand-grid"></div>

        <a href="/" class="login-brand-logo">
            <div class="login-brand-logo-dot"></div>
            <span>АГРО АИ</span>
        </a>

        <div class="login-brand-content">
            <!-- ТЕКСТ СЛЕВА -->
            <div class="login-brand-text-block">
                <div class="login-brand-headline">
                    Точное<br><span>Земледелие</span>
                </div>
                <p class="login-brand-copy">
                    Войдите в экосистему будущего. Предиктивный анализ, биомониторинг и умное планирование урожая в
                    одном интерфейсе.
                </p>
            </div>

            <!-- ДИВАЙСЫ СПРАВА -->
            <div class="login-devices" id="loginDevices">
                <!-- ТАБЛЕТКА - СМАРТ ДАШБОРД -->
                <div class="l-tablet" id="lTablet">
                    <div class="l-screen" style="border-radius: 26px;">
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
                                    <span class="val-num">92%</span>
                                    <span class="val-unit">Точность</span>
                                </div>
                            </div>

                            <!-- Dashboard Cards -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div class="ui-card-sm">
                                    <div class="ui-label-sm">Урожайность</div>
                                    <div class="ui-data-sm">+24.5%</div>
                                    <div class="ui-bar-graph">
                                        <div class="u-bar" style="height: 40%;"></div>
                                        <div class="u-bar active" style="height: 80%;"></div>
                                        <div class="u-bar" style="height: 60%;"></div>
                                        <div class="u-bar" style="height: 95%;"></div>
                                    </div>
                                </div>
                                <div class="ui-card-sm">
                                    <div class="ui-label-sm">Био-баланс</div>
                                    <div class="ui-data-sm">Стабильно</div>
                                    <div style="display: flex; align-items: center; gap: 8px; margin-top: auto;">
                                        <div class="pulse-dot"></div>
                                        <span style="font-size: 10px; font-weight: 900; color: #b4a18a;">Норма</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="l-reflection" style="border-radius: 26px;"></div>
                </div>

                <!-- ТЕЛЕФОН - ЖИВОЙ МОНИТОРИНГ -->
                <div class="l-phone" id="lPhone">
                    <div class="l-screen">
                        <div class="scanline" style="animation-delay: 2s;"></div>
                        <div style="padding: 20px; display: flex; flex-direction: column; height: 100%;">
                            <div
                                style="display: flex; justify-content: space-between; font-size: 9px; font-weight: 900; color: rgba(255,255,255,0.4); margin-bottom: 20px;">
                                <span>9:41</span>
                                <span>5G</span>
                            </div>

                            <div
                                style="background: rgba(180,161,138,0.1); border-radius: 14px; padding: 16px; margin-bottom: 20px; border: 1px solid rgba(180,161,138,0.2);">
                                <div class="ui-label-sm" style="margin-bottom: 12px;">Аналитика почвы</div>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div
                                        style="height: 6px; background: rgba(180,161,138,0.3); border-radius: 3px; width: 100%;">
                                    </div>
                                    <div
                                        style="height: 6px; background: rgba(180,161,138,0.3); border-radius: 3px; width: 65%;">
                                    </div>
                                    <div
                                        style="height: 6px; background: rgba(180,161,138,0.3); border-radius: 3px; width: 90%;">
                                    </div>
                                </div>
                            </div>

                            <div
                                style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 16px;">
                                <div
                                    style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #b4a18a; display: flex; align-items: center; justify-content: center; position: relative;">
                                    <div
                                        style="width: 40px; height: 40px; border-radius: 50%; background: #b4a18a; opacity: 0.2; animation: pulseRing 2s infinite;">
                                    </div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#b4a18a"
                                        stroke-width="2" style="position: absolute;">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                                    </svg>
                                </div>
                                <div style="text-align: center;">
                                    <div
                                        style="font-size: 11px; font-weight: 900; color: #fff; text-transform: uppercase;">
                                        Мониторинг</div>
                                    <div style="font-size: 8px; color: rgba(255,255,255,0.3); margin-top: 4px;">
                                        Предиктивный анализ активен</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="l-reflection"></div>
                </div>
            </div>
        </div>

        <div
            style="font-size: 11px; color: rgba(255,255,255,0.15); letter-spacing: 0.15em; text-transform: uppercase; position: relative; z-index: 2;">
            АгроКер &copy; 2026
        </div>
    </div>

    <!-- Правая панель — Форма -->
    <div class="login-form-panel">
        <div class="login-form-inner" id="loginFormInner">
            <div class="login-eyebrow">Добро пожаловать</div>
            <h1 class="login-title">Вход в аккаунт</h1>
            <p class="login-subtitle">Введите данные для доступа к платформе</p>

            <div class="l-error" id="loginError"></div>

            <form id="loginForm" autocomplete="off">
                <div class="l-field">
                    <label class="l-label" for="email">Email или телефон</label>
                    <div class="l-input-wrapper">
                        <input type="text" class="l-input" id="email" placeholder="email@пример.com" required
                            autocomplete="username">
                        <svg class="l-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                </div>

                <div class="l-field">
                    <label class="l-label" for="password">Пароль</label>
                    <div class="l-input-wrapper">
                        <input type="password" class="l-input" id="password" placeholder="••••••••" required
                            autocomplete="current-password">
                        <svg class="l-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </div>
                </div>

                <button type="submit" class="l-submit" id="loginBtn">
                    <span>Войти</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </button>
            </form>

            <div class="l-divider">или</div>
            <div class="l-register-link">
                Нет аккаунта? <a href="/register">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        // GSAP анимации
        if (typeof gsap !== 'undefined') {
            const tl = gsap.timeline({ defaults: { ease: "expo.out" } });
            tl.from("#loginFormInner > *", { opacity: 0, y: 30, duration: 1, stagger: 0.08 }, 0.1)
                .from(".login-brand-headline", { opacity: 0, x: -40, duration: 1.4 }, 0.05)
                .from(".login-brand-copy", { opacity: 0, y: 20, duration: 1 }, 0.35)
                .from("#lPhone", { opacity: 0, x: 30, rotateY: -50, duration: 1.4 }, 0.4)
                .from("#lTablet", { opacity: 0, x: -30, rotateY: -30, duration: 1.4 }, 0.55);

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
            const brandPanel = document.querySelector('.login-brand-panel');
            if (brandPanel) {
                brandPanel.addEventListener('mousemove', e => {
                    const r = brandPanel.getBoundingClientRect();
                    const x = (e.clientX - r.left) / r.width - 0.5;
                    const y = (e.clientY - r.top) / r.height - 0.5;
                    gsap.to("#lTablet", {
                        rotateY: -22 + x * 15,
                        rotateX: 8 - y * 10,
                        duration: 0.6,
                        ease: "power2.out"
                    });
                    gsap.to("#lPhone", {
                        rotateY: -32 + x * 20,
                        rotateX: 5 - y * 8,
                        duration: 0.6,
                        ease: "power2.out"
                    });
                });

                brandPanel.addEventListener('mouseleave', () => {
                    gsap.to("#lTablet", { rotateY: -22, rotateX: 8, duration: 1 });
                    gsap.to("#lPhone", { rotateY: -32, rotateX: 5, duration: 1 });
                });
            }

            // Аура плавает
            gsap.to(".l-blob-1", { x: "10%", y: "8%", duration: 12, repeat: -1, yoyo: true, ease: "sine.inOut" });
            gsap.to(".l-blob-2", { x: "-8%", y: "-6%", duration: 9, repeat: -1, yoyo: true, ease: "sine.inOut" });
        }

        // Отправка формы
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const btn = document.getElementById('loginBtn');
            const err = document.getElementById('loginError');

            btn.style.pointerEvents = 'none';
            btn.querySelector('span').textContent = 'Входим...';
            err.classList.remove('visible');

            fetch('/api/auth/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        btn.querySelector('span').textContent = 'Успешно! ✓';
                        setTimeout(() => { window.location.href = '/dashboard'; }, 500);
                    } else {
                        err.textContent = data.error || 'Неверный email или пароль';
                        err.classList.add('visible');
                        btn.style.pointerEvents = '';
                        btn.querySelector('span').textContent = 'Войти';
                        if (typeof gsap !== 'undefined') {
                            gsap.fromTo('#loginError', { x: -8 }, { x: 8, duration: 0.07, repeat: 5, yoyo: true, ease: "none" });
                        }
                    }
                })
                .catch(() => {
                    err.textContent = 'Ошибка соединения. Попробуйте снова.';
                    err.classList.add('visible');
                    btn.style.pointerEvents = '';
                    btn.querySelector('span').textContent = 'Войти';
                });
        });
    })();
</script>