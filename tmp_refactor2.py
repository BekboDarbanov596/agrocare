import codecs

path = 'c:/Users/bekbo/Desktop/работа проекта 2/views/plan.php'
with codecs.open(path, 'r', 'utf-8') as f:
    content = f.read()

# Using regex or split to extract the exact blocks is safer.
# Find the start of the form:
start_marker = """<form id="planForm">"""
end_marker = """</form>"""

if start_marker in content and end_marker in content:
    pre_form = content.split(start_marker)[0]
    post_form = content.split(end_marker)[1]
    
    new_form = """<form id="planForm">
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
        </form>"""
    
    content = pre_form + new_form + post_form

# We should also replace the JS that handles `goToStep` and fieldSelect behavior.
# We'll inject goToStep inside the script tag.
js_insert = """
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
"""

# Let's insert the `goToStep` logic inside the script
content = content.replace("function onFarmChange(farmId)", js_insert + "\n    function onFarmChange(farmId)")

# Finally, we want the field details card to appear smoothly inside step 1
display_fixes = """
                    const fieldMetaCard = document.getElementById('fieldMetaCard');
                    if (areaDisplay) areaDisplay.textContent = area + ' га';
                    if (regionDisplay) regionDisplay.textContent = region;
                    if (fieldMetaCard) fieldMetaCard.style.display = 'block';
"""
content = content.replace("""                    if (areaDisplay) areaDisplay.textContent = area + ' га';
                    if (regionDisplay) regionDisplay.textContent = region;""", display_fixes)


# Also add hide logic if no field:
display_hide = """                    if (areaDisplay) areaDisplay.textContent = '-- га';
                    if (regionDisplay) regionDisplay.textContent = '--';
                    const fieldMetaCard = document.getElementById('fieldMetaCard');
                    if (fieldMetaCard) fieldMetaCard.style.display = 'none';"""
content = content.replace("""                    if (areaDisplay) areaDisplay.textContent = '-- га';
                    if (regionDisplay) regionDisplay.textContent = '--';""", display_hide)


with codecs.open(path, 'w', 'utf-8') as f:
    f.write(content)
print("SUCCESS!")
