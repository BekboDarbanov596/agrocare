<!-- Dashboard Command Center - AgroCare Ultra -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    :root {
        --dash-bg: #070605;
        --dash-sidebar-w: 80px;
        --dash-header-h: 70px;
        --glass-bg: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.07);
        --accent-sage: #849483;
        --accent-gold: #b4a18a;
    }

    /* ---- TELEMETRY EFFECTS ---- */
    .telemetry-scanline {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(132, 148, 131, 0.05) 50.5%, transparent 51%);
        background-size: 100% 4px;
        pointer-events: none;
        opacity: 0.3;
        animation: scanline 8s linear infinite;
    }

    @keyframes scanline {
        from {
            transform: translateY(-100%);
        }

        to {
            transform: translateY(100%);
        }
    }

    .telemetry-dot {
        width: 6px;
        height: 6px;
        background: var(--accent-sage);
        border-radius: 50%;
        box-shadow: 0 0 10px var(--accent-sage);
        animation: pulse-telemetry 2s ease-in-out infinite;
    }

    @keyframes pulse-telemetry {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.5);
            opacity: 0.4;
        }
    }

    .ekg-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        opacity: 0.2;
        pointer-events: none;
    }

    .hologram-overlay {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
        pointer-events: none;
    }

    .ai-glow {
        animation: ai-pulse 4s ease-in-out infinite;
    }

    @keyframes ai-pulse {

        0%,
        100% {
            box-shadow: 0 0 20px rgba(132, 148, 131, 0.2);
        }

        50% {
            box-shadow: 0 0 40px rgba(132, 148, 131, 0.5);
        }
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .dashboard-wrapper {
        min-height: 100vh;
        background: var(--dash-bg);
        color: #fff;
        font-family: 'Inter', sans-serif;
        display: flex;
        overflow: hidden;
        position: relative;
    }

    .dash-aura {
        display: none !important;
        /* NUCLEAR Performance Strike */
    }

    /* ---- SIDEBAR ---- */
    .dash-sidebar {
        width: var(--dash-sidebar-w);
        height: 100vh;
        background: #141312;
        /* Nuclear Solid */
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        border-right: 1px solid rgba(255, 255, 255, 0.12);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 32px 0;
        position: relative;
        z-index: 99999 !important;
        /* Absolute priority */
        pointer-events: auto !important;
        transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .dash-logo-small {
        width: 32px;
        height: 32px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 60px;
        cursor: pointer;
    }

    .dash-nav {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .nav-item {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.3);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }

    .nav-item:hover,
    .nav-item.active {
        background: var(--glass-bg);
        color: #fff;
        border: 1px solid var(--glass-border);
    }

    .nav-item.active::after {
        content: '';
        position: absolute;
        left: -16px;
        width: 4px;
        height: 20px;
        background: var(--accent-sage);
        border-radius: 0 4px 4px 0;
        box-shadow: 0 0 15px var(--accent-sage);
    }

    /* ---- MAIN CONTENT ---- */
    .dash-main {
        flex: 1;
        height: 100vh;
        overflow-y: auto;
        position: relative;
        z-index: 10;
        padding: 0 40px 40px;
    }

    /* ---- PREMIUM HEADER (AGRO AURA ELITE) ---- */
    .dash-header {
        height: var(--dash-header-h);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        background: #1a1816;
        /* Solid secondary dark */
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 9000;
        padding: 0 40px;
        margin-bottom: 32px;
    }

    .dash-title-block h1 {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, #fff, rgba(255, 255, 255, 0.6));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .dash-controls {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .dash-user {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 20px 6px 6px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 100px;
        transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .dash-user::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
        transform: translateX(-100%);
        transition: transform 0.8s;
    }

    .dash-user:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
        transform: scale(1.02);
        will-change: transform;
    }

    .dash-user:hover::before {
        transform: translateX(100%);
    }

    .user-avatar {
        position: relative;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-ring {
        position: absolute;
        inset: -3px;
        border: 1px solid var(--accent-gold);
        border-radius: 50%;
        opacity: 0.4;
        animation: spin 12s linear infinite;
        will-change: transform;
    }

    .avatar-main {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--accent-gold), #8a7a68);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--f-grotesk);
        font-weight: 800;
        font-size: 15px;
        color: #000;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    }

    .avatar-main::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.2), transparent);
    }

    .status-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 11px;
        height: 11px;
        background: #10b981;
        border: 2px solid #000;
        border-radius: 50%;
        z-index: 5;
        box-shadow: 0 0 12px #10b981, 0 0 4px #10b981;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .u-name {
        font-family: var(--f-grotesk);
        font-size: 14px;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #fff;
        line-height: 1.2;
    }

    .u-role {
        font-family: var(--f-grotesk);
        font-size: 8px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: var(--accent-gold);
        opacity: 0.8;
    }

    /* ---- BENTO GRID ---- */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-auto-rows: minmax(160px, auto);
        gap: 24px;
    }

    .bento-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 32px;
        padding: 32px;
        position: relative;
        overflow: hidden;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .bento-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.15);
    }

    .card-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: var(--accent-sage);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Specific Sizes */
    .col-large {
        grid-column: span 8;
    }

    .col-medium {
        grid-column: span 4;
    }

    .col-small {
        grid-column: span 3;
    }

    .row-large {
        grid-row: span 2;
    }

    /* ---- WIDGETS ---- */
    .ui-gauge-lg {
        width: 180px;
        height: 180px;
        margin: 0 auto;
        position: relative;
    }

    .gauge-svg-lg {
        transform: rotate(-90deg);
        filter: drop-shadow(0 0 15px rgba(132, 148, 131, 0.3));
    }

    .gauge-val-lg {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .val-main {
        font-size: 42px;
        font-weight: 900;
        line-height: 1;
    }

    .val-sub {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.4);
        margin-top: 4px;
    }

    .chart-placeholder {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: flex-end;
        gap: 12px;
        padding-top: 20px;
    }

    .chart-bar {
        flex: 1;
        background: rgba(132, 148, 131, 0.1);
        border-radius: 6px;
        position: relative;
        transition: 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .chart-bar.active {
        background: var(--accent-sage);
    }

    .stat-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 10px;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .stat-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .stat-name {
        font-size: 14px;
        font-weight: 500;
    }

    .stat-val {
        font-size: 16px;
        font-weight: 800;
        color: var(--accent-gold);
    }

    /* Custom Scrollbar */
    .dash-main::-webkit-scrollbar {
        width: 6px;
    }

    .dash-main::-webkit-scrollbar-track {
        background: transparent;
    }

    .dash-main::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    @media (max-width: 1100px) {

        .col-large,
        .col-medium,
        .col-small {
            grid-column: span 12;
        }
    }

    /* --- NOTIFICATION PANEL --- */
    .notif-panel {
        position: fixed;
        top: 0;
        right: 0;
        width: 400px;
        height: 100vh;
        background: rgba(15, 14, 12, 0.7);
        backdrop-filter: blur(50px);
        border-left: 1px solid rgba(255, 255, 255, 0.08);
        z-index: 2000;
        transform: translateX(100%);
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        box-shadow: -20px 0 50px rgba(0, 0, 0, 0.5);
    }

    .notif-panel.active {
        transform: translateX(0);
    }

    .notif-header {
        padding: 40px 32px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .notif-title {
        font-family: var(--f-grotesk);
        font-size: 24px;
        font-weight: 800;
    }

    .notif-close {
        cursor: pointer;
        opacity: 0.5;
        transition: 0.3s;
    }

    .notif-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .notif-list {
        flex: 1;
        overflow-y: auto;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .notif-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        gap: 16px;
        transition: 0.3s;
        animation: revealUp 0.5s ease-out forwards;
        opacity: 0;
    }

    .notif-item:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(180, 161, 138, 0.3);
    }

    .notif-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    /* Notification Bell Styles */
    .notif-trigger {
        position: relative;
        cursor: pointer;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
        color: rgba(255, 255, 255, 0.4);
    }

    .notif-trigger:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        transform: translateY(-2px);
    }

    .notif-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background: #fff;
        color: #000;
        font-family: var(--f-grotesk);
        font-size: 9px;
        font-weight: 900;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        border: 2px solid #000;
    }

    @media (max-width: 768px) {
        .notif-panel {
            width: 100%;
        }
    }

    /* --- MOBILE ADAPTIVE TUNING --- */
    @media (max-width: 768px) {
        :root {
            --dash-sidebar-w: 0px;
            --dash-header-h: 60px;
        }

        .dash-sidebar {
            display: none !important;
        }

        .dash-main {
            padding: 0 20px 100px;
        }

        .dash-header {
            padding: 8px 0;
            background: transparent;
            backdrop-filter: none;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dash-title-block h1 {
            font-size: 18px;
            opacity: 0.8;
        }

        .dash-controls {
            gap: 8px;
            display: flex;
            align-items: center;
        }

        .notif-trigger {
            width: 38px;
            height: 38px;
            padding: 0;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
        }

        .dash-user {
            padding: 4px 10px 4px 6px;
            gap: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
        }

        .avatar-ring {
            inset: -2px;
            border-width: 1px;
        }

        .avatar-main {
            font-size: 11px;
            border-radius: 8px;
        }

        .u-name {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.9);
        }

        .u-role {
            font-size: 8px;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .search-pill {
            display: none;
        }

        .bento-card {
            padding: 24px;
            border-radius: 24px;
        }

        .val-main {
            font-size: 32px;
        }

        /* Mobile Bottom Nav Bar */
        .mobile-nav-bar {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            height: 70px;
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-radius: 100px;
            /* Keep existing border-radius */
        }

        .m-nav-item {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 50%;
        }

        .m-nav-item.active {
            color: var(--accent-sage);
            background: rgba(132, 148, 131, 0.1);
            /* Keep existing background */
        }

        /* --- AGRO AURA LIQUID GAUGE (V12 DYNAMIC SIDE-BY-SIDE) --- */
        .liquid-gauge-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            margin-bottom: 24px;
        }

        .liquid-gauge-container {
            width: 120px;
            height: 120px;
            position: relative;
            flex-shrink: 0;
            border-radius: 50%;
            background: #000;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), inset 0 0 30px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            transform: translateZ(0);
        }

        .liquid-gauge-container::after {
            content: '';
            position: absolute;
            top: 4%;
            left: 10%;
            width: 80%;
            height: 40%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.15), transparent);
            border-radius: 50% / 100% 100% 0 0;
            filter: blur(2px);
            z-index: 25;
            pointer-events: none;
        }

        .liquid-gauge-svg {
            width: 100%;
            height: 100%;
            position: absolute;
            inset: 0;
            z-index: 2;
            pointer-events: none;
        }

        .liquid-wave {
            fill: url(#farmGaugeGradMain);
        }

        .liquid-wave-2 {
            fill: url(#farmGaugeGradBack);
            opacity: 0.6;
        }

        .liquid-val-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .liquid-val-num {
            font-family: var(--f-grotesk) !important;
            font-size: 64px !important;
            /* Larger score */
            font-weight: 800;
            line-height: 0.8;
            color: #fff;
            text-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
            letter-spacing: -0.05em;
        }

        .liquid-val-label {
            font-family: var(--f-grotesk) !important;
            font-size: 8px !important;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--accent-sage);
            margin-top: 8px;
            opacity: 0.6;
        }

        .col-large,
        .col-medium,
        .col-small {
            grid-column: span 12 !important;
        }
    }

    .ui-gauge-lg {
        width: 140px;
        height: 140px;
    }

    .gauge-svg-lg {
        width: 140px;
        height: 140px;
    }

    @media (min-width: 769px) {
        .mobile-nav-bar {
            display: none;
        }

        /* --- PREMIUM LIQUID GAUGE DESKTOP (V12) --- */
        .liquid-gauge-wrapper {
            gap: 32px;
            margin-bottom: 32px;
        }

        .liquid-gauge-container {
            width: 160px;
            height: 160px;
        }

        .liquid-val-num {
            font-size: 92px !important;
        }

        /* Massive Desktop Score */
        .liquid-val-label {
            font-size: 11px !important;
            letter-spacing: 0.2em;
        }
    }
