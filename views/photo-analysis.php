<?php
$activePage = 'photo-analysis';
$pageHeaderTitle = 'Анализ фото — Диагностика растений';
include __DIR__ . '/layouts/sidebar.php';
?>

<div class="photo-analysis-page">
<div class="dash-aura"><div class="d-blob d-blob-1"></div><div class="d-blob d-blob-2"></div></div>

    <style>
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
            opacity: 0.12;
            z-index: -1;
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

        :root {
            --accent: #9CAD9A; /* Soft Olive */
            --accent-dark: #7A8F78;
            --accent-glow: rgba(156, 173, 154, 0.2);
            --primary: #C5B49E; /* Muted Sand */
            --bg-dark: #0A0908; /* Deep Graphite */
            --card-bg: rgba(255, 255, 255, 0.03);
            --border-color: rgba(255, 255, 255, 0.06);
            
            /* Typography Scale */
            --h1: 56px;
            --h2: 32px;
            --body: 16px;
            --caption: 13px;
        }

        body {
            background: var(--bg-dark);
            color: #fff;
            font-family: 'Inter', sans-serif;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        .premium-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 40px;
            position: relative;
            transition: all 0.3s ease;
        }

        .premium-card:hover {
            border-color: rgba(255, 255, 255, 0.12);
        }

        .card-small {
            border-radius: 18px;
            padding: 24px;
        }
        
        .split-layout {
            display: grid;
            grid-template-columns: 500px 1fr;
            gap: 40px;
        }

        .agro-input {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            padding: 16px 20px !important;
            color: #fff !important;
            font-size: var(--body) !important;
            transition: all 0.2s ease !important;
            width: 100%;
        }

        .agro-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .agro-input:focus {
            border-color: var(--accent) !important;
            background: rgba(255, 255, 255, 0.04) !important;
            outline: none;
        }

        option {
            background-color: #1a1a1a !important;
            color: #fff !important;
        }

        .agro-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: var(--caption);
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .btn-analyze {
            background: var(--primary) !important;
            color: #1a1a1a !important;
            padding: 14px 32px !important;
            border-radius: 14px !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            border: none !important;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(197, 180, 158, 0.2);
        }

        .btn-analyze:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .symptom-pill {
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: var(--caption);
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            transition: all 0.2s;
        }

        .symptom-pill:hover {
            border-color: var(--accent);
            color: #fff;
            background: rgba(156, 173, 154, 0.05);
        }

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
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 48px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.01);
            position: relative;
        }

        .drop-zone:hover,
        .drop-zone.active {
            border-color: var(--primary);
            background: rgba(16, 185, 129, 0.05);
        }

        .symptom-pill {
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 30px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: all 0.3s;
        }

        .symptom-pill:hover {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--primary);
            color: #fff;
        }

        .weather-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
        }

        /* --- КАЧЕСТВЕННАЯ АДАПТИВКА PHOTO-ANALYSIS --- */
        @media (max-width: 992px) {
            .split-layout {
                grid-template-columns: 1fr !important;
                gap: 24px !important;
            }
            .control-panel {
                position: static !important;
            }
            .photo-analysis-page {
                padding: 28px 20px !important;
            }
        }

        @media (max-width: 768px) {
            .photo-analysis-page {
                padding: 22px 16px !important;
            }
            .photo-analysis-page > div[style*="margin-bottom: 32px"] {
                margin-bottom: 24px !important;
            }
            .photo-analysis-page [style*="margin-bottom: 48px"] {
                margin-bottom: 32px !important;
            }
            .photo-analysis-page .premium-card {
                padding: 24px 18px;
                border-radius: 20px;
            }
            .photo-analysis-page h1 {
                font-size: 26px !important;
            }
            .photo-analysis-page h1 + p {
                font-size: 15px !important;
            }
            .photo-analysis-page h2 {
                font-size: 20px !important;
                margin-bottom: 20px !important;
            }
            .photo-analysis-page .drop-zone {
                padding: 28px 16px;
                border-radius: 16px;
            }
            .photo-analysis-page .drop-zone svg {
                width: 40px !important;
                height: 40px !important;
            }
            .photo-analysis-page #photoDropContent div[style*="font-size: 16px"] {
                font-size: 15px !important;
            }
            .photo-analysis-page #photoDropContent div[style*="font-size: 13px"] {
                font-size: 12px !important;
            }
            .photo-analysis-page .agro-label {
                font-size: 10px;
                margin-bottom: 10px;
            }
            .photo-analysis-page .agro-input,
            .photo-analysis-page select.agro-input {
                padding: 12px 14px !important;
                min-height: 44px;
                font-size: 16px !important;
            }
            .photo-analysis-page textarea.agro-input {
                min-height: 80px;
            }
            .photo-analysis-page .symptom-pill {
                padding: 8px 12px;
                font-size: 12px;
            }
            .photo-analysis-page .expand-btn {
                padding: 14px 12px;
                font-size: 14px;
            }
            .photo-analysis-page #extraInfo {
                margin-top: 18px !important;
            }
            .photo-analysis-page #extraInfo [style*="margin-top: 24px"] {
                margin-top: 18px !important;
            }
            .photo-analysis-page #extraInfo [style*="margin-top: 32px"] {
                margin-top: 20px !important;
            }
            .photo-analysis-page .weather-item {
                padding: 10px 12px;
                font-size: 13px;
            }
            .photo-analysis-page [style*="margin-top: 48px"] .btn-analyze {
                width: 100%;
                min-height: 48px;
                padding: 14px 24px !important;
                font-size: 15px !important;
            }
            .photo-analysis-page #analysisResult {
                margin-top: 28px !important;
            }
            .photo-analysis-page #analysisResult .premium-card {
                padding: 22px 18px !important;
            }
            .photo-analysis-page #analysisResult h2 {
                font-size: 20px !important;
            }
            .photo-analysis-page #analysisResult .premium-card > div[style*="justify-content: space-between"] {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            .photo-analysis-page #analysisResult #openChatBtn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
            .photo-analysis-page .analysis-history-item {
                flex-direction: column !important;
                align-items: stretch !important;
                padding: 18px !important;
                gap: 16px !important;
            }
            .photo-analysis-page .analysis-history-item img {
                width: 100% !important;
                height: 160px !important;
                object-fit: cover;
            }
            .photo-analysis-page .analysis-history-item .btn-analyze {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .photo-analysis-page {
                padding: 16px 12px !important;
            }
            .photo-analysis-page > div[style*="margin-bottom: 32px"] {
                margin-bottom: 20px !important;
            }
            .photo-analysis-page [style*="margin-bottom: 48px"] {
                margin-bottom: 24px !important;
            }
            .photo-analysis-page .premium-card {
                padding: 20px 14px;
                border-radius: 18px;
            }
            .photo-analysis-page h1 {
                font-size: 22px !important;
            }
            .photo-analysis-page h1 + p {
                font-size: 14px !important;
            }
            .photo-analysis-page h2 {
                font-size: 18px !important;
                margin-bottom: 16px !important;
            }
            .photo-analysis-page .drop-zone {
                padding: 24px 12px;
                border-radius: 14px;
            }
            .photo-analysis-page .drop-zone svg {
                width: 36px !important;
                height: 36px !important;
            }
            .photo-analysis-page #photoDropContent div[style*="font-size: 16px"] {
                font-size: 14px !important;
            }
            .photo-analysis-page .agro-input,
            .photo-analysis-page select.agro-input {
                padding: 12px 12px !important;
            }
            .photo-analysis-page .symptom-pill {
                padding: 6px 10px;
                font-size: 11px;
            }
            .photo-analysis-page .weather-grid {
                grid-template-columns: 1fr;
            }
            .photo-analysis-page .weather-item {
                padding: 12px 14px;
            }
            .photo-analysis-page .triage-badge {
                font-size: 10px;
                padding: 4px 10px;
            }
            .photo-analysis-page #analysisResult .premium-card > div[style*="grid-template-columns"],
            .photo-analysis-page #analysisContent > div[style*="grid-template-columns"] {
                gap: 20px !important;
            }
            .photo-analysis-page #analysisContent img {
                border-radius: 14px !important;
            }
            .photo-analysis-page #analysisContent [style*="font-size: 20px"] {
                font-size: 17px !important;
                color: #fff !important;
            }
            .photo-analysis-page .ai-analysis-text,
            .photo-analysis-page #analysisContent [style*="white-space: pre-wrap"] {
                font-size: 17px !important;
                color: rgba(255,255,255,0.9) !important;
            }
            .photo-analysis-page #analysisContent [style*="padding: 24px"] {
                padding: 18px !important;
            }
            .photo-analysis-page #analysesList .premium-card {
                padding: 16px !important;
            }
        }

        .weather-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .weather-item input {
            display: none;
        }

        .weather-item:hover {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .weather-item.selected {
            background: rgba(16, 185, 129, 0.15);
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
        }

        .expand-btn {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .expand-btn:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-analyze {
            background: var(--primary-gradient);
            color: #000;
            border: none;
            padding: 18px 32px;
            border-radius: 18px;
            font-weight: 800;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            transition: all 0.3s;
        }

        .btn-analyze:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
            filter: brightness(1.1);
        }

        .triage-badge {
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .triage-critical {
            background: rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.5);
        }

        .triage-medium {
            background: rgba(245, 158, 11, 0.25);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.5);
        }

        .triage-low {
            background: rgba(16, 185, 129, 0.25);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.5);
        }

        /* Блок результата и истории — без обрезки, контраст текста */
        .photo-analysis-page {
            overflow-x: hidden;
        }
        .photo-analysis-page #analysisResult,
        .photo-analysis-page #analysesList,
        .photo-analysis-page [style*="grid-template-columns: repeat(12, 1fr)"] {
            max-width: 100%;
            min-width: 0;
        }
        .photo-analysis-page .analysis-history-item {
            max-width: 100%;
            min-width: 0;
        }
        .photo-analysis-page .analysis-history-item > div[style*="flex: 1"] {
            min-width: 0;
            overflow: hidden;
        }
        .photo-analysis-page #analysisContent > div {
            min-width: 0;
        }
        .photo-analysis-page .triage-badge {
            font-weight: 800;
        }
        .photo-analysis-page .analysis-history-item div[style*="color: rgba(255,255,255,0.5)"] {
            color: rgba(255,255,255,0.85) !important;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        
        @keyframes slideDown { 0% { opacity:0; transform:translateY(-10px); } 100% { opacity:1; transform:translateY(0); } }
        @keyframes slideUp { 0% { opacity:0; transform:translateY(20px); } 100% { opacity:1; transform:translateY(0); } }
        @keyframes scan { 0% { top: 0%; } 100% { top: 100%; } }
        
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div style="margin-bottom: 64px; position: relative; z-index: 10;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: var(--h1); font-weight: 800; margin-bottom: 8px; letter-spacing: -0.01em;">
            Agro Scanner 2.0
        </h1>
        <div style="display: flex; align-items: center; gap: 16px;">
            <p style="color: rgba(255, 255, 255, 0.7); font-size: 18px; line-height: 1.6; margin: 0;">
                Диагностика заболеваний растений в реальном времени
            </p>
            <span style="background: rgba(156, 173, 154, 0.1); color: var(--accent); font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid rgba(156, 173, 154, 0.2);">AI Powered</span>
        </div>
        <div style="color: rgba(255, 255, 255, 0.3); font-size: var(--caption); margin-top: 12px; font-weight: 500;">GreenVisi v4.2</div>
    </div>

    <div class="split-layout" style="position: relative; z-index: 10;">
        <!-- LEFT COLUMN: CONTROL PANEL -->
        <div class="control-panel">
            <div class="premium-card">
                <form id="uploadForm" enctype="multipart/form-data">
                    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #fff; font-family: 'Playfair Display', serif;">
                        <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        Конфигуратор анализа
                    </h2>

                    <div class="form-group" style="margin-bottom: 32px;">
                        <label class="agro-label">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path></svg>
                            Культура / Растение
                        </label>
                        <div style="position: relative;">
                            <input type="text" class="agro-input" id="crop" placeholder="Напр: Озимая пшеница, Черри..." required autocomplete="off">
                            <div id="cropSuggestions" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #1a1a1a; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; max-height: 200px; overflow-y: auto; z-index: 1000; margin-top: 8px;"></div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 32px;">
                        <label class="agro-label">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"></path></svg>
                            Симптомы / Описание
                        </label>
                        <textarea class="agro-input" id="symptoms" rows="4" placeholder="Опишите проблему..."></textarea>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px;">
                            <div class="symptom-pill" onclick="addSymptom('желтизна')">Желтизна</div>
                            <div class="symptom-pill" onclick="addSymptom('пятна')">Пятна</div>
                            <div class="symptom-pill" onclick="addSymptom('налет')">Налет</div>
                        </div>
                    </div>

                    <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.05);">
                        <button type="button" id="toggleExtraInfoBtn" class="expand-btn" style="background:none; border:none; padding:0; font-size:13px; color:var(--primary); opacity:0.8;">
                            <span>+ Показать доп. параметры</span>
                            <span id="toggleIcon">▼</span>
                        </button>

                        <div id="extraInfo" style="display: none; margin-top: 20px; animation: slideDown 0.3s ease-out;">
                            <div class="form-group">
                                <label class="agro-label">🌱 Стадия роста</label>
                                <select class="agro-input" id="growthStage">
                                    <option value="">AI оценит автоматически</option>
                                    <option value="всходы">🌱 Всходы</option>
                                    <option value="вегетация">🌿 Вегетация</option>
                                    <option value="цветение">🌸 Цветение</option>
                                    <option value="плодоношение">🍅 Плодоношение</option>
                                </select>
                            </div>
                            <div class="form-group" style="margin-top: 20px;">
                                <label class="agro-label">🌤️ Погода</label>
                                <div class="weather-grid" style="grid-template-columns: 1fr 1fr;">
                                    <label class="weather-item"><input type="checkbox" name="weather" value="засуха"> <span>☀️ Засуха</span></label>
                                    <label class="weather-item"><input type="checkbox" name="weather" value="дожди"> <span>🌧️ Дожди</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 32px;">
                        <button type="submit" class="btn-analyze" id="submitBtn" style="width:100%; display:flex; align-items:center; justify-content:center; gap:10px;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span id="submitBtnText">Начать анализ</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- HISTORY IN SIDEBAR -->
            <div class="premium-card" style="margin-top: 24px; padding: 24px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; opacity:0.7;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Последние кейсы
                </h3>
                <div id="analysesList" style="display: flex; flex-direction: column; gap: 16px;">
                    <p style="color: rgba(255, 255, 255, 0.2); text-align: center; font-size: 13px;">Исследований пока нет</p>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: LAB MODULE -->
        <div class="lab-module">
            <!-- IMAGING MODULE -->
            <div id="imagingModule" class="premium-card" style="padding: 0; min-height: 380px; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.4) !important; overflow: hidden; border-color: rgba(255,255,255,0.08);">
                <div id="photoDropZone" class="drop-zone" style="width: 100%; height: 100%; border: none; padding: 0;">
                    <input type="file" id="photoInput" accept="image/*" required style="display: none;">
                    
                    <!-- IDLE STATE -->
                    <div id="photoDropContent" style="display: flex; flex-direction: column; align-items: center; padding: 40px; position: relative;">
                        <!-- Camera Grid Overlay -->
                        <div style="position: absolute; inset: 20px; border: 10px solid transparent; border-image: radial-gradient(circle, var(--accent) 0%, transparent 100%) 1; opacity: 0.1;"></div>
                        
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                            <svg width="32" height="32" fill="none" stroke="var(--accent)" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        </div>
                        <h2 style="font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 8px;">Активация сенсора</h2>
                        <p style="color: rgba(255,255,255,0.4); font-size: 14px; margin-bottom: 24px;">Загрузите фото листа для инспекции</p>
                        
                        <div style="display: flex; gap: 20px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 24px;">
                            <div style="display:flex; align-items:center; gap:6px; font-size:11px; color:rgba(255,255,255,0.3);"><div style="width:4px; height:4px; border-radius:50%; background:var(--accent);"></div> Без бликов</div>
                            <div style="display:flex; align-items:center; gap:6px; font-size:11px; color:rgba(255,255,255,0.3);"><div style="width:4px; height:4px; border-radius:50%; background:var(--accent);"></div> Хороший фокус</div>
                            <div style="display:flex; align-items:center; gap:6px; font-size:11px; color:rgba(255,255,255,0.3);"><div style="width:4px; height:4px; border-radius:50%; background:var(--accent);"></div> Дневной свет</div>
                        </div>
                    </div>

                    <div id="preview" style="display: none; width: 100%; height: 100%; position: relative; background: #000;">
                        <div class="scan-line" style="position:absolute; top:0; left:0; width:100%; height:3px; background:var(--accent); box-shadow:0 0 15px var(--accent); z-index:10; display:none;"></div>
                        <img id="previewImg" style="width: 100%; height: 100%; object-fit: contain;">
                        <button type="button" onclick="clearPhoto()" style="position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer;">&times;</button>
                    </div>
                </div>
            </div>

            <!-- SIMPLIFIED STATUS CARDS -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div class="premium-card card-small">
                    <div style="font-size: 10px; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 12px; letter-spacing: 0.1em; opacity: 0.6;">Статус</div>
                    <div style="font-size: 15px; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 8px;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #9CAD9A;"></div>
                        Онлайн
                    </div>
                </div>
                <div class="premium-card card-small">
                    <div style="font-size: 10px; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 12px; letter-spacing: 0.1em; opacity: 0.6;">Модуль</div>
                    <div style="font-size: 15px; font-weight: 600; color: #fff;">Edge Node 4.2</div>
                </div>
                <div class="premium-card card-small">
                    <div style="font-size: 10px; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 12px; letter-spacing: 0.1em; opacity: 0.6;">Отклик</div>
                    <div style="font-size: 15px; font-weight: 600; color: #fff;">124 ms</div>
                </div>
            </div>

            <!-- LIVE LOGS / FEED -->
            <div class="premium-card" style="padding: 32px; flex: 1; border-color: rgba(132, 148, 131, 0.1); background: rgba(0,0,0,0.1) !important;">
                <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: var(--accent);">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2H6a2 2 0 00-2 2v16l4-2 4 2V4a2 2 0 00-2-2z"></path></svg>
                    Лог анализа в реальном времени
                </h3>
                <div id="aiLogs" style="font-family: 'Inter', monospace; font-size: 13px; color: rgba(255,255,255,0.4); line-height: 1.8;">
                    <div>[SYSTEM] Инициализация сенсорного модуля... OK</div>
                    <div>[SYSTEM] Проверка связи с облаком Agro AI... OK</div>
                    <div>[SENSOR] Ожидание поступления визуальных данных...</div>
                </div>
            </div>
        </div>
    </div>
