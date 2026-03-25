import codecs
import re

path = 'c:/Users/bekbo/Desktop/работа проекта 2/views/photo-analysis.php'
with codecs.open(path, 'r', 'utf-8') as f:
    content = f.read()

# 1. Update Global Styles and Layout
style_old = """        .premium-card {
            background: var(--e-glass);
            border: 1px solid var(--e-border);
            backdrop-filter: blur(24px);
            border-radius: 32px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: var(--shadow-3d);
        }"""

style_new = """        .premium-card {
            background: rgba(20, 22, 18, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            border-radius: 24px;
            padding: 32px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        }
        
        .split-layout {
            display: grid;
            grid-template-columns: 440px 1fr;
            gap: 40px;
            align-items: start;
        }

        .control-panel {
            position: sticky;
            top: 20px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .lab-module {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }"""

content = content.replace(style_old, style_new)

# 2. Restructure the Main HTML into Split Layout
# Find the start of the title/p section
header_marker = """<div style="margin-bottom: 48px; position: relative; z-index: 10;">"""
main_content_start = """<div
        style="display: grid; grid-template-columns: repeat(12, 1fr); gap: 32px; align-items: start; position: relative; z-index: 10;">"""

# We'll replace the entire main container part
body_pattern = r'<div\s+style="display: grid; grid-template-columns: repeat\(12, 1fr\); gap: 32px; align-items: start; position: relative; z-index: 10;">[\s\S]*?</div>\s*</div>\s*</div>\s*</div>'
# This is tricky because of nested divs. 
# Let's find the `uploadForm` and the `analysesList` instead.

# Re-building the main container
new_layout = """
    <div class="split-layout" style="position: relative; z-index: 10;">
        <!-- LEFT COLUMN: CONTROL PANEL -->
        <div class="control-panel">
            <div class="premium-card">
                <form id="uploadForm" enctype="multipart/form-data">
                    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; color: #fff; font-family: 'Playfair Display', serif;">
                        <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        Конфигуратор анализа
                    </h2>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="agro-label">Культура / Растение *</label>
                        <div style="position: relative;">
                            <input type="text" class="agro-input" id="crop" placeholder="Напр: Томаты, Пшеница..." required autocomplete="off">
                            <div id="cropSuggestions" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #1a1a1a; border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; max-height: 200px; overflow-y: auto; z-index: 1000; margin-top: 8px;"></div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="agro-label">Симптомы / Описание</label>
                        <textarea class="agro-input" id="symptoms" rows="3" placeholder="Опишите проблему своими словами..."></textarea>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px;">
                            <div class="symptom-pill" onclick="addSymptom('желтеют листья')">Желтизна</div>
                            <div class="symptom-pill" onclick="addSymptom('пятна')">Пятна</div>
                            <div class="symptom-pill" onclick="addSymptom('вялое')">Вялое</div>
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
            <!-- PHOTO DROP ZONE -->
            <div id="imagingModule" class="premium-card" style="padding: 0; min-height: 400px; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.2) !important;">
                <div id="photoDropZone" class="drop-zone" style="width: 100%; height: 100%; border: none; background: transparent; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px;">
                    <input type="file" id="photoInput" accept="image/*" required style="display: none;">
                    
                    <div id="photoDropContent" style="display: flex; flex-direction: column; align-items: center;">
                        <div class="scanner-ring" style="width: 120px; height: 120px; border-radius: 50%; border: 2px dashed var(--primary); display: flex; align-items: center; justify-content: center; margin-bottom: 24px; position: relative;">
                            <svg width="48" height="48" fill="none" stroke="var(--primary)" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        </div>
                        <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: #fff;">Загрузите снимок</h2>
                        <p style="color: rgba(255,255,255,0.4); font-size: 15px;">Перетащите фото листа или растения для ИИ-сканирования</p>
                    </div>

                    <div id="preview" style="display: none; width: 100%; height: 100%; position: relative;">
                        <div class="scan-line" style="position:absolute; top:0; left:0; width:100%; height:2px; background:var(--primary); box-shadow:0 0 15px var(--primary); z-index:10; display:none;"></div>
                        <img id="previewImg" style="width: 100%; height: 100%; object-fit: contain; border-radius: 20px;">
                        <button type="button" onclick="clearPhoto()" style="position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.6); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer;">&times;</button>
                    </div>
                </div>
            </div>

            <!-- RESULT DISPLAY -->
            <div id="analysisResult" style="display: none; animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);">
                <div class="premium-card" style="border-color: var(--primary); border-width: 2px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h2 style="font-size: 24px; font-weight: 800; font-family: 'Playfair Display', serif; color: var(--primary);">Протокол исследования</h2>
                        <a href="#" id="openChatBtn" class="btn-analyze" style="padding: 10px 24px; font-size: 14px; text-decoration: none; box-shadow: none;">Открыть ИИ-Чат</a>
                    </div>
                    <div id="analysisContent"></div>
                </div>
            </div>
        </div>
    </div>
"""

