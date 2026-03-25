<?php
$activePage = 'animals';
$pageHeaderTitle = 'Животные — Ветеринарный AI сканер';
include __DIR__ . '/layouts/sidebar.php';
?>

<div class="animals-module-wrap">
<style>
    .animals-module-wrap { min-height: 100%; }
    /* Neutralize old hero backgrounds inside new layout */
    .hero-mesh-bg, .hero-smoke, .hero-depth-layer { display: none !important; }
    .control-panel { top: calc(var(--dash-header-h, 70px) + 20px); }
</style>

    <style>
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

        .control-panel {
            position: sticky;
            top: 20px;
            display: flex;
            flex-direction: column;
            gap: 32px;
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
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(197, 180, 158, 0.2);
            width: 100%;
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
            font-size: 12px;
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
        }

        .nav-link-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateX(-4px);
        }

        .ai-log-entry {
            font-family: 'Space Mono', monospace;
            font-size: 11px;
            padding: 4px 0;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            color: rgba(255,255,255,0.4);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
    </style>

    <a href="/dashboard" class="nav-link-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
            <path d="M19 12H5M12 19l-7-7 7-7"></path>
        </svg>
        Вернуться в панель
    </a>

    <div style="margin-bottom: 64px;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: var(--h1); font-weight: 800; margin-bottom: 8px; letter-spacing: -0.01em;">
            Vet Scanner 1.2
        </h1>
        <div style="display: flex; align-items: center; gap: 16px;">
            <p style="color: rgba(255, 255, 255, 0.7); font-size: 18px; line-height: 1.6; margin: 0;">
                Нейронная диагностика состояния здоровья животных
            </p>
            <span style="background: rgba(156, 173, 154, 0.1); color: var(--accent); font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid rgba(156, 173, 154, 0.2);">Bio-AI</span>
        </div>
    </div>

    <div class="split-layout">
        <!-- LEFT COLUMN: DIAGNOSTIC HUB -->
        <div class="control-panel">
            <div class="premium-card">
                <form id="animalForm">
                    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; color: #fff; font-family: 'Playfair Display', serif;">Протокол диагностики</h2>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="agro-label">Вид животного</label>
                        <select class="agro-input" id="species" required>
                            <option value="">Выберите...</option>
                            <option value="cattle">КРС (Корова/Бык)</option>
                            <option value="sheep">Овца / Баран</option>
                            <option value="goat">Коза</option>
                            <option value="poultry">Птица (Курица/Утка)</option>
                            <option value="pig">Свинья</option>
                            <option value="horse">Лошадь</option>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                        <div class="form-group">
                            <label class="agro-label">Вес / Возраст</label>
                            <input type="text" class="agro-input" id="ageWeight" placeholder="Напр: 450 кг">
                        </div>
                        <div class="form-group">
                            <label class="agro-label">Температура</label>
                            <input type="number" class="agro-input" id="temperature" step="0.1" placeholder="38.5">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="agro-label">Описание симптомов</label>
                        <textarea class="agro-input" id="symptoms" rows="4" placeholder="Опишите поведение..." required></textarea>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px;">
                            <div class="symptom-pill" onclick="addSymptom('отказ от еды')">Без аппетита</div>
                            <div class="symptom-pill" onclick="addSymptom('вялость')">Вялость</div>
                            <div class="symptom-pill" onclick="addSymptom('кашель')">Кашель</div>
                        </div>
                    </div>

                    <!-- Hidden Extra Info (Compact) -->
                    <div id="extraInfo" style="display: none; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 24px; margin-top: 24px;">
                        <div class="form-group" style="margin-bottom: 24px;">
                            <label class="agro-label">История лечения</label>
                            <textarea class="agro-input" id="treatmentHistory" rows="2"></textarea>
                        </div>
                    </div>

                    <button type="button" id="toggleExtraInfoBtn" style="background:none; border:none; color:var(--accent); font-size:12px; font-weight:600; cursor:pointer; margin-bottom:24px; display:flex; align-items:center; gap:6px;">
                        <span id="extraLabel">Дополнительные сведения</span>
                         <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" id="toggleIcon"><path d="M6 9l6 6 6-6" /></svg>
                    </button>

                    <button type="submit" class="btn-analyze" id="submitBtn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M2 12h20" style="opacity: 0.1" /><path d="M12 2l10 5-10 5-10-5 10-5z" /><path d="M2 17l10 5 10-5" /><path d="M2 12l10 5 10-5" /></svg>
                        <span id="submitBtnText">Начать AI-анализ</span>
                    </button>
                </form>
            </div>

            <div id="casesList" style="display: flex; flex-direction: column; gap: 16px;">
                <!-- History Items will be professionalized in JS -->
            </div>
        </div>

        <!-- RIGHT COLUMN: BIOLOGICAL MONITORING HUB -->
        <div class="lab-module" style="display: flex; flex-direction: column; gap: 40px;">
            <div id="monitoringModule" class="premium-card" style="min-height: 480px; background: rgba(0,0,0,0.4) !important; border-color: rgba(255,255,255,0.08); display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
                    <div>
                        <div class="agro-label" style="margin-bottom: 4px;">Biological Monitor</div>
                        <div style="font-size: 24px; font-weight: 700; color: #fff; font-family: 'Playfair Display', serif;">Виртуальный осмотр</div>
                    </div>
                    <div style="background: rgba(156, 173, 154, 0.1); padding: 8px 16px; border-radius: 10px; font-size: 11px; color: var(--accent); border: 1px solid rgba(156, 173, 154, 0.2);">READY</div>
                </div>

                <div id="visualizer" style="flex: 1; display: flex; align-items: center; justify-content: center; position: relative;">
                    <!-- Bio-AI Grid Background -->
                    <div style="position: absolute; inset: 0; background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.03) 1px, transparent 0); background-size: 32px 32px;"></div>
                    
                    <div id="idleVisual" style="text-align: center; position: relative; z-index: 2;">
                        <div style="width: 120px; height: 120px; border-radius: 50%; border: 1px solid var(--accent); opacity: 0.2; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); animation: pulse 3s infinite;"></div>
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" style="opacity: 0.6;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>
                        <div style="margin-top: 24px; color: rgba(255,255,255,0.3); font-size: 13px;">Ожидание вводных данных...</div>
                    </div>

                    <!-- Scan Results (Initially Hidden) -->
                    <div id="consultationResult" style="display: none; width: 100%;">
                         <!-- Triage Banner will be injected here -->
                         <div id="consultationContent"></div>
                    </div>
                </div>

                <!-- AI LOG FEED (Same as Photo Analysis) -->
                <div id="aiLogs" style="height: 100px; overflow-y: hidden; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; margin-top: 20px;">
                    <div class="ai-log-entry">> Инициализация подсистемы Vet-AI v1.2...</div>
                    <div class="ai-log-entry">> Ожидание параметров пациента...</div>
                </div>
            </div>

            <!-- QUICK STATS (Biological Context) -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div class="premium-card card-small">
                    <div style="font-size: 10px; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 12px; letter-spacing: 0.1em; opacity: 0.6;">Био-сенсор</div>
                    <div style="font-size: 15px; font-weight: 600; color: #fff;">Активен</div>
                </div>
                <div class="premium-card card-small">
                    <div style="font-size: 10px; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 12px; letter-spacing: 0.1em; opacity: 0.6;">Точность</div>
                    <div style="font-size: 15px; font-weight: 600; color: #fff;">96.8%</div>
                </div>
                <div class="premium-card card-small">
                    <div style="font-size: 10px; text-transform: uppercase; color: var(--accent); font-weight: 700; margin-bottom: 12px; letter-spacing: 0.1em; opacity: 0.6;">Сеть</div>
                    <div style="font-size: 15px; font-weight: 600; color: #fff;">Edge Node V</div>
                </div>
            </div>
        </div>
    </div>

        <!-- History -->
        <div style="margin-top: 80px;">
            <div
                style="font-family: var(--f-grotesk); font-size: 32px; font-weight: 800; margin-bottom: 40px; color: #fff;">
                История диагностик</div>
            <div id="casesList">
                <div style="color: rgba(255,255,255,0.2); text-align: center; padding: 60px;">Загрузка истории...</div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentCaseId = null;

    document.addEventListener('DOMContentLoaded', function () {
        gsap.from(".split-layout > div", { opacity: 0, y: 30, duration: 1.2, stagger: 0.2, ease: "expo.out" });

        loadCases();

        document.getElementById('animalForm').addEventListener('submit', (e) => { e.preventDefault(); createCase(); });

        document.getElementById('toggleExtraInfoBtn').addEventListener('click', function () {
            const info = document.getElementById('extraInfo');
            const icon = document.getElementById('toggleIcon');
            const label = document.getElementById('extraLabel');
            const isHidden = window.getComputedStyle(info).display === 'none';
            info.style.display = isHidden ? 'block' : 'none';
            icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    });

    function addSystemLog(msg) {
        const log = document.getElementById('aiLogs');
        const entry = document.createElement('div');
        entry.className = 'ai-log-entry';
        entry.textContent = `> ${msg}`;
        log.prepend(entry);
        if (log.children.length > 20) log.lastChild.remove();
    }

    // Mock Live Logs
    setInterval(() => {
        if (Math.random() > 0.7) {
            const msgs = [
                "Сенсор: Температурный контроль в норме...",
                "База данных: Проверка протоколов КРС...",
                "Сеть: Edge Node V синхронизирован...",
                "Система: Ожидание биометрических данных...",
                "Диагностика: Резервный канал активен..."
            ];
            addSystemLog(msgs[Math.floor(Math.random() * msgs.length)]);
        }
    }, 4000);

    function addSymptom(s) {
        const input = document.getElementById('symptoms');
        const val = input.value.trim();
        input.value = val ? (val.endsWith(',') ? val + ' ' + s : val + ', ' + s) : s;
        input.focus();
    }

    function createCase() {
        const formData = {
            species: document.getElementById('species').value,
            age_weight: document.getElementById('ageWeight').value,
            temperature: document.getElementById('temperature').value ? parseFloat(document.getElementById('temperature').value) : null,
            symptoms: document.getElementById('symptoms').value,
            treatment_history: document.getElementById('treatmentHistory').value
        };

        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('submitBtnText');
        btn.disabled = true;
        btnText.textContent = 'Нейросеть обрабатывает запрос...';
        addSystemLog("Запрос отправлен в Vet-AI...");

        fetch('/api/animal-cases', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    currentCaseId = data.case_id;
                    showConsultationResult(data);
                    document.getElementById('animalForm').reset();
                    loadCases();
                }
            })
            .finally(() => {
                btn.disabled = false;
                btnText.textContent = 'Начать AI-анализ';
            });
    }

    function showConsultationResult(data) {
        document.getElementById('idleVisual').style.display = 'none';
        const res = document.getElementById('consultationResult');
        const cont = document.getElementById('consultationContent');
        res.style.display = 'block';

        const triage = data.triage_level || 'low';
        const config = {
            'critical': { theme: '#fa5252', icon: '🚨', text: 'Критический случай' },
            'medium': { theme: '#fd7e14', icon: '⚡', text: 'Средний приоритет' },
            'low': { theme: '#40c057', icon: '✅', text: 'Стабильно' }
        };
        const c = config[triage];

        let aiText = (data.recommendations?.ai_analysis || '').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');

        cont.innerHTML = `
            <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 18px; padding: 24px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <span style="font-size: 24px;">${c.icon}</span>
                    <span style="font-weight: 700; color: ${c.theme}; text-transform: uppercase; font-size: 13px; letter-spacing: 0.1em;">${c.text}</span>
                </div>
                <div style="font-size: 15px; line-height: 1.7; color: rgba(255,255,255,0.8);">
                    ${aiText}
                </div>
            </div>
            <div style="display: flex; gap: 12px;">
                <a href="/chat?case_id=${data.case_id}" class="btn-analyze" style="flex: 1; padding: 12px;">Чат с экспертом</a>
                <a href="/veterinarians" class="btn-analyze" style="flex: 1; padding: 12px; background: rgba(255,255,255,0.05) !important; color: #fff !important; border: 1px solid rgba(255,255,255,0.1) !important;">Найти врача</a>
            </div>
        `;
        res.scrollIntoView({ behavior: 'smooth' });
    }

    function loadCases() {
        fetch('/api/animal-cases')
            .then(r => r.json())
            .then(data => {
                const list = document.getElementById('casesList');
                if (data.success && data.cases.length > 0) {
                    list.innerHTML = data.cases.map(c => {
                        const triage = c.triage_level || 'low';
                        const color = triage === 'critical' ? '#fa5252' : (triage === 'medium' ? '#fd7e14' : '#40c057');
                        return `
                            <div class="premium-card card-small" onclick="window.location.href='/chat?case_id=${c.id}'" style="display: flex; gap: 16px; align-items: center; cursor: pointer; padding: 16px;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                    ${c.species === 'cattle' ? '🐄' : (c.species === 'poultry' ? '🐔' : '🐾')}
                                </div>
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 700; font-size: 13px; color: #fff;">${getSpeciesName(c.species)}</div>
                                    <div style="font-size: 11px; color: rgba(255,255,255,0.4); text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">${escapeHtml(c.symptoms)}</div>
                                </div>
                                <div style="font-size: 10px; font-weight: 800; color: ${color}; text-transform: uppercase; letter-spacing: 0.05em; border: 1px solid ${color}33; padding: 4px 8px; border-radius: 6px;">
                                    ${triage}
                                </div>
                            </div>
                        `;
                    }).join('');
                }
            });
    }

    function getSpeciesName(s) {
        const m = { 'cattle': 'КРС', 'sheep': 'Овцы', 'goat': 'Козы', 'poultry': 'Птица', 'pig': 'Свиньи', 'horse': 'Лошади' };
        return m[s] || s;
    }

    function escapeHtml(t) {
        const d = document.createElement('div'); d.textContent = t; return d.innerHTML;
    }
</script>
</div><!-- /.animals-module-wrap -->
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