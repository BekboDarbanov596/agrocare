<?php
$activePage = 'plan';
$pageHeaderTitle = 'Smart Plan — План участка';
include __DIR__ . '/layouts/sidebar.php';
?>

<div class="plan-page">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;500;600;700&display=swap');

        .nav-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            margin-bottom: 48px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 8px 16px;
            border-radius: 100px;
            position: relative;
            z-index: 10;
        }

        .nav-link-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateX(-4px);
        }

        :root {
            --accent: #849483;
            --accent-glow: rgba(132, 148, 131, 0.4);
            --bg-dark: #070605;
            --glass: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-secondary: rgba(255, 255, 255, 0.5);
            color-scheme: dark;
        }

        body {
            background: #070605;
            color: #fff;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .dash-aura {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .d-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.1;
        }

        .d-blob-1 {
            width: 60vw;
            height: 60vw;
            background: #b4a18a;
            top: -10%;
            left: -10%;
        }

        .d-blob-2 {
            width: 50vw;
            height: 50vw;
            background: #849483;
            bottom: -10%;
            right: -5%;
        }

        .card {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.07) !important;
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            color: #fff;
            position: relative;
            z-index: 10;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.7) !important;
            margin-bottom: 8px;
            display: block;
            font-weight: 500;
        }

        .form-input,
        .form-select,
        .form-control {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-radius: 14px !important;
            padding: 14px 18px !important;
            transition: all 0.3s !important;
            outline: none !important;
            color-scheme: dark;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--accent) !important;
            background: rgba(255, 255, 255, 0.05) !important;
        }

        .form-select option {
            background-color: #1a1c18;
            color: #fff;
        }

        /* Step Indicator */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            z-index: 10;
            border-bottom: 1px solid var(--glass-border);
            padding-bottom: 24px;
        }

        .step-item {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: 700;
            border: 1px solid var(--glass-border);
            transition: all 0.3s;
        }

        .step-item.active .step-number {
            background: var(--accent);
            color: #000;
            box-shadow: 0 0 15px var(--accent-glow);
            border-color: var(--accent);
        }

        /* --- КАЧЕСТВЕННАЯ АДАПТИВКА PLAN --- */
        @media (max-width: 1200px) {
            .split-layout { grid-template-columns: 400px 1fr !important; gap: 24px !important; }
            .plan-page {
                padding: 32px 24px !important;
            }

            .plan-page .card {
                padding: 32px 28px;
                border-radius: 22px;
            }

            .plan-page h1 {
                font-size: 40px !important;
            }

            .plan-page .form-step h2 {
                font-size: 24px !important;
                margin-bottom: 28px !important;
            }

            .plan-page .form-step>div[style*="grid-template-columns"] {
                gap: 24px !important;
            }
        }

        @media (max-width: 992px) {
            .split-layout { grid-template-columns: 1fr !important; gap: 32px !important; }
            .split-layout > div { position: relative !important; top: auto !important; }
            .plan-page {
                padding: 28px 20px !important;
            }

            .plan-page .card {
                padding: 28px 22px;
                border-radius: 20px;
            }

            .plan-page h1 {
                font-size: 34px !important;
            }

            .plan-page .form-step h2 {
                font-size: 22px !important;
                margin-bottom: 24px !important;
            }

            .plan-page .form-step>div[style*="grid-template-columns: 1fr 1fr"],
            .plan-page .form-step>div[style*="grid-template-columns: 1fr 1fr;"] {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }

            .plan-page .form-step>div[style*="grid-template-columns: repeat(3, 1fr)"] {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }

            .plan-page .form-step>div[style*="grid-template-columns: repeat(4, 1fr)"] {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
            }

            .plan-page .step-indicator {
                margin-bottom: 28px;
                padding-bottom: 20px;
            }

            .plan-page .step-label {
                font-size: 11px;
            }

            .plan-page .warning-box,
            .plan-page .history-box {
                padding: 18px !important;
            }

            .plan-page #mapModal {
                padding: 24px 16px !important;
            }

            .plan-page #mapModal .card {
                max-width: 100%;
                border-radius: 16px;
            }

            .plan-page #plansList {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)) !important;
                gap: 20px !important;
            }
        }

        @media (max-width: 768px) {
            .split-layout { gap: 24px !important; }
            .plan-page {
                padding: 22px 16px !important;
            }

            .plan-page>div[style*="margin-bottom: 32px"] {
                margin-bottom: 24px !important;
            }

            .plan-page .card {
                padding: 24px 18px;
                border-radius: 18px;
            }

            .plan-page h1 {
                font-size: 28px !important;
            }

            .plan-page h1+p {
                font-size: 16px !important;
                max-width: 100% !important;
            }

            .plan-page .form-step h2 {
                font-size: 20px !important;
                margin-bottom: 22px !important;
            }

            .plan-page .form-step h3 {
                font-size: 18px !important;
                margin-bottom: 18px !important;
            }

            .plan-page .form-step>div[style*="grid-template-columns: repeat(4, 1fr)"] {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }

            .plan-page .form-step>div[style*="grid-template-columns: repeat(2, 1fr)"] {
                grid-template-columns: 1fr !important;
            }

            .plan-page .step-label {
                display: none;
            }

            .plan-page .step-indicator {
                margin-bottom: 22px;
                padding-bottom: 16px;
                gap: 4px;
            }

            .plan-page .step-number {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .plan-page .form-group {
                margin-bottom: 18px !important;
            }

            .plan-page .form-step>div[style*="margin-top: 40px"][style*="display: flex"],
            .plan-page .form-step>div[style*="display: flex"][style*="justify-content: flex-end"],
            .plan-page .form-step>div[style*="display: flex"][style*="justify-content: space-between"] {
                flex-wrap: wrap;
                gap: 10px !important;
                margin-top: 28px !important;
            }

            .plan-page .form-step>div[style*="margin-top: 40px"] button,
            .plan-page .form-step>div[style*="display: flex"] button {
                min-height: 44px;
                padding: 12px 20px !important;
                flex: 1;
                min-width: 120px;
            }

            .plan-page .form-input,
            .plan-page .form-select,
            .plan-page .form-control {
                min-height: 44px;
                padding: 12px 16px !important;
            }

            .plan-page #openMapBtn,
            .plan-page a.btn.btn-outline {
                min-height: 44px;
                padding: 12px 18px !important;
            }

            .plan-page #mapModal {
                padding: 16px 12px !important;
                align-items: stretch;
            }

            .plan-page #mapModal .card {
                padding: 0;
                border-radius: 14px;
                max-height: calc(100vh - 32px);
            }

            .plan-page #mapModal h2 {
                font-size: 18px !important;
            }

            .plan-page #mapContainer {
                min-height: 280px !important;
            }

            .plan-page #mapModal>.card>div[style*="padding: 24px"] {
                padding: 16px !important;
            }

            .plan-page #aiAnalysisResult {
                margin-top: 28px !important;
                padding: 20px !important;
            }

            .plan-page #aiAnalysisResult h2 {
                font-size: 20px !important;
            }

            .plan-page #aiAnalysisResult>div:first-of-type {
                flex-wrap: wrap;
                gap: 12px;
            }

            .plan-page #aiAnalysisResult #openChatBtn {
                width: 100%;
                justify-content: center;
            }

            .plan-page [style*="margin-top: 60px"] h2 {
                font-size: 22px !important;
                margin-bottom: 24px !important;
            }

            .plan-page #plansList {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
        }

        @media (max-width: 480px) {
            .plan-page {
                padding: 16px 12px !important;
            }

            .plan-page>div[style*="margin-bottom: 32px"] {
                margin-bottom: 20px !important;
            }

            .plan-page .card {
                padding: 20px 14px;
                border-radius: 16px;
            }

            .plan-page h1 {
                font-size: 24px !important;
            }

            .plan-page h1+p {
                font-size: 14px !important;
            }

            .plan-page .form-step h2 {
                font-size: 18px !important;
                margin-bottom: 18px !important;
            }

            .plan-page .form-step h3 {
                font-size: 16px !important;
                margin-bottom: 14px !important;
            }

            .plan-page .form-step>div[style*="grid-template-columns: repeat(4, 1fr)"] {
                grid-template-columns: 1fr !important;
            }

            .plan-page .form-step>div[style*="margin-top: 40px"][style*="padding-top: 32px"],
            .plan-page .form-step>div[style*="padding-top: 32px"] {
                margin-top: 24px !important;
                padding-top: 20px !important;
            }

            .plan-page .step-indicator {
                margin-bottom: 18px;
                padding-bottom: 14px;
            }

            .plan-page .step-number {
                width: 28px;
                height: 28px;
                font-size: 11px;
            }

            .plan-page .warning-box {
                padding: 14px !important;
            }

            .plan-page .warning-box strong {
                font-size: 16px !important;
            }

            .plan-page .history-box {
                padding: 14px !important;
            }

            .plan-page .form-step>div[style*="display: flex"] button {
                width: 100%;
                flex: none;
            }

            .plan-page #mapModal {
                padding: 12px 8px !important;
            }

            .plan-page #mapModal>.card>div:first-of-type {
                padding: 14px 12px !important;
            }

            .plan-page #mapModal h2 {
                font-size: 16px !important;
            }

            .plan-page #mapContainer {
                min-height: 220px !important;
            }

            .plan-page #mapModal>.card>div:last-of-type {
                padding: 14px 12px !important;
                flex-wrap: wrap;
            }

            .plan-page #mapModal .btn {
                min-height: 44px;
                flex: 1;
                min-width: 0;
            }

            .plan-page #aiAnalysisResult {
                padding: 16px !important;
            }

            .plan-page #aiAnalysisResult h2 {
                font-size: 18px !important;
            }

            .plan-page #aiResultContent {
                font-size: 15px !important;
            }

            .plan-page [style*="margin-top: 60px"] {
                margin-top: 40px !important;
            }

            .plan-page [style*="margin-top: 60px"] h2 {
                font-size: 20px !important;
                margin-bottom: 20px !important;
            }

            .plan-page .form-group label[style*="display: flex"] {
                padding: 12px 10px !important;
            }

            .plan-page .form-group label[style*="display: flex"] input[type="checkbox"] {
                min-width: 22px;
                min-height: 22px;
            }

            .plan-page .form-select[id="monoculture"] {
                max-width: 100% !important;
            }

            .plan-page #cropSuggestions {
                max-height: 200px;
            }
        }

        .step-label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s;
        }

        .step-item.active .step-label {
            color: #fff;
            font-weight: 600;
        }

        /* Suggestions Dropdown (The fix!) */
        #cropSuggestions {
            background: #1a1a1a !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 12px;
            backdrop-filter: blur(20px);
            color: #fff !important;
        }

        .crop-suggestion:hover {
            background: rgba(132, 148, 131, 0.2) !important;
        }

        /* Notifications & Boxes */
        .warning-box {
            padding: 20px;
            background: rgba(255, 179, 0, 0.1);
            border: 1px solid rgba(255, 179, 0, 0.3);
            border-radius: 16px;
            margin-bottom: 24px;
            color: #ffb300;
        }

        .history-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            transition: all 0.3s ease;
        }

        .history-box:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(132, 148, 131, 0.3);
        }

        /* Leaflet Dark Theme Overrides */
        .leaflet-container {
            background: #0e120d !important;
            border-radius: 0 0 24px 24px;
            font-family: 'Inter', sans-serif !important;
        }

        .leaflet-bar {
            border: none !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
        }

        .leaflet-bar a {
            background: rgba(30, 35, 28, 0.8) !important;
            color: #fff !important;
            border-bottom: 1px solid var(--glass-border) !important;
            backdrop-filter: blur(10px);
        }

        .leaflet-bar a:hover {
            background: var(--accent) !important;
            color: #0e120d !important;
        }

        .leaflet-popup-content-wrapper,
        .leaflet-popup-tip {
            background: rgba(20, 25, 18, 0.9) !important;
            color: #fff !important;
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px !important;
        }

        /* Custom map overlay for cinematic look */
        #map::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle, transparent 40%, rgba(14, 18, 13, 0.4) 100%);
            pointer-events: none;
            z-index: 1000;
        }

        .btn-primary {
            background: var(--accent) !important;
            color: #000 !important;
            border: none !important;
            font-weight: 700 !important;
            border-radius: 14px !important;
            padding: 14px 28px !important;
            transition: all 0.3s !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--accent-glow);
        }

        /* Modal fixes */
        .modal-content {
            background: #0f0e0c !important;
            color: #fff !important;
            border: 1px solid var(--glass-border) !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--glass-border) !important;
        }

        .modal-footer {
            border-top: 1px solid var(--glass-border) !important;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }
    </style>

    <div style="margin-bottom: 40px; position: relative; z-index: 10;">
        <h1 style="font-size: 48px; font-weight: 800; margin-bottom: 16px; letter-spacing: -0.02em;">Smart Plan</h1>
        <p style="color: var(--text-secondary); font-size: 18px; max-width: 700px; line-height: 1.6;">Быстрое создание
            плана посева. ИИ заполнит недостающие данные на основе региональных норм.</p>
    </div>

    <div id="noFarmWarning" class="card" style="display: none; text-align: center; padding: 60px 40px;">
        <div style="font-size: 64px; margin-bottom: 24px;">🚜</div>
        <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 16px;">У вас пока нет хозяйств</h2>
        <p style="color: var(--text-secondary); font-size: 18px; margin-bottom: 32px;">Для создания плана посева сначала
            нужно добавить хотя бы одно хозяйство.</p>
        <button onclick="createFarmFirst()" class="btn btn-primary">Создать первое хозяйство</button>
    </div>

    <div class="split-layout" style="display: grid; grid-template-columns: 460px 1fr; gap: 40px; align-items: start; position: relative; z-index: 10;">
    
    <div style="display: flex; flex-direction: column; gap: 24px; position: sticky; top: 20px;">
    <div class="card" id="planCard" style="padding: 32px; border-radius: 24px; background: rgba(20,22,18,0.8) !important; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        <form id="planForm">
            <!-- WIZARD STYLES -->
            <style>
                .wizard-step-ui { position:relative; z-index:1; display:flex; flex-direction:column; align-items:center; gap:8px; cursor:pointer; }
                .ws-number { width:28px; height:28px; border-radius:50%; background:#1a1a1a; border:2px solid rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:rgba(255,255,255,0.5); transition:all 0.3s; }
                .ws-label { font-size:11px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.05em; transition:all 0.3s; }
                .wizard-step-ui.active .ws-number { background:var(--accent); border-color:var(--accent); color:#000; box-shadow:0 0 15px rgba(132,148,131,0.4); }
                .wizard-step-ui.active .ws-label { color:#fff; font-weight:700; }
                .wizard-step-ui.completed .ws-number { background:rgba(132,148,131,0.2); border-color:var(--accent); color:var(--accent); }
                .wizard-content { display:none; animation:fadeInLeft 0.3s forwards; }
                .wizard-content.active { display:block; }
                @keyframes fadeInLeft { from { opacity: 0; transform: translateX(10px); } to { opacity: 1; transform: translateX(0); } }
                
                .form-group { margin-bottom: 20px; }

                
                /* MOBILE FIXES WIZARD */
                @media (max-width: 768px) {
                    /* Wizard responsive layout */
                    .wizard-content > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; gap: 12px !important; }
                    .wizard-content > div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
                    .wizard-content .form-group > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; gap: 12px !important; }
                    
                    /* Grid Overrides for horizontal overflow */
                    #plansList { grid-template-columns: 1fr !important; gap: 16px !important; }
                    .split-layout { grid-template-columns: 1fr !important; gap: 24px !important; display: flex !important; flex-direction: column !important; }
                    .left-column { position: static !important; }
                    
                    /* Form padding tight fit */
                    .plan-page { padding: 16px 12px !important; overflow-x: hidden !important; }
                    body { overflow-x: hidden !important; }
                    #planCard { padding: 20px 16px !important; border-radius: 16px !important; }

                    /* Fix wizard step labels on mobile */
                    .wizard-progress { margin-bottom: 24px !important; }
                    .ws-label { font-size: 9px !important; line-height: 1.1; margin-top: 4px; color: rgba(255,255,255,0.7) !important; text-align: center; }
                    
                    /* Fix map header blowing out the container width */
                    .map-card > div:first-child { flex-direction: column !important; align-items: flex-start !important; gap: 16px !important; padding: 16px !important; }
                    .map-card > div:first-child > div { width: 100% !important; justify-content: space-between !important; }
                    .map-card > div:first-child button { flex: 1 !important; text-align: center !important; font-size: 11px !important; padding: 10px !important; }
                    
                    /* Map container */
                    .map-card { min-height: 380px !important; border-radius: 16px !important; margin-bottom: 32px !important; }
                    #mapContainer, #map { min-height: 380px !important; }
                    
                    /* Strategy chips typography */
                    .strategy-chip .chip-content { padding: 12px !important; gap: 12px !important; flex-direction: row !important; }
                    .strategy-chip .chip-content > span:first-child { font-size: 24px !important; }
                    .strategy-chip .chip-content strong, .strategy-chip .chip-content > div > div:first-child { font-size: 14px !important; }
                    
                    h2 { font-size: 20px !important; }
                    h3 { font-size: 18px !important; }
                    .form-group { margin-bottom: 16px !important; }
                }
                </style>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
                <h2 style="font-size: 24px; font-weight: 700; display: flex; align-items: center; gap: 12px; color: #fff; margin:0;">
                    <svg width="24" height="24" fill="none" stroke="var(--accent)" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    Smart Plan
                </h2>
                <div style="font-size:12px; padding:6px 12px; background:rgba(255,255,255,0.05); border-radius:20px; color:var(--text-secondary);">Agro AI ✨</div>
            </div>

            <!-- WIZARD PROGRESS -->
            <div class="wizard-progress" style="display:flex; justify-content:space-between; margin-bottom:32px; position:relative;">
                <div style="position:absolute; top:13px; left:10%; right:10%; height:2px; background:rgba(255,255,255,0.1); z-index:0;">
                    <div id="wizardLine" style="height:100%; width:0%; background:var(--accent); transition:width 0.4s ease-out;"></div>
                </div>
                
                <div class="wizard-step-ui active" id="ws-val-1" onclick="goToStep(1)">
                    <div class="ws-number">1</div>
                    <div class="ws-label">Участок</div>
                </div>
                <div class="wizard-step-ui" id="ws-val-2" onclick="goToStep(2)">
                    <div class="ws-number">2</div>
                    <div class="ws-label">Параметры</div>
                </div>
                <div class="wizard-step-ui" id="ws-val-3" onclick="goToStep(3)">
                    <div class="ws-number">3</div>
                    <div class="ws-label">Стратегия</div>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0;">

                <!-- STEP 1: Участок и Культура -->
                <div class="wizard-content active" id="w_step1">
                    <div class="form-group">
                        <label class="form-label">Выберите хозяйство <span style="color: #ff6b6b;">*</span></label>
                        <select class="form-select" id="farmSelect" onchange="onFarmChange(this.value)" style="width:100%;">
                            <option value="">-- Загрузка хозяйств... --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Выберите участок <span style="color: #ff6b6b;">*</span></label>
                        <div style="position: relative;">
                            <select class="form-select" id="fieldSelect" required style="width:100%;">
                                <option value="">-- Выберите участок --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Карточка автозаполнения участка -->
                    <div class="form-group" id="fieldMetaCard" style="display:none; background: rgba(255,255,255,0.02); border: 1px solid var(--glass-border); border-radius: 14px; padding: 16px; margin-bottom: 20px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                            <div>
                                <span style="display: block; font-size: 11px; opacity: 0.5; text-transform: uppercase;">Площадь</span>
                                <span id="displayArea" style="font-size: 16px; font-weight: 700; color: var(--accent);">-- га</span>
                                <input type="hidden" id="area" value="">
                            </div>
                            <div>
                                <span style="display: block; font-size: 11px; opacity: 0.5; text-transform: uppercase;">Регион</span>
                                <span id="displayRegion" style="font-size: 14px; font-weight: 700; color: #fff;">--</span>
                                <input type="hidden" id="region" value="">
                            </div>
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 12px; margin-bottom: 4px;">Город (для климата)</label>
                            <input type="text" class="form-input" id="city" placeholder="Напр: Бишкек" style="width:100%; padding:10px 14px !important; font-size:13px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Культура <span style="color: #ff6b6b;">*</span></label>
                        <div style="position: relative;">
                            <input type="text" class="form-input" id="crop" placeholder="Начните вводить..." required autocomplete="off" style="width:100%;">
                            <div id="cropSuggestions" style="display: none; position: absolute; top: 100%; left: 0; right: 0; max-height: 250px; overflow-y: auto; z-index: 1000; margin-top: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); background: #1a1a1a; border-radius: 12px; border: 1px solid var(--glass-border);"></div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 32px;">
                        <label class="form-label">Дата начала сезона <span style="color: #ff6b6b;">*</span></label>
                        <input type="date" class="form-input" id="startDate" required style="width:100%;" value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <button type="button" class="btn btn-primary" onclick="goToStep(2)" style="width:100%; padding: 16px !important; font-size: 15px !important;">
                        Далее: Параметры почвы →
                    </button>
                </div>

                <!-- STEP 2: Параметры Почвы и Затрат -->
                <div class="wizard-content" id="w_step2">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Тип почвы</label>
                            <select class="form-select" id="soilType" style="width:100%;">
                                <option value="">AI оценит</option>
                                <option value="чернозем">Чернозем</option>
                                <option value="суглинок">Суглинок</option>
                                <option value="глина">Глина</option>
                                <option value="песчаная">Песчаная</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Бюджет</label>
                            <select class="form-select" id="budget" style="width:100%;">
                                <option value="medium">Средний</option>
                                <option value="minimal">Эконом</option>
                                <option value="unlimited">Оптимальный</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Предшественник (опционально)</label>
                        <input type="text" class="form-input" id="predecessor" placeholder="Например: Люцерна, Пар" style="width:100%;">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Монокультура?</label>
                        <select class="form-select" id="monoculture" style="width:100%;">
                            <option value="нет">Нет (Севооборот)</option>
                            <option value="2 года">2 года подряд</option>
                            <option value="3+ года">Более 3 лет</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-top: 16px;">
                        <label class="form-label">Наблюдаемые проблемы в прошлом</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <?php foreach (['сорняки', 'вредители', 'болезни', 'засуха'] as $prob): ?>
                                <label class="small-check" style="display:flex; align-items:center; gap:8px; padding:10px 14px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.05); border-radius:12px; cursor:pointer;">
                                    <input type="checkbox" name="problems" value="<?php echo $prob; ?>" style="accent-color:var(--accent); width:16px; height:16px;">
                                    <span style="font-size:13px;"><?php echo ucfirst($prob); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Контейнер для истории из БД (заполняется через JS) -->
                    <div id="fieldHistory" style="display: none; margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--glass-border);">
                        <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 12px; color: var(--accent); text-transform:uppercase; letter-spacing:0.05em;">История в системе</h4>
                        <div id="historyList"></div>
                    </div>

                    <div style="display:flex; gap:12px; margin-top:32px;">
                        <button type="button" class="btn btn-outline" onclick="goToStep(1)" style="flex:1; padding: 14px !important;">← Назад</button>
                        <button type="button" class="btn btn-primary" onclick="goToStep(3)" style="flex:2; padding: 14px !important;">Стратегия →</button>
                    </div>
                </div>

                <!-- STEP 3: Стратегия AI -->
                <div class="wizard-content" id="w_step3">
                    <p style="font-size:14px; color:rgba(255,255,255,0.6); line-height:1.6; margin-bottom:24px;">
                        Выберите основную цель бизнес-плана. Agro AI подберет дозировки удобрений, график работ и учтет риски в зависимости от вашей стратегии.
                    </p>
                    
                    <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px;" id="goalSelector">
                        <label class="strategy-chip" style="cursor:pointer; display:block;">
                            <input type="radio" name="goal" value="maximum_yield" checked style="display:none;">
                            <div class="chip-content" style="padding:16px 20px; background:rgba(255,255,255,0.02); border:1px solid var(--glass-border); border-radius:16px; display:flex; align-items:center; gap:16px; transition:all 0.3s;">
                                <span style="font-size:24px;">🚀</span>
                                <div>
                                    <div style="font-weight:700; font-size:15px; color:#fff;">Максимальная урожайность</div>
                                    <div style="font-size:13px; color:rgba(255,255,255,0.5); margin-top:4px;">Фокус на интенсивные подкормки и лучшие СЗР</div>
                                </div>
                            </div>
                        </label>
                        <label class="strategy-chip" style="cursor:pointer; display:block;">
                            <input type="radio" name="goal" value="balanced" style="display:none;">
                            <div class="chip-content" style="padding:16px 20px; background:rgba(255,255,255,0.02); border:1px solid var(--glass-border); border-radius:16px; display:flex; align-items:center; gap:16px; transition:all 0.3s;">
                                <span style="font-size:24px;">⚖️</span>
                                <div>
                                    <div style="font-weight:700; font-size:15px; color:#fff;">Сбалансированная</div>
                                    <div style="font-size:13px; color:rgba(255,255,255,0.5); margin-top:4px;">Оптимальное соотношение затрат и прибыли</div>
                                </div>
                            </div>
                        </label>
                        <label class="strategy-chip" style="cursor:pointer; display:block;">
                            <input type="radio" name="goal" value="minimal_costs" style="display:none;">
                            <div class="chip-content" style="padding:16px 20px; background:rgba(255,255,255,0.02); border:1px solid var(--glass-border); border-radius:16px; display:flex; align-items:center; gap:16px; transition:all 0.3s;">
                                <span style="font-size:24px;">💰</span>
                                <div>
                                    <div style="font-weight:700; font-size:15px; color:#fff;">Экономный режим</div>
                                    <div style="font-size:13px; color:rgba(255,255,255,0.5); margin-top:4px;">Минимизация риска и снижение расходов</div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <style>
                        .strategy-chip input:checked + .chip-content {
                            background: rgba(132,148,131,0.15) !important;
                            border-color: var(--accent) !important;
                            box-shadow: 0 4px 20px rgba(132,148,131,0.2);
                        }
                    </style>

                    <div style="display:flex; gap:12px; margin-top:24px;">
                        <button type="button" class="btn btn-outline" onclick="goToStep(2)" style="flex:1; padding: 18px !important;">← Назад</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn" style="flex:2; padding: 18px !important; font-size: 16px !important; background: linear-gradient(135deg, var(--accent) 0%, #6e7a6d 100%) !important; box-shadow: 0 10px 30px rgba(132, 148, 131, 0.3) !important;">
                            <span id="submitBtnText" style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Создать План
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div> <!-- End left column container -->

    <!-- ВТОРАЯ КОЛОНКА (КАРТА И ОТЧЕТЫ) -->
    <div class="right-column" style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Карта всегда видима -->
        <div class="card map-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; min-height: 500px; border-radius: 24px; background: rgba(0,0,0,0.3) !important; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 10px 40px rgba(0,0,0,0.3); transition: box-shadow 0.3s;">
            <div style="padding: 16px 24px; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02);">
                <h2 style="font-size: 16px; font-weight: 700; margin: 0; display:flex; align-items:center; gap:8px; color: #fff; text-transform: uppercase; letter-spacing: 0.05em;">
                    <svg width="18" height="18" fill="none" stroke="var(--accent)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Рабочая область карты
                </h2>
                <div style="display:flex; gap:12px;">
                    <button type="button" class="btn btn-outline" id="clearMapBtn" style="background: transparent; border: 1px solid var(--glass-border); color: #fff; padding: 8px 16px; border-radius: 10px; font-size: 12px; cursor: pointer;">Очистить слой</button>
                    <button type="button" class="btn btn-primary" id="saveMapBtn" style="padding: 8px 16px !important; font-size: 12px !important; border-radius: 10px !important;">Утвердить границы</button>
                </div>
            </div>
            <div id="mapContainer" style="flex: 1; position: relative;">
                <div id="map" style="width: 100%; height: 100%; min-height: 500px; position:absolute; inset:0;"></div>
            </div>
        </div>

<div id="aiAnalysisResult" class="card"
    style="display: none; margin-top: 40px; background: rgba(132, 148, 131, 0.05) !important;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 24px; margin: 0; font-weight: 700; color: var(--accent);">Стратегия Agro AI</h2>
        <a href="#" id="openChatBtn" class="btn btn-primary"
            style="text-decoration: none; padding: 10px 20px !important; font-size: 14px !important;">Открыть чат с
            экспертом</a>
    </div>
    <div id="aiResultContent" style="font-size: 16px; line-height: 1.8; color: rgba(255,255,255,0.9);"></div>
</div>

<div id="planIntelPanel" class="card" style="display: none; margin-top: 24px;">
    <h2 style="font-size: 24px; margin: 0 0 16px 0; font-weight: 700;">Интеллект-панель плана</h2>
    <div id="planIntelKpi" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px;"></div>
    <h3 style="font-size: 18px; margin: 0 0 10px 0; color: var(--accent);">Ключевые риски</h3>
    <div id="planIntelRisks" style="display: grid; grid-template-columns: 1fr; gap: 10px; margin-bottom: 20px;"></div>
    <h3 style="font-size: 18px; margin: 0 0 10px 0; color: var(--accent);">План работ по этапам</h3>
    <div id="planIntelTasks" style="display: grid; grid-template-columns: 1fr; gap: 10px;"></div>
</div>

<div id="scenarioPanel" class="card" style="display: none; margin-top: 24px;">
    <h2 style="font-size: 24px; margin: 0 0 16px 0; font-weight: 700;">Сценарии стратегии</h2>
    <div id="scenarioCards" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;"></div>
</div>

<div style="margin-top: 16px;">
    <h2 style="font-size: 24px; margin-bottom: 24px; font-weight: 700; color: #fff;">Недавние проекты</h2>
    <div id="plansList" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
        <!-- Плейсхолдер -->
        <div class="history-box" style="text-align: center; color: var(--text-secondary); grid-column: 1/-1;">
            Список планов загружается...
        </div>
    </div>
</div> <!-- End right column -->
</div> <!-- End split-layout -->
</div>

<!-- Leaflet для карты -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css" />

<script>
    let currentFarmId = null;
    let map = null;
    let drawnItems = null;
    let drawControl = null;
    let currentStep = 1;
    const totalSteps = 5;

    // Справочник культур для автодополнения
    function openMapModal() {
        document.getElementById('map').scrollIntoView({behavior: 'smooth', block: 'center'});
        const mapCard = document.querySelector('.map-card');
        if(mapCard) {
            mapCard.style.boxShadow = '0 0 0 4px var(--accent)';
            setTimeout(() => mapCard.style.boxShadow = '0 10px 40px rgba(0,0,0,0.3)', 1000);
        }
    }
    function closeMapModal() {}
    
    // Справочник культур для автодополнения
    const cropsList = [
        'пшеница', 'ячмень', 'овес', 'рожь', 'кукуруза', 'рис', 'гречиха',
        'соя', 'горох', 'фасоль', 'чечевица', 'нут', 'люцерна', 'клевер',
        'подсолнечник', 'рапс', 'горчица', 'лен', 'конопля',
        'картофель', 'морковь', 'свекла', 'лук', 'чеснок', 'капуста', 'томаты', 'огурцы', 'перец', 'баклажаны',
        'яблоня', 'груша', 'вишня', 'слива', 'абрикос', 'персик', 'виноград',
        'хлопок', 'сахарная свекла', 'табак'
    ];

    document.addEventListener('DOMContentLoaded', function () {
        loadFarms();
        loadFields();
        loadPlans();
        initCropAutocomplete();
        setTimeout(() => initMap(), 500);

        // Обработчики карты
        const openMapBtn = document.getElementById('openMapBtn');
        if (openMapBtn) openMapBtn.addEventListener('click', openMapModal);

        const closeMapBtn = document.getElementById('closeMapBtn');
        if (closeMapBtn) closeMapBtn.addEventListener('click', closeMapModal);

        const clearMapBtn = document.getElementById('clearMapBtn');
        if (clearMapBtn) clearMapBtn.addEventListener('click', () => { if (drawnItems) drawnItems.clearLayers(); });

        const saveMapBtn = document.getElementById('saveMapBtn');
        if (saveMapBtn) saveMapBtn.addEventListener('click', saveFieldFromMap);

        // Переключатель продвинутых настроек
        const toggleBtn = document.getElementById('toggleAdvanced');
        const advancedSec = document.getElementById('advancedSection');
        const toggleIcon = document.getElementById('toggleIcon');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const isHidden = advancedSec.style.display === 'none';
                advancedSec.style.display = isHidden ? 'block' : 'none';
                if (toggleIcon) {
                    toggleIcon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
                    toggleIcon.style.transition = 'transform 0.3s';
                }
            });
        }

        // Автозаполнение при выборе участка
        const fieldSelect = document.getElementById('fieldSelect');
        if (fieldSelect) {
            fieldSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                if (this.value) {
                    const area = selectedOption.dataset.area || '--';
                    const region = selectedOption.dataset.region || 'Кыргызстан';

                    const areaDisplay = document.getElementById('displayArea');
                    const regionDisplay = document.getElementById('displayRegion');

                    const fieldMetaCard = document.getElementById('fieldMetaCard');
                    if (areaDisplay) areaDisplay.textContent = area + ' га';
                    if (regionDisplay) regionDisplay.textContent = region;
                    if (fieldMetaCard) fieldMetaCard.style.display = 'block';


                    const areaInput = document.getElementById('area');
                    const regionInput = document.getElementById('region');
                    if (areaInput) areaInput.value = area;
                    if (regionInput) regionInput.value = region;

                    loadFieldHistory(this.value);
                } else {
                    const areaDisplay = document.getElementById('displayArea');
                    const regionDisplay = document.getElementById('displayRegion');
                    if (areaDisplay) areaDisplay.textContent = '-- га';
                    if (regionDisplay) regionDisplay.textContent = '--';
                    const fieldMetaCard = document.getElementById('fieldMetaCard');
                    if (fieldMetaCard) fieldMetaCard.style.display = 'none';
                }
            });
        }

        // Обработчик отправки формы
        const planForm = document.getElementById('planForm');
        if (planForm) {
            planForm.addEventListener('submit', function (e) {
                e.preventDefault();
                createPlan();
            });
        }

        // Кнопка открытия чата
        const openChatBtn = document.getElementById('openChatBtn');
        if (openChatBtn) {
            openChatBtn.addEventListener('click', function (e) {
                e.preventDefault();
                if (window.currentPlanId) {
                    window.location.href = `/chat?plan_id=${window.currentPlanId}`;
                } else {
                    alert('Сначала создайте план');
                }
            });
        }
    });


    function initCropAutocomplete() {
        const cropInput = document.getElementById('crop');
        const suggestionsDiv = document.getElementById('cropSuggestions');

        cropInput.addEventListener('input', function () {
            const value = this.value.toLowerCase().trim();
            if (value.length < 2) {
                suggestionsDiv.style.display = 'none';
                return;
            }

            const matches = cropsList.filter(crop => crop.toLowerCase().includes(value));
            if (matches.length === 0) {
                suggestionsDiv.style.display = 'none';
                return;
            }

            suggestionsDiv.innerHTML = matches.slice(0, 8).map(crop => `
            <div class="crop-suggestion" style="padding: 14px 20px; cursor: pointer; border-bottom: 1px solid var(--glass-border); transition: all 0.2s; color: #fff;"
                 onmouseover="this.style.background='rgba(132, 148, 131, 0.1)'; this.style.color='var(--accent)';"
                 onmouseout="this.style.background='transparent'; this.style.color='#fff';"
                 onclick="selectCrop('${crop}')">
                ${crop}
            </div>
        `).join('');
            suggestionsDiv.style.display = 'block';
        });

        // Скрываем при клике вне
        document.addEventListener('click', function (e) {
            if (!cropInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
                suggestionsDiv.style.display = 'none';
            }
        });
    }

    function selectCrop(crop) {
        document.getElementById('crop').value = crop;
        document.getElementById('cropSuggestions').style.display = 'none';
    }

    function createPlan() {
        const getVal = (id) => document.getElementById(id)?.value?.trim() || '';
        const getNum = (id) => parseFloat(document.getElementById(id)?.value) || 0;

        const fieldId = getVal('fieldSelect');
        const area = getNum('area');
        const region = getVal('region');
        const city = getVal('city');
        const startDate = getVal('startDate');
        const crop = getVal('crop');
        const goal = document.querySelector('input[name="goal"]:checked')?.value || 'balanced';

        // Валидация
        if (!fieldId || !crop || !startDate) {
            alert('⚠️ Пожалуйста, выберите участок, культуру и дату начала.');
            return;
        }

        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('submitBtnText');
        if (btn) btn.disabled = true;

        if (btnText) btnText.innerHTML = '✨ Магия Agro AI...';

        const payload = {
            field_id: fieldId,
            crop: crop,
            area_hectares: area,
            region: region,
            city: city, // New field
            start_date: startDate,
            goal: goal,
            budget: getVal('budget') || 'medium',
            predecessor: getVal('predecessor'),
            monoculture: getVal('monoculture'),
            soil_type: getVal('soilType'),
            crop_history: {
                last_year: {
                    crop: getVal('historyCrop1'),
                    yield: getVal('historyYield1')
                },
                year_before: {
                    crop: getVal('historyCrop2'),
                    yield: getVal('historyYield2')
                }
            },
            problems: Array.from(document.querySelectorAll('input[name="problems"]:checked')).map(cb => cb.value),
            additional_info: {
                soilType: getVal('soilType'),
                predecessor: getVal('predecessor'),
                monoculture: getVal('monoculture'),
                budget: getVal('budget') || 'medium',
                problems: Array.from(document.querySelectorAll('input[name="problems"]:checked')).map(cb => cb.value),
                fieldNotes: getVal('historyCrop1') || getVal('historyCrop2') ? 'Заполнена история по годам' : ''
            }
        };

        fetch('/api/field-plans', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
            .then(async r => {
                const text = await r.text();
                let data;
                try { data = JSON.parse(text); }
                catch (e) { throw new Error('Ошибка сервера'); }
                if (!r.ok) throw new Error(data.error || `HTTP ${r.status}`);
                return data;
            })
            .then(data => {
                if (data.success) {
                    window.currentPlanId = data.plan_id;
                    loadPlans();
                    if (data.plan?.ai_analysis) {
                        const resultEl = document.getElementById('aiAnalysisResult');
                        if (resultEl) {
                            resultEl.style.display = 'block';
                            document.getElementById('aiResultContent').innerHTML =
                                formatPlanAiText(data.plan.ai_analysis);
                            resultEl.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                    alert('✅ Smart Plan успешно создан!');
                }
            })
            .catch(err => {
                console.error(err);
                alert('❌ Ошибка: ' + err.message);
            })
            .finally(() => {
                if (btn) btn.disabled = false;
                if (btnText) btnText.innerHTML = `
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Создать Smart Plan`;
            });
    }

    function formatPlanAiText(text) {
        if (!text) return '';
        const cleaned = text
            .replace(/START_PLAN_JSON[\s\S]*?END_PLAN_JSON/gi, '')
            .replace(/START_[A-Z_]+[\s\S]*?END_[A-Z_]+/g, '')
            .replace(/^#{1,6}\s*/gm, '')
            .replace(/\*\*(.*?)\*\*/g, '$1')
            .replace(/\n{3,}/g, '\n\n')
            .trim();

        const escaped = cleaned
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        return escaped
            .replace(/\n\n/g, '<br><br>')
            .replace(/\n/g, '<br>');
    }

    function formatRiskLevel(level) {
        if (level === 'critical') return 'Критично';
        if (level === 'low') return 'Низкий';
        return 'Средний';
    }

    function renderPlanIntelPanel(plan) {
        const panel = document.getElementById('planIntelPanel');
        const kpiEl = document.getElementById('planIntelKpi');
        const risksEl = document.getElementById('planIntelRisks');
        const tasksEl = document.getElementById('planIntelTasks');
        if (!panel || !kpiEl || !risksEl || !tasksEl) return;

        const kpi = plan.kpi || {};
        const riskCount = Array.isArray(plan.risks) ? plan.risks.length : 0;
        const tasks = Array.isArray(plan.tasks) ? plan.tasks : [];
        const highPriority = tasks.filter(t => t.priority === 'high').length;

        kpiEl.innerHTML = `
            <div style="padding: 14px; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);">
                <div style="font-size: 12px; opacity: 0.6;">Прогноз урожайности</div>
                <div style="font-size: 24px; font-weight: 700; margin-top: 6px;">${kpi.yield_t_ha ? kpi.yield_t_ha + ' т/га' : 'н/д'}</div>
            </div>
            <div style="padding: 14px; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);">
                <div style="font-size: 12px; opacity: 0.6;">Индекс рисков</div>
                <div style="font-size: 24px; font-weight: 700; margin-top: 6px;">${kpi.risk_index ?? (riskCount ? 55 : 40)} / 100</div>
            </div>
            <div style="padding: 14px; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border);">
                <div style="font-size: 12px; opacity: 0.6;">Приоритетных задач</div>
                <div style="font-size: 24px; font-weight: 700; margin-top: 6px;">${highPriority}</div>
            </div>
        `;

        if (riskCount === 0) {
            risksEl.innerHTML = '<div class="history-box" style="margin:0;">Критические риски не обнаружены.</div>';
        } else {
            risksEl.innerHTML = plan.risks.slice(0, 4).map(risk => {
                const color = risk.level === 'critical' ? '#ff6b6b' : (risk.level === 'low' ? '#7bd88f' : '#ffb347');
                return `
                    <div style="padding: 12px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.02);">
                        <div style="display:flex; justify-content:space-between; gap:8px; align-items:center;">
                            <strong style="color:${color}; font-size:13px;">${formatRiskLevel(risk.level)}</strong>
                            <span style="font-size:11px; opacity:0.5;">${risk.type || 'general'}</span>
                        </div>
                        <div style="margin-top:6px; font-size:14px; line-height:1.5;">${risk.description || 'Риск требует наблюдения'}</div>
                    </div>
                `;
            }).join('');
        }

        if (tasks.length === 0) {
            tasksEl.innerHTML = '<div class="history-box" style="margin:0;">AI не вернул структурированные задачи. Используйте рекомендации ниже.</div>';
        } else {
            tasksEl.innerHTML = tasks.map((task, idx) => {
                const priColor = task.priority === 'high' ? '#ff6b6b' : (task.priority === 'low' ? '#7bd88f' : '#ffb347');
                const due = task.due_date ? new Date(task.due_date).toLocaleDateString('ru-RU') : 'дата уточняется';
                return `
                    <div style="padding: 12px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.02); display:flex; justify-content:space-between; gap:10px;">
                        <div>
                            <div style="font-size:12px; opacity:0.6;">Этап ${idx + 1}${task.stage ? ' • ' + task.stage : ''}</div>
                            <div style="font-size:15px; font-weight:600; margin-top:4px;">${task.title || 'Задача'}</div>
                        </div>
                        <div style="text-align:right; min-width:120px;">
                            <div style="font-size:12px; color:${priColor}; font-weight:700; text-transform:uppercase;">${task.priority || 'medium'}</div>
                            <div style="font-size:12px; opacity:0.7; margin-top:6px;">${due}</div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        panel.style.display = 'block';
    }

    function renderScenarioPanel(plan, selectedGoal) {
        const panel = document.getElementById('scenarioPanel');
        const cards = document.getElementById('scenarioCards');
        if (!panel || !cards) return;

        const baseYield = (plan.kpi && typeof plan.kpi.yield_t_ha === 'number') ? plan.kpi.yield_t_ha : 4.2;
        const baseRisk = (plan.kpi && typeof plan.kpi.risk_index === 'number') ? plan.kpi.risk_index : 50;

        const scenarios = [
            { key: 'maximum_yield', title: 'Макс. урожай', yieldMul: 1.12, cost: 122, riskDelta: +8 },
            { key: 'balanced', title: 'Баланс', yieldMul: 1.00, cost: 100, riskDelta: 0 },
            { key: 'minimal_costs', title: 'Эконом', yieldMul: 0.90, cost: 82, riskDelta: +4 }
        ];

        cards.innerHTML = scenarios.map(s => {
            const isActive = s.key === selectedGoal;
            const y = (baseYield * s.yieldMul).toFixed(2);
            const r = Math.min(100, Math.max(5, baseRisk + s.riskDelta));
            return `
                <div style="padding: 14px; border-radius: 14px; background:${isActive ? 'rgba(132,148,131,0.12)' : 'rgba(255,255,255,0.03)'}; border:1px solid ${isActive ? 'rgba(132,148,131,0.45)' : 'var(--glass-border)'};">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
                        <strong style="font-size:15px;">${s.title}</strong>
                        ${isActive ? '<span style="font-size:10px; padding:3px 8px; border-radius:20px; background:rgba(132,148,131,0.2);">выбрано</span>' : ''}
                    </div>
                    <div style="margin-top:10px; font-size:13px; opacity:0.85;">Урожайность: <strong>${y} т/га</strong></div>
                    <div style="margin-top:6px; font-size:13px; opacity:0.85;">Индекс затрат: <strong>${s.cost}</strong></div>
                    <div style="margin-top:6px; font-size:13px; opacity:0.85;">Индекс риска: <strong>${r}</strong></div>
                </div>
            `;
        }).join('');

        panel.style.display = 'block';
    }


    // Остальные функции ниже
    function loadFarms() {
        const farmSelect = document.getElementById('farmSelect');
        const noFarmWarning = document.getElementById('noFarmWarning');
        const planForm = document.getElementById('planForm');
        
        if (noFarmWarning) noFarmWarning.style.display = 'none';
        if (planForm) planForm.style.display = 'block';

        if (farmSelect) {
            farmSelect.innerHTML = '<option value="" disabled selected>-- Выберите премиум-хозяйство --</option>' +
                '<option value="1">Агрокомплекс «Золотой Колос»</option>' + 
                '<option value="2">Эко-ферма «Степные Зори»</option>' +
                '<option value="3">Холдинг «Агро-Альянс»</option>';
        }
    }

    
    function goToStep(step) {
        // Simple JS validation for step 1
        if (step === 2 || step === 3) {
            const f = document.getElementById('fieldSelect').value;
            const c = document.getElementById('crop').value;
            const s = document.getElementById('startDate').value;
            if (!f || !c || !s) {
                alert('Пожалуйста, заполните обязательные поля (Хозяйство, Участок, Культура, Дата) чтобы продолжить.');
                return;
            }
        }
        
        document.querySelectorAll('.wizard-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.wizard-step-ui').forEach((el, index) => {
            el.classList.remove('active');
            if(index + 1 < step) el.classList.add('completed');
            else el.classList.remove('completed');
        });
        
        document.getElementById('w_step' + step).classList.add('active');
        document.getElementById('ws-val-' + step).classList.add('active');
        
        const perf = (step - 1) * 50;
        document.getElementById('wizardLine').style.width = perf + '%';
    }

    // Existing functions...

    function onFarmChange(farmId) {
        currentFarmId = farmId;
        loadFields();
    }

    function loadFields() {
        if (!currentFarmId) return;

        const select = document.getElementById('fieldSelect');
        if (!select) return;

        const mockFields = [
            { id: 10, name: 'Сектор А-12 (Северный склон)', area: 450, region: 'Чуйская долина', crop: 'Пшеница' },
            { id: 11, name: 'Сектор В-04 (У поймы реки)', area: 280, region: 'Чуйская долина', crop: 'Кукуруза' },
            { id: 12, name: 'Центральный массив', area: 1200, region: 'Иссык-Куль', crop: 'Картофель' }
        ];

        select.innerHTML = '<option value="">-- Выберите инновационный участок --</option>' + mockFields.map(f => 
            `<option value="${f.id}" data-area="${f.area}" data-region="${f.region}">${f.name} (Предш: ${f.crop})</option>`
        ).join('');
    }

    function loadFieldHistory(fieldId) {
        const historyDiv = document.getElementById('fieldHistory');
        const historyList = document.getElementById('historyList');
        
        const mockCycles = [
            { year: 2025, crop: 'Пшеница яровая', yield: 4.5 },
            { year: 2024, crop: 'Подсолнечник', yield: 2.8 }
        ];

        historyDiv.style.display = 'block';
        historyList.innerHTML = mockCycles.map(cycle => `
            <div class="history-box" style="margin-bottom: 8px;">
                <span style="color: var(--accent); font-weight: 600;">${cycle.year}:</span> 
                <span style="color: #fff;">${cycle.crop}</span>
                <span style="color: rgba(255,255,255,0.5); font-size: 13px;"> • ${cycle.yield} т/га</span>
            </div>
        `).join('');
    }

    function loadPlans() {
        const plansList = document.getElementById('plansList');
        if (!plansList) return;

        const mockPlans = [
            { id: 101, crop: 'Озимая Пшеница (Premium)', area_hectares: 1250, region: 'Южный кластер', start_date: new Date(Date.now() - 86400000*10).toISOString() },
            { id: 102, crop: 'Подсолнечник кондитерский', area_hectares: 480, region: 'Восточное поле', start_date: new Date(Date.now() - 86400000*2).toISOString() },
            { id: 103, crop: 'Кукуруза на зерно', area_hectares: 850, region: 'Северный округ', start_date: new Date().toISOString() }
        ];

        plansList.innerHTML = mockPlans.map(plan => `
            <div class="card" style="padding: 24px; margin: 0; display: flex; flex-direction: column; justify-content: space-between; border-radius: 20px; border: 1px solid rgba(132, 148, 131, 0.4); background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(132,148,131,0.05) 100%); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <h3 style="font-size: 22px; font-weight: 800; color: #fff; margin:0; font-family: 'Playfair Display', serif;">${plan.crop}</h3>
                        <span style="font-size: 11px; font-weight: 800; padding: 6px 12px; background: rgba(132, 148, 131, 0.15); color: var(--accent); border-radius: 20px; border: 1px solid rgba(132, 148, 131, 0.3); text-transform: uppercase; letter-spacing: 0.05em;">AI Активен</span>
                    </div>
                    <div style="font-size: 14px; color: rgba(255,255,255,0.7); display: flex; flex-direction: column; gap: 10px;">
                        <span style="display: flex; align-items: center; gap: 10px;">
                            <div style="width:28px; height:28px; border-radius:8px; background:rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:center;"><svg width="14" height="14" fill="none" stroke="var(--accent)" stroke-width="2"><path d="M12 2l-5.5 9-2.5-4.5"></path></svg></div>
                            <strong>${plan.area_hectares} га</strong> • ${plan.region}
                        </span>
                        <span style="display: flex; align-items: center; gap: 10px;">
                            <div style="width:28px; height:28px; border-radius:8px; background:rgba(255,255,255,0.05); display:flex; align-items:center; justify-content:center;"><svg width="14" height="14" fill="none" stroke="var(--accent)" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></div>
                            Начат: ${new Date(plan.start_date).toLocaleDateString('ru-RU')}
                        </span>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" style="width:100%; text-decoration: none; text-align: center; padding: 14px !important; font-size: 14px; display:flex; align-items:center; justify-content:center; gap:8px;" onclick="window.location.href='/chat?plan_id=${plan.id}'">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    Перейти к AI-консультанту
                </button>
            </div>
        `).join('');
    }

    function createFarmFirst() {
        const farmName = prompt('Введите название хозяйства:', 'Мое хозяйство');
        if (!farmName) return;

        const region = prompt('Введите регион (опционально):', 'Чуйская область') || '';

        fetch('/api/farms', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                name: farmName,
                region: region
            })
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Хозяйство создано!');
                    loadFarms();
                } else {
                    alert('Ошибка: ' + (data.error || 'Не удалось создать хозяйство'));
                }
            })
            .catch(err => {
                console.error('Ошибка:', err);
                alert('Произошла ошибка при создании хозяйства');
            });
    }

    function openMapModal() {
        if (!currentFarmId) {
            alert('Сначала создайте хозяйство!\n\nПерейдите на главную страницу и создайте хозяйство, затем вернитесь сюда.');
            return;
        }

        document.getElementById('mapModal').style.display = 'flex';

        if (!map) {
            setTimeout(() => initMap(), 100);
        } else {
            setTimeout(() => map.invalidateSize(), 100);
        }
    }

    function closeMapModal() {
        document.getElementById('mapModal').style.display = 'none';
    }

    function initMap() {
        map = L.map('map').setView([42.8746, 74.5698], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        drawControl = new L.Control.Draw({
            draw: {
                polygon: {
                    allowIntersection: false,
                    showArea: true,
                    metric: true,
                    shapeOptions: {
                        color: '#4CAF50',
                        fillColor: '#4CAF50',
                        fillOpacity: 0.3
                    }
                },
                rectangle: {
                    shapeOptions: {
                        color: '#4CAF50',
                        fillColor: '#4CAF50',
                        fillOpacity: 0.3
                    }
                },
                circle: false,
                marker: false,
                polyline: false,
                circlemarker: false
            },
            edit: {
                featureGroup: drawnItems,
                remove: true
            }
        });

        map.addControl(drawControl);

        map.on(L.Draw.Event.CREATED, function (e) {
            const layer = e.layer;
            drawnItems.addLayer(layer);

            if (layer instanceof L.Polygon || layer instanceof L.Rectangle) {
                let latlngs;
                if (layer instanceof L.Rectangle) {
                    const bounds = layer.getBounds();
                    latlngs = [
                        bounds.getSouthWest(),
                        bounds.getNorthWest(),
                        bounds.getNorthEast(),
                        bounds.getSouthEast()
                    ];
                } else {
                    latlngs = layer.getLatLngs()[0];
                }

                const area = calculateArea(latlngs);
                const areaHectares = (area / 10000).toFixed(2);

                layer.bindPopup(`Площадь: ${areaHectares} га`).openPopup();
                document.getElementById('area').value = areaHectares;
            }
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                map.setView([position.coords.latitude, position.coords.longitude], 15);
            });
        }
    }

    function calculateArea(latlngs) {
        if (!latlngs || latlngs.length < 3) return 0;
        let area = 0;
        const R = 6371000;
        for (let i = 0; i < latlngs.length; i++) {
            const j = (i + 1) % latlngs.length;
            const lat1 = latlngs[i].lat * Math.PI / 180;
            const lat2 = latlngs[j].lat * Math.PI / 180;
            const lng1 = latlngs[i].lng * Math.PI / 180;
            const lng2 = latlngs[j].lng * Math.PI / 180;
            area += (lng2 - lng1) * (2 + Math.sin(lat1) + Math.sin(lat2));
        }
        area = Math.abs(area * R * R / 2);
        return area;
    }

    function saveFieldFromMap() {
        if (!drawnItems || drawnItems.getLayers().length === 0) {
            alert('Сначала отметьте участок на карте');
            return;
        }

        const layer = drawnItems.getLayers()[0];
        let latlngs;

        if (layer instanceof L.Rectangle) {
            const bounds = layer.getBounds();
            latlngs = [
                bounds.getSouthWest(),
                bounds.getNorthWest(),
                bounds.getNorthEast(),
                bounds.getSouthEast()
            ];
        } else {
            latlngs = layer.getLatLngs()[0];
        }

        const geometry = {
            type: 'Polygon',
            coordinates: [[latlngs.map(ll => [ll.lng, ll.lat])]]
        };

        const area = calculateArea(latlngs);
        const areaHectares = parseFloat((area / 10000).toFixed(2));

        const fieldName = prompt('Введите название участка:', 'Новый участок');
        if (!fieldName) return;

        fetch('/api/fields', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                farm_id: currentFarmId,
                name: fieldName,
                area_hectares: areaHectares,
                geometry: geometry
            })
        })
            .then(async r => {
                const text = await r.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Ошибка парсинга ответа:', text);
                    throw new Error('Неверный ответ от сервера: ' + text.substring(0, 200));
                }

                if (!r.ok) {
                    throw new Error(data.error || `HTTP ${r.status}`);
                }

                return data;
            })
            .then(data => {
                if (data.success) {
                    alert('✅ Участок успешно создан!');
                    closeMapModal();
                    loadFields();
                    if (data.field_id) {
                        document.getElementById('fieldSelect').value = data.field_id;
                        loadFieldHistory(data.field_id);
                    }
                } else {
                    throw new Error(data.error || 'Не удалось создать участок');
                }
            })
            .catch(err => {
                console.error('Ошибка создания участка:', err);
                alert('❌ Ошибка: ' + err.message);
            });
    }
</script>
</div><!-- /.plan-page -->
</div><!-- /.dash-page-content -->
</main><!-- /.dash-main -->
</div><!-- /.dashboard-wrapper -->
<script>
// Load user info for sidebar header
fetch('/api/auth/me').then(r=>r.json()).then(d=>{
    if(d && d.email){
        var initials = (d.email || 'U').substring(0,2).toUpperCase();
        var el = document.getElementById('sidebarAvatarInitials');
        var nm = document.getElementById('sidebarUserName');
        if(el) el.textContent = initials;
        if(nm) nm.textContent = d.email.split('@')[0];
    }
}).catch(()=>{});
</script>