<script>
    const cropsList = [
        'пшеница', 'ячмень', 'овес', 'рожь', 'кукуруза', 'рис', 'гречиха',
        'соя', 'горох', 'фасоль', 'чечевица', 'нут', 'люцерна', 'клевер',
        'подсолнечник', 'рапс', 'горчица', 'лен', 'конопля',
        'картофель', 'морковь', 'свекла', 'лук', 'чеснок', 'капуста', 'томаты', 'огурцы', 'перец', 'баклажаны',
        'яблоня', 'груша', 'вишня', 'слива', 'абрикос', 'персик', 'виноград',
        'хлопок', 'сахарная свекла', 'табак'
    ];

    let currentAnalysisId = null;

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function toggleExtraInfo() {
        const extraInfo = document.getElementById('extraInfo');
        const toggleIcon = document.getElementById('toggleIcon');
        const isHidden = window.getComputedStyle(extraInfo).display === 'none';

        if (isHidden) {
            extraInfo.style.display = 'block';
            toggleIcon.style.transform = 'rotate(180deg)';
        } else {
            extraInfo.style.display = 'none';
            toggleIcon.style.transform = 'rotate(0deg)';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        loadAnalyses();
        initCropAutocomplete();

        // Premium entrance animations
        gsap.from(".control-panel", { opacity: 0, x: -50, duration: 1, ease: "power4.out" });
        gsap.from(".lab-module", { opacity: 0, x: 50, duration: 1, ease: "power4.out", delay: 0.2 });

        const dropZone = document.getElementById('photoDropZone');
        const photoInput = document.getElementById('photoInput');

        if (dropZone && photoInput) {
            dropZone.addEventListener('click', () => photoInput.click());
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('active'); });
            dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('active'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('active');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    photoInput.files = e.dataTransfer.files;
                    handlePhotoSelect(file);
                }
            });
            photoInput.addEventListener('change', (e) => handlePhotoSelect(e.target.files[0]));
        }

        document.getElementById('uploadForm').addEventListener('submit', (e) => {
            e.preventDefault();
            uploadPhoto();
        });

        document.getElementById('toggleExtraInfoBtn').addEventListener('click', toggleExtraInfo);

        document.getElementById('openChatBtn').addEventListener('click', (e) => {
            e.preventDefault();
            if (currentAnalysisId) {
                window.location.href = `/chat?analysis_id=${currentAnalysisId}`;
            } else {
                alert('Сначала дождитесь завершения анализа');
            }
        });
    });

    function initCropAutocomplete() {
        const cropInput = document.getElementById('crop');
        const suggestionsDiv = document.getElementById('cropSuggestions');

        cropInput.addEventListener('input', function () {
            const value = this.value.toLowerCase().trim();
            if (value.length < 2) { suggestionsDiv.style.display = 'none'; return; }

            const matches = cropsList.filter(crop => crop.toLowerCase().includes(value));
            if (matches.length === 0) { suggestionsDiv.style.display = 'none'; return; }

            suggestionsDiv.innerHTML = matches.slice(0, 8).map(crop => `
                <div class="crop-suggestion" style="padding: 12px 16px; cursor: pointer; border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s; color: rgba(255,255,255,0.8); font-size: 14px;"
                     onmouseover="this.style.background='rgba(255,255,255,0.05)'"
                     onmouseout="this.style.background='transparent'"
                     onclick="selectCrop('${crop}')">
                    ${crop}
                </div>
            `).join('');
            suggestionsDiv.style.display = 'block';
        });

        document.addEventListener('click', (e) => {
            if (!cropInput.contains(e.target) && !suggestionsDiv.contains(e.target)) suggestionsDiv.style.display = 'none';
        });
    }

    function selectCrop(crop) {
        document.getElementById('crop').value = crop;
        document.getElementById('cropSuggestions').style.display = 'none';
    }

    function handlePhotoSelect(file) {
        if (!file) return;
        if (file.size > 20 * 1024 * 1024) { alert('⚠️ Файл слишком большой. Максимум 20MB'); return; }

        const reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById('preview').style.display = 'block';
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('photoDropContent').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }

    function clearPhoto() {
        document.getElementById('photoInput').value = '';
        document.getElementById('preview').style.display = 'none';
        document.getElementById('photoDropContent').style.display = 'block';
    }

    function addSymptom(symptom) {
        const symptomsInput = document.getElementById('symptoms');
        const currentText = symptomsInput.value.trim();
        symptomsInput.value = currentText ? `${currentText}, ${symptom}` : symptom;
        symptomsInput.focus();
    }

    function uploadPhoto() {
        const formData = new FormData();
        const photoInput = document.getElementById('photoInput');
        const crop = document.getElementById('crop').value;
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('submitBtnText');

        if (!photoInput.files[0] || !crop) { alert('⚠️ Заполните обязательные поля'); return; }

        formData.append('photo', photoInput.files[0]);
        formData.append('crop', crop);
        formData.append('growth_stage', document.getElementById('growthStage').value);
        formData.append('symptoms', document.getElementById('symptoms').value);

        const weather = Array.from(document.querySelectorAll('input[name="weather"]:checked')).map(cb => cb.value);
        if (weather.length > 0) formData.append('weather', JSON.stringify(weather));

        formData.append('problem_date', document.getElementById('problemDate').value);
        formData.append('care_info', document.getElementById('pastActions').value);

        
        btn.disabled = true;
        btnText.textContent = 'Сканирование...';
        const scanLine = document.querySelector('.scan-line');
        if(scanLine) {
            scanLine.style.display = 'block';
            scanLine.style.animation = 'scan 1.5s linear infinite';
        }


        fetch('/api/photo-analysis/upload', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    currentAnalysisId = data.analysis_id;
                    pollResult(data.analysis_id);
                } else throw new Error(data.error);
            })
            .catch(err => { alert('❌ Ошибка: ' + err.message); btn.disabled = false; btnText.textContent = 'Начать анализ снимка'; });
    }

    function addSystemLog(msg) {
        const logs = document.getElementById('aiLogs');
        if (!logs) return;
        const entry = document.createElement('div');
        entry.textContent = `[${new Date().toLocaleTimeString()}] ${msg}`;
        entry.style.opacity = '0';
        logs.prepend(entry);
        gsap.to(entry, { opacity: 1, duration: 0.5 });
        if (logs.children.length > 8) logs.lastElementChild.remove();
    }

    // Simulate occasional activity
    setInterval(() => {
        if (Math.random() > 0.8) {
            const msgs = [
                "Калибровка линз сенсора...",
                "Синхронизация с базой данных GreenVisi...",
                "Анализ спектральных данных...",
                "Поиск паттернов в базе знаний...",
                "Проверка целостности нейронной сети..."
            ];
            addSystemLog(msgs[Math.floor(Math.random() * msgs.length)]);
        }
    }, 5000);

    function pollResult(id) {
        addSystemLog("Запрос данных с облачного сервера...");
        const resultDiv = document.getElementById('analysisResult');
        const contentDiv = document.getElementById('analysisContent');
        resultDiv.style.display = 'block';
        contentDiv.innerHTML = '<div style="text-align:center; padding: 40px; color: rgba(255,255,255,0.5);">Анализируем снимок с помощью ИИ... <div class="spinner"></div></div>';
        resultDiv.scrollIntoView({ behavior: 'smooth' });

        const interval = setInterval(() => {
            fetch(`/api/photo-analysis/${id}`)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        if (data.analysis.status === 'completed') {
                            clearInterval(interval);
                            renderResult(data.analysis);
                            loadAnalyses();
                            document.getElementById('submitBtn').disabled = false;
                            document.getElementById('submitBtnText').textContent = 'Начать анализ снимка';
                        } else if (data.analysis.status === 'error') {
                            clearInterval(interval);
                            contentDiv.innerHTML = '<div style="text-align:center; padding: 40px; color: #ff6b6b;">❌ Ошибка анализа. Попробуйте загрузить фото еще раз или проверьте интернет-соединение.</div>';
                            document.getElementById('submitBtn').disabled = false;
                            document.getElementById('submitBtnText').textContent = 'Начать анализ снимка';
                        }
                    }
                });
        }, 2000);
    }

    function renderResult(analysis) {
        // Stop scanning animation
        const scanLine = document.querySelector('.scan-line');
        if(scanLine) {
            scanLine.style.animation = 'none';
            scanLine.style.display = 'none';
        }

        const content = document.getElementById('analysisContent');
        const predictions = typeof analysis.predictions === 'string' ? JSON.parse(analysis.predictions) : analysis.predictions;
        const triageLevel = predictions.triage_level || 'low';

        const triageClasses = {
            'critical': 'triage-critical',
            'medium': 'triage-medium',
            'low': 'triage-low'
        };

        let html = `
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">
                <div>
                    <img src="${analysis.photo_uri}" style="width: 100%; border-radius: 18px; border: 1px solid var(--border-color);">
                </div>
                <div>
                    <div style="margin-bottom: 24px; background: rgba(156, 173, 154, 0.05); padding: 24px; border-radius: 18px; border: 1px solid rgba(156, 173, 154, 0.15);">
                        <div style="font-size: 11px; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 8px; letter-spacing: 0.05em;">Заключение ИИ</div>
                        <div style="font-size: 20px; font-weight: 700; color: #fff; font-family: 'Playfair Display', serif;">
                            ${escapeHtml(predictions.diagnosis?.problem || 'Анализ завершен')}
                        </div>
                    </div>
                    <div class="ai-analysis-text" style="color: rgba(255,255,255,0.7); line-height: 1.7; font-size: 15px;">
                        ${predictions.ai_response || 'Данные обрабатываются...'}
                    </div>
                </div>
            </div>
        `;
        content.innerHTML = html;

        // Animate results entry
        gsap.from(".ai-analysis-text", {
            opacity: 0,
            x: 20,
            duration: 0.6,
            ease: "power2.out"
        });
    }

    function loadAnalyses() {
        fetch('/api/photo-analysis')
            .then(r => r.json())
            .then(data => {
                if (data.success && data.analyses) {
                    const list = document.getElementById('analysesList');
                    if (data.analyses.length === 0) return;

                    list.innerHTML = data.analyses.map(a => {
                        const pred = typeof a.predictions === 'string' ? JSON.parse(a.predictions) : a.predictions;
                        const triage = pred?.triage_level || 'low';
                        const diag = pred?.diagnosis?.problem || 'Анализ';

                        return `
                            <div class="analysis-history-item" onclick="window.location.href='/chat?analysis_id=${a.id}'" style="padding: 12px; border-radius: 16px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); display: flex; gap: 12px; align-items: center; cursor: pointer; transition: all 0.2s;">
                                <img src="${a.photo_uri}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px;">
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 600; font-size: 13px; color: #fff; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">${escapeHtml(a.crop || 'Растение')}</div>
                                    <div style="font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 2px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">${escapeHtml(diag)}</div>
                                </div>
                                <span class="triage-badge ${triage === 'critical' ? 'triage-critical' : (triage === 'medium' ? 'triage-medium' : 'triage-low')}" style="font-size: 9px; padding: 2px 6px;">${triage}</span>
                            </div>
                        `;
                    }).join('');

                    gsap.from(".analysis-history-item", {
                        opacity: 0,
                        x: -20,
                        duration: 0.5,
                        stagger: 0.1,
                        ease: "power2.out"
                    });
                }
            });
    }
</script>
</div><!-- /.photo-analysis-page -->
</div><!-- /.dash-page-content -->
</main><!-- /.dash-main -->
</div><!-- /.dashboard-wrapper -->
<script>
fetch('/api/auth/me').then(r=>r.json()).then(d=>{
    if(d && d.email){
        var el=document.getElementById('sidebarAvatarInitials');
        var nm=document.getElementById('sidebarUserName');
        if(el) el.textContent=(d.email||'U').substring(0,2).toUpperCase();
        if(nm) nm.textContent=d.email.split('@')[0];
    }
}).catch(()=>{});
</script>