# Now we need to carefully replace the block.
# I'll just find the main div with max-width 1400px and replace its content after the title.

header_end_idx = content.find(header_marker) + content[content.find(header_marker):].find("</div>") + 6
footer_start_idx = content.rfind("<script>")

content = content[:header_end_idx] + new_layout + content[footer_start_idx:]

# 3. Adjust CSS for Animations
content = content.replace("@keyframes spin {", """
        @keyframes slideDown { 0% { opacity:0; transform:translateY(-10px); } 100% { opacity:1; transform:translateY(0); } }
        @keyframes slideUp { 0% { opacity:0; transform:translateY(20px); } 100% { opacity:1; transform:translateY(0); } }
        @keyframes scan { 0% { top: 0%; } 100% { top: 100%; } }
        
        @keyframes spin {""")

# 4. Adjust history item to be more compact for sidebar
# Finding the template in JS
history_template_old = """<div class="premium-card analysis-history-item" style="margin-bottom: 20px; padding: 24px; display: flex; gap: 24px; align-items: center; background: rgba(255,255,255,0.02);">
                                <img src="${a.photo_uri}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1);">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                                        <div style="font-weight: 800; font-size: 18px; font-family: 'Playfair Display', serif;">${escapeHtml(a.crop || 'Растение')}</div>
                                        <span class="triage-badge ${triage === 'critical' ? 'triage-critical' : (triage === 'medium' ? 'triage-medium' : 'triage-low')}" style="font-size: 9px; padding: 2px 8px;">${triage}</span>
                                    </div>
                                    <div style="font-size: 14px; color: rgba(255,255,255,0.85); margin-bottom: 4px; word-break: break-word;">${escapeHtml(diag)}</div>
                                    <div style="font-size: 11px; opacity: 0.3;">${new Date(a.created_at).toLocaleString('ru-RU')}</div>
                                </div>
                                <a href="/chat?analysis_id=${a.id}" class="btn-analyze" style="padding: 10px 20px; font-size: 11px; text-decoration: none; box-shadow: none;">Консультация</a>
                            </div>"""

history_template_new = """<div class="analysis-history-item" onclick="window.location.href='/chat?analysis_id=${a.id}'" style="padding: 16px; border-radius: 16px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); display: flex; gap: 16px; align-items: center; cursor: pointer; transition: all 0.3s;">
                                <img src="${a.photo_uri}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1);">
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 700; font-size: 14px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">${escapeHtml(a.crop || 'Растение')}</div>
                                    <div style="font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 4px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">${escapeHtml(diag)}</div>
                                </div>
                                <span class="triage-badge ${triage === 'critical' ? 'triage-critical' : (triage === 'medium' ? 'triage-medium' : 'triage-low')}" style="font-size: 8px; padding: 2px 6px;">${triage}</span>
                            </div>"""

content = content.replace(history_template_old, history_template_new)

# 5. Add Scanning Animation Logic to uploadPhoto
scanning_logic = """
        btn.disabled = true;
        btnText.textContent = 'Сканирование...';
        const scanLine = document.querySelector('.scan-line');
        if(scanLine) {
            scanLine.style.display = 'block';
            scanLine.style.animation = 'scan 1.5s linear infinite';
        }
"""
content = content.replace("btn.disabled = true;\n        btnText.textContent = 'Обработка данных...';", scanning_logic)

with codecs.open(path, 'w', 'utf-8') as f:
    f.write(content)
print("SUCCESS!")