</style>

<div class="dashboard-wrapper">
    <div class="dash-aura">
        <div class="d-blob d-blob-1"></div>
        <div class="d-blob d-blob-2"></div>
    </div>

    <!-- SIDEBAR -->
    <aside class="dash-sidebar">
        <div class="dash-logo-small">
            <div style="width: 14px; height: 14px; background: #000; border-radius: 4px;"></div>
        </div>

        <nav class="dash-nav">
            <div class="nav-item active" title="Обзор">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </div>
            <div class="nav-item" title="Участки" onclick="location.href='/plan'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <div class="nav-item" title="Аналитика" onclick="location.href='/photo-analysis'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
            </div>
            <div class="nav-item" title="Планировщик" onclick="location.href='/planner'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="nav-item" title="Паспорт (Отчеты)" onclick="location.href='/reports'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <div class="nav-item" title="Животные" onclick="location.href='/animals'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5V21M5 12H19" stroke-linecap="round"></path>
                </svg>
            </div>
        </nav>

        <div class="nav-item" title="Выход" style="margin-top: auto;" onclick="handleLogout()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <main class="dash-main">
        <header class="dash-header">
            <div class="dash-title-block">
                <h1>Панель управления</h1>
            </div>

            <div class="dash-controls">
                <div class="notif-trigger" onclick="toggleNotifPanel()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <div class="notif-badge" id="unreadCount">2</div>
                </div>

                <div class="dash-user">
                    <div class="user-avatar">
                        <div class="avatar-ring"></div>
                        <div class="avatar-main">FA</div>
                        <div class="status-dot"></div>
                    </div>
                    <div class="user-info">
                        <div class="u-name">Фермер</div>
                        <div class="u-role">Premium Plan</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="bento-grid">
            <!-- Карта 1: Farm Health Score (Liquid Gauge) -->
            <div class="bento-card col-medium row-large" id="healthScoreWidget">
                <div class="telemetry-scanline"></div>
                <div class="hologram-overlay"></div>
                <div class="card-label">
                    <div class="telemetry-dot"></div>
                    Состояние фермы.status
                </div>

                <div class="liquid-gauge-wrapper">
                    <div class="liquid-gauge-container">
                        <svg class="liquid-gauge-svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
                            <defs>
                                <clipPath id="farmCircleClip">
                                    <circle cx="50" cy="50" r="50" />
                                </clipPath>
                                <linearGradient id="farmGaugeGradMain" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#10b981" />
                                    <stop offset="100%" stop-color="#064e3b" />
                                </linearGradient>
                                <linearGradient id="farmGaugeGradBack" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#10b981" stop-opacity="0.6" />
                                    <stop offset="100%" stop-color="#064e3b" stop-opacity="0.4" />
                                </linearGradient>

                                <path id="farmWaveBase" d="M 0 50 Q 25 40 50 50 T 100 50 V 200 H 0 Z" />
                                <linearGradient id="glassTopGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#fff" />
                                    <stop offset="100%" stop-color="#fff" stop-opacity="0" />
                                </linearGradient>
                            </defs>

                            <g clip-path="url(#farmCircleClip)">
                                <!-- Dynamic Liquid Level Group -->
                                <g transform="translate(0, 15)">
                                    <g>
                                        <animateTransform attributeName="transform" type="translate" from="-100 0"
                                            to="100 0" dur="7s" repeatCount="indefinite" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradBack)" opacity="0.3"
                                            x="-100" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradBack)" opacity="0.3" x="0" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradBack)" opacity="0.3"
                                            x="100" />
                                    </g>
                                    <g>
                                        <animateTransform attributeName="transform" type="translate" from="100 0"
                                            to="-100 0" dur="5s" repeatCount="indefinite" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradBack)" opacity="0.6"
                                            x="-100" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradBack)" opacity="0.6" x="0" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradBack)" opacity="0.6"
                                            x="100" />
                                    </g>
                                    <g>
                                        <animateTransform attributeName="transform" type="translate" from="-100 0"
                                            to="100 0" dur="3s" repeatCount="indefinite" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradMain)" x="-100" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradMain)" x="0" />
                                        <use href="#farmWaveBase" fill="url(#farmGaugeGradMain)" x="100" />
                                    </g>
                                </g>
                            </g>

                            <!-- Glass Overlay Elements -->
                            <g clip-path="url(#farmCircleClip)">
                                <rect x="0" y="0" width="100" height="40" fill="url(#glassTopGrad)" opacity="0.4" />
                            </g>
                        </svg>
                    </div>

                    <div class="liquid-val-side">
                        <div class="liquid-val-num" id="healthScoreVal">94%</div>
                        <div class="liquid-val-label">Индекс Здоровья</div>
                    </div>
                </div>

                <div style="margin-top: 32px;">
                    <p style="font-size: 13px; color: rgba(255,255,255,0.4); line-height: 1.6;" id="healthStatusDesc">
                        Оптимальное состояние. Индексы вегетации (NDVI) максимальны, здоровье поголовья и микроклимат фермы в абсолютной норме.
                    </p>
                </div>
            </div>

            <!-- Карта 2: Динамика (Crops Health) -->
            <div class="bento-card col-large" id="analyticsWidget">
                <div class="card-label">Развитие культур.analytics</div>
                <div class="ekg-container" id="ekgWrapper">
                    <svg viewBox="0 0 400 60" preserveAspectRatio="none" style="width: 100%; height: 100%;">
                        <path id="ekgPath" d="M0,30 L50,30 L60,10 L70,50 L80,30 L150,30 L160,55 L170,5 L180,30 L400,30"
                            fill="none" stroke="var(--accent-sage)" stroke-width="1.5"></path>
                    </svg>
                </div>
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-end; height: 200px; position: relative; z-index: 1;">
                    <div class="chart-placeholder" id="cropChart">
                        <!-- Bars injected by JS or hardcoded for layout -->
                        <div class="chart-bar" style="height: 40%;"></div>
                        <div class="chart-bar" style="height: 55%;"></div>
                        <div class="chart-bar active" style="height: 85%;"></div>
                        <div class="chart-bar" style="height: 60%;"></div>
                        <div class="chart-bar" style="height: 70%;"></div>
                        <div class="chart-bar" style="height: 45%;"></div>
                        <div class="chart-bar" style="height: 90%;"></div>
                        <div class="chart-bar" style="height: 65%;"></div>
                    </div>
                </div>
            </div>

            <!-- Карта 3: Хозяйства (Quick Stats) -->
            <div class="bento-card col-large" id="farmsWidget">
                <div class="card-label" style="justify-content: space-between;">
                    <span>Ваши объекты.data</span>
                    <span style="font-size: 14px; color: #fff; text-transform: none;">Всего: 3</span>
                </div>
                <div class="stat-list" id="farmsList">
                    <!-- Loaded via API -->
                    <div style="color: rgba(255,255,255,0.2);">Загрузка объектов системы...</div>
                </div>
            </div>

            <!-- Карта 4: Погода (Tiny widget) -->
            <div class="bento-card col-medium"
                style="background: linear-gradient(135deg, rgba(180, 161, 138, 0.08), transparent);">
                <div class="card-label">Метеосводка.node_01</div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 32px; font-weight: 800;">+26°C</div>
                        <div style="font-size: 13px; color: rgba(255,255,255,0.4); margin-top: 4px;">Влажность 43% • Ветер 3 м/с</div>
                    </div>
                    <div
                        style="width: 48px; height: 48px; background: rgba(255,255,255,0.03); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--accent-gold)"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Карта 5: AI Ассистент (Large message) -->
            <div class="bento-card col-large ai-glow"
                style="display: flex; align-items: center; gap: 32px; border-color: rgba(132, 148, 131, 0.4);">
                <div
                    style="width: 64px; height: 64px; border-radius: 50%; background: var(--accent-sage); flex-shrink: 0; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 30px rgba(132, 148, 131, 0.3); position: relative;">
                    <div
                        style="position: absolute; inset: -4px; border: 1px solid var(--accent-sage); border-radius: 50%; opacity: 0.3; animation: spin 20s linear infinite;">
                    </div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5">
                        <path d="M12 2a10 10 0 1 0 10 10H12V2z"></path>
                        <path d="M12 12L2.7 7.3"></path>
                    </svg>
                </div>
                <div>
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 22px; margin-bottom: 8px;">Ассистент
                        рекомендует</h3>
                    <p style="font-size: 15px; color: rgba(255,255,255,0.5); line-height: 1.6;">Критическое окно для внесения азотных удобрений на секторе «ЮГ-14» — ближайшие 6 часов перед ожидаемыми осадками. Вероятность усвояемости — 98%.</p>
                </div>
            </div>

            <!-- Карта 6: Анализ животных (Animal Analysis Hub) -->
            <div class="bento-card col-large ai-glow" id="animalAnalysisWidget"
                style="border-color: rgba(180, 161, 138, 0.3);">
                <div class="card-label" style="color: var(--accent-gold);">
                    <div
                        style="width:6px;height:6px;background:var(--accent-gold);border-radius:50%;box-shadow:0 0 10px var(--accent-gold);animation:pulse-telemetry 2s ease-in-out infinite;">
                    </div>
                    Анализ животных.AI
                </div>
                <div
                    style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
                    <div>
                        <div style="font-size: 32px; font-weight: 800; color: var(--accent-gold);" id="animalCaseCount">
                            0</div>
                        <div style="font-size: 12px; opacity: 0.4; margin-top: 4px;">Случаев проанализировано</div>
                    </div>
                    <a href="/animals"
                        style="text-decoration: none; background: var(--accent-gold); color: #000; font-weight: 700; font-size: 13px; padding: 10px 20px; border-radius: 12px; display: flex; align-items: center; gap: 8px; transition: 0.2s;"
                        onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Новый анализ
                    </a>
                </div>
                <div id="animalCasesList" class="stat-list">
                    <!-- Загружается через JS -->
                    <div style="text-align:center; padding: 40px 0;">
                        <div style="font-size: 24px; margin-bottom: 12px; opacity: 0.3;">🐾🐾</div>
                        <div style="color: rgba(255,255,255,0.2); font-size: 13px;">Нет анализов животных</div>
                        <a href="/animals"
                            style="display: inline-block; margin-top: 16px; padding: 10px 24px; background: rgba(180,161,138,0.1); border: 1px solid rgba(180,161,138,0.2); color: #fff; border-radius: 12px; font-size: 13px; font-weight: 600; text-decoration: none;">Начать
                            анализ</a>
                    </div>
                </div>
            </div>

            <!-- Карта 7: Последние события (Old Activity) -->
            <div class="bento-card col-medium" id="activityWidget">
                <div class="card-label">Активность.stream</div>
                <div id="activityScroll" style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="color: rgba(255,255,255,0.2);">Синхронизация потока событий...</div>
                </div>
            </div>

            <!-- Карта 8: Центр решений по планам -->
            <div class="bento-card col-large" id="planOpsWidget"
                style="border-color: rgba(132, 148, 131, 0.25); background: linear-gradient(135deg, rgba(132,148,131,0.08), rgba(20,20,20,0.2));">
                <div class="card-label" style="justify-content: space-between;">
                    <span>План-центр.ops</span>
                    <a href="/plan" style="text-decoration:none; color: var(--accent-sage); font-size: 12px; font-weight: 700;">Открыть Smart Plan</a>
                </div>
                <div id="planOpsContent" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div style="color: rgba(255,255,255,0.25); grid-column: 1/-1;">Анализируем активные планы...</div>
                </div>
            </div>
        </div>
    </main>

    <!-- NOTIFICATION PANEL -->
    <div id="notifPanel" class="notif-panel">
        <div class="notif-header">
            <h2 class="notif-title">Уведомления</h2>
            <div class="notif-close" onclick="toggleNotifPanel()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>
        </div>
        <div id="notifList" class="notif-list">
            <!-- Alerts dynamically added here -->
            <div class="notif-item" style="animation-delay: 0.1s;">
                <div class="notif-icon" style="background: rgba(180, 161, 138, 0.1); color: var(--accent-gold);">💬
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 700; margin-bottom: 4px;">Новая диагностика</div>
                    <div style="font-size: 12px; opacity: 0.6; line-height: 1.4;">Ветеринар "Иванов А." подтвердил схему
                        восстановления для поголовья.</div>
                    <div style="font-size: 10px; opacity: 0.3; margin-top: 8px;">2 минуты назад</div>
                </div>
            </div>
            <div class="notif-item" style="animation-delay: 0.2s;">
                <div class="notif-icon" style="background: rgba(250, 82, 82, 0.1); color: #fa5252;">⚠️</div>
                <div>
                    <div style="font-size: 14px; font-weight: 700; margin-bottom: 4px; color: #fa5252;">Уровень заражения</div>
                    <div style="font-size: 12px; opacity: 0.6; line-height: 1.4;">Система DroneScan обнаружила бурую
                        ржавчину (5% охвата на участке Д-12).</div>
                    <div style="font-size: 10px; opacity: 0.3; margin-top: 8px;">1 час назад</div>
                </div>
            </div>
        </div>
    </div>

    <!-- MOBILE BOTTOM NAV BAR -->
    <div class="mobile-nav-bar">
        <a href="/dashboard" class="m-nav-item active">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
        </a>
        <a href="/plan" class="m-nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
        </a>
        <a href="/photo-analysis" class="m-nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                <circle cx="12" cy="13" r="4"></circle>
            </svg>
        </a>
        <a href="/animals" class="m-nav-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 5V21M5 12H19" stroke-linecap="round"></path>
            </svg>
        </a>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        loadDashboardData();
        initAnimations();
    });

    function initAnimations() {
        if (typeof gsap !== 'undefined') {
            const tl = gsap.timeline({ defaults: { ease: "expo.out" } });

            tl.from(".dash-sidebar", { x: -80, duration: 1.2 }, 0)
                .from(".dash-header", { y: -20, opacity: 0, duration: 1 }, 0.2)
                .from(".bento-card", {
                    opacity: 0,
                    y: 40,
                    scale: 0.95,
                    duration: 1,
                    stagger: 0.08,
                    clearProps: "all"
                }, 0.3);

            // Gauge animation
            gsap.from("#dashGaugeFill", {
                strokeDashoffset: 282.6,
                duration: 2,
                delay: 1,
                ease: "power2.out"
            });

            // Bars pulse
            gsap.to(".chart-bar", {
                height: (i, el) => {
                    const h = parseInt(el.style.height);
                    return (h + (Math.random() * 10 - 5)) + "%";
                },
                duration: 2,
                repeat: -1,
                yoyo: true,
                stagger: 0.1,
                ease: "sine.inOut"
            });

            // EKG Beat
            gsap.fromTo("#ekgPath", {
                drawSVG: "0%"
            }, {
                drawSVG: "100%",
                duration: 2,
                repeat: -1,
                ease: "none"
            });
            // Note: Since I don't have drawSVG plugin by default, I'll use dashoffset fallback
            gsap.set("#ekgPath", { strokeDasharray: 1000, strokeDashoffset: 1000 });
            gsap.to("#ekgPath", { strokeDashoffset: 0, duration: 3, repeat: -1, ease: "linear" });

            // Aura move
            gsap.to(".d-blob-1", { x: "10%", y: "5%", duration: 15, repeat: -1, yoyo: true, ease: "sine.inOut" });
            gsap.to(".d-blob-2", { x: "-5%", y: "-10%", duration: 12, repeat: -1, yoyo: true, ease: "sine.inOut" });
        }
    }

    function loadDashboardData() {
        loadFarms();
        loadActivity();
        loadAnimalCases();
        loadPlanOps();
        initNotifPanel();
        initHealthScore();
    }

    function initHealthScore() {
        // Calculation logic could be based on real data
        const score = 94; // Target score
        updateLiquidGauge(score);
    }

    function updateLiquidGauge(score) {
        const liquidGroup = document.getElementById('liquidGroup');
        const scoreVal = document.getElementById('healthScoreVal');
        const stop1 = document.querySelector('#liquidGradMain stop:first-child');
        const stop2 = document.querySelector('#liquidGradMain stop:last-child');
        const stopBack1 = document.querySelector('#liquidGradBack stop:first-child');
        const stopBack2 = document.querySelector('#liquidGradBack stop:last-child');

        const targetY = 100 - score;

        gsap.to(liquidGroup, {
            attr: { transform: `translate(0, ${targetY})` },
            duration: 3,
            ease: "back.out(1.2)"
        });

        // Update colors based on score
        let colorMain = "#10b981"; // Emerald
        let colorDeep = "#064e3b";

        if (score < 40) {
            colorMain = "#fa5252"; // Red
            colorDeep = "#821c1c";
        } else if (score < 75) {
            colorMain = "#b4a18a"; // Bronze
            colorDeep = "#5c4d3c";
        }

        // Smooth color transition for SVG gradients
        gsap.to(stop1, { attr: { "stop-color": colorMain }, duration: 2 });
        gsap.to(stop2, { attr: { "stop-color": colorDeep }, duration: 2 });
        gsap.to(stopBack1, { attr: { "stop-color": colorMain }, duration: 2 });
        gsap.to(stopBack2, { attr: { "stop-color": colorDeep }, duration: 2 });

        let obj = { val: 0 };
        gsap.to(obj, {
            val: score,
            duration: 2.5,
            onUpdate: () => {
                scoreVal.innerText = Math.round(obj.val) + "%";
            }
        });
    }

    function initNotifPanel() {
        // Optional: logic to fetch real notifications can go here
    }

    function toggleNotifPanel() {
        const panel = document.getElementById('notifPanel');
        panel.classList.toggle('active');
        if (panel.classList.contains('active')) {
            document.getElementById('unreadCount').style.display = 'none';
        }
    }

    function loadAnimalCases() {
        // PROFESSIONAL MOCKED DATA
        const dummyCases = [
            { species: 'cattle', created_at: new Date(Date.now() - 3600*1000), triage_level: 'critical', desc: 'Острая пневмония (Сектор А-1)' },
            { species: 'horse', created_at: new Date(Date.now() - 86400*1000), triage_level: 'medium', desc: 'Охромолость левой задней' },
            { species: 'sheep', created_at: new Date(Date.now() - 172800*1000), triage_level: 'low', desc: 'Плановая вакцинация' }
        ];

        const list = document.getElementById('animalCasesList');
        const countEl = document.getElementById('animalCaseCount');

        if (countEl) countEl.textContent = "14"; // Mocked count

        list.innerHTML = dummyCases.map(c => {
            const triageColors = {
                'critical': '#fa5252',
                'medium': '#fd7e14',
                'low': 'var(--accent-sage)'
            };
            const color = triageColors[c.triage_level] || 'var(--accent-sage)';
            const levels = {'critical': 'КРИТИЧНЫЙ', 'medium': 'СРЕДНИЙ', 'low': 'ПЛАНОВЫЙ'};
            
            return `
                <div class="stat-item" style="cursor: pointer; transition: background 0.3s; padding: 12px; border-radius: 12px;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'" onclick="location.href='/animals'">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 38px; height: 38px; background: rgba(180,161,138,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px;">${getSpeciesEmoji(c.species)}</div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600;">${getSpeciesName(c.species)}</div>
                            <div style="font-size: 11px; opacity: 0.6; margin-top:2px;">${c.desc}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 7px; height: 7px; border-radius: 50%; background: ${color}; box-shadow: 0 0 10px ${color}"></div>
                        <span style="font-size: 11px; color: ${color}; font-weight: 800; letter-spacing: 0.05em;">${levels[c.triage_level] || 'НИЗКИЙ'}</span>
                    </div>
                </div>
            `;
        }).join('');
    }

    function getSpeciesName(s) {
        const m = { 'cattle': 'КРС', 'sheep': 'Овцы', 'goat': 'Козы', 'poultry': 'Птица', 'pig': 'Свиньи', 'horse': 'Лошади' };
        return m[s] || s;
    }

    function getSpeciesEmoji(s) {
        const m = { 'cattle': '🐄', 'sheep': '🐑', 'goat': '🐐', 'poultry': '🐔', 'pig': '🐷', 'horse': '🐴' };
        return m[s] || '🐾';
    }

    function loadFarms() {
        const dummyFarms = [
            { name: 'Агрокомплекс «Золотой Колос»', location: 'Южная долина', area: 4500 },
            { name: 'Животноводство «Степные Зори»', location: 'Северный округ', area: 1200 },
            { name: 'Эко-сады «Рассвет»', location: 'Пригорье', area: 850 }
        ];

        const list = document.getElementById('farmsList');
        list.innerHTML = dummyFarms.map(f => `
            <div class="stat-item" style="padding: 12px 0;">
                <div class="stat-info">
                    <span class="stat-name" style="font-size:14px; font-weight:600;">${f.name}</span>
                    <span style="font-size: 11px; opacity: 0.5; margin-top:4px;">📍 ${f.location}</span>
                </div>
                <div style="text-align: right;">
                    <span class="stat-val" style="font-size: 16px; color: var(--accent-gold); font-weight: 800;">${f.area}</span>
                    <span style="font-size: 10px; opacity: 0.5; margin-left:2px;">га</span>
                </div>
            </div>
        `).join('');
    }

    function loadActivity() {
        const dummyActivities = [
            { id: 1, text: 'Обновлена спутниковая карта (NDVI) для участка В-12.', date: new Date(Date.now() - 3600*1000), status: 'completed' },
            { id: 2, text: 'Критический дефицит азота выявлен на секторе А-04.', date: new Date(Date.now() - 7200*1000), status: 'warning' },
            { id: 3, text: 'Прогноз урожайности пересчитан: ожидается рост на +4%.', date: new Date(Date.now() - 86400*1000), status: 'completed' },
            { id: 4, text: 'Завершена вакцинация 24 голов (КРС).', date: new Date(Date.now() - 172800*1000), status: 'completed' }
        ];

        const list = document.getElementById('activityScroll');
        list.innerHTML = dummyActivities.map(a => `
            <div style="display: flex; align-items: flex-start; gap: 12px; padding: 14px; background: rgba(255,255,255,0.02); border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); transition: transform 0.3s, background 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.04)'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.transform='translateX(0)';">
                <div style="margin-top: 4px; width: 8px; height: 8px; background: ${a.status === 'completed' ? 'var(--accent-sage)' : '#fa5252'}; border-radius: 50%; box-shadow: 0 0 10px ${a.status === 'completed' ? 'var(--accent-sage)' : '#fa5252'};"></div>
                <div style="flex: 1;">
                    <div style="font-size: 13px; font-weight: 500; line-height: 1.4; color: rgba(255,255,255,0.9);">${a.text}</div>
                    <div style="font-size: 10px; opacity: 0.4; margin-top:6px; font-family: var(--f-grotesk); letter-spacing: 0.05em;">${a.date.toLocaleString('ru')}</div>
                </div>
            </div>
        `).join('');
    }

    function loadPlanOps() {
        const box = document.getElementById('planOpsContent');
        if (!box) return;

        const latest = {
            crop: 'Озимая Пшеница (Class A)',
            region: 'Южный кластер (Сектор 4)',
            area_hectares: 1250,
            id: 'demo-123'
        };
        const criticalRisk = {
            description: 'Повышенная кислотность почвы может снизить урожайность на 12%. Ожидаемая влажность < 20%.',
            level: 'critical'
        };
        const nextTasks = [
            { title: 'Внесение фосфорных удобрений', due_date: new Date(Date.now() + 86400*1000*2) },
            { title: 'Облет дроном (мультиспектральная)', due_date: new Date(Date.now() + 86400*1000*5) },
            { title: 'Забор проб грунта (5 точек)', due_date: null }
        ];
        const now = new Date();

        box.innerHTML = `
            <div style="padding: 16px; border-radius: 16px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 10px; opacity: 0.6; text-transform: uppercase; letter-spacing: 0.1em; font-weight:800; color: var(--accent-gold);">Флагманский План</div>
                <div style="margin-top: 8px; font-size: 18px; font-weight: 800; font-family: 'Playfair Display', serif;">${latest.crop}</div>
                <div style="margin-top: 6px; font-size: 12px; opacity: 0.6;">${latest.region} • <span style="color:#fff;font-weight:700;">${latest.area_hectares} га</span></div>
                <a href="/plan" style="display:inline-block; margin-top: 16px; font-size: 12px; color: var(--accent-sage); text-decoration: none; font-weight: 700; background: rgba(132,148,131,0.1); padding: 8px 16px; border-radius: 8px; transition: 0.2s;" onmouseover="this.style.background='rgba(132,148,131,0.2)'" onmouseout="this.style.background='rgba(132,148,131,0.1)'">Smart Plan →</a>
            </div>
            <div style="padding: 16px; border-radius: 16px; background: rgba(250,82,82,0.05); border: 1px solid rgba(250,82,82,0.15);">
                <div style="font-size: 10px; opacity: 0.8; color:#fa5252; font-weight:800; text-transform: uppercase; letter-spacing: 0.1em;">Критичный фокус</div>
                <div style="margin-top: 10px; font-size: 13px; line-height: 1.5; color:rgba(255,255,255,0.9);">
                    ${criticalRisk.description}
                </div>
                <div style="margin-top: 12px; font-size: 11px; opacity: 0.9; color: #fa5252; font-weight: 800; display:flex; align-items:center; gap:6px;">
                    <div style="width:6px;height:6px;background:#fa5252;border-radius:50%;box-shadow:0 0 10px #fa5252;"></div>
                    ${criticalRisk.level.toUpperCase()}
                </div>
            </div>
            <div style="grid-column:1/-1; padding: 16px; border-radius: 16px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06);">
                <div style="font-size: 12px; opacity: 0.6; margin-bottom: 12px; font-weight: 600;">Ближайшие задачи AI-планировщика</div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                ${nextTasks.map(t => {
                    let daysText = 'без даты';
                    if (t.due_date) {
                        const days = Math.round((t.due_date - now) / 86400000);
                        daysText = days >= 0 ? (days === 0 ? 'Сегодня' : 'через ' + days + ' дн.') : Math.abs(days) + ' дн. просрочено';
                    }
                    const badgeBg = (t.due_date && Math.round((t.due_date - now) / 86400000) <= 2) ? 'rgba(16,185,129,0.15)' : 'rgba(255,255,255,0.05)';
                    const badgeColor = (t.due_date && Math.round((t.due_date - now) / 86400000) <= 2) ? '#10b981' : 'rgba(255,255,255,0.6)';
                    
                    return `
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; padding:12px; border-radius: 12px; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.03);">
                            <div style="font-size: 13px; font-weight: 500;">${t.title}</div>
                            <div style="font-size: 10px; font-weight: 800; padding: 4px 8px; border-radius: 6px; background: ${badgeBg}; color: ${badgeColor}; white-space: nowrap;">${daysText}</div>
                        </div>
                    `;
                }).join('')}
                </div>
            </div>
        `;
    }

    function handleLogout() {
        fetch('/api/auth/logout', { method: 'POST' })
            .then(() => window.location.href = '/login');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>