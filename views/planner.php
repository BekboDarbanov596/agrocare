<?php
$MONTH_NAMES = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
$activePage = 'planner';
$pageHeaderTitle = 'Планировщик — Задачи и рекомендации';
include __DIR__ . '/layouts/sidebar.php';
?>

<style>
    .planner-page { --gold: #b4a18a; --sage: #869689; --f-sans: 'Inter', sans-serif; --f-grotesk: 'Space Grotesk', sans-serif; }
    .planner-page { min-height: 100vh; background: #0e0c0b; color: #fff; font-family: var(--f-sans); display: flex; position: relative; }
    .planner-sidebar { width: 100px; background: rgba(255,255,255,0.02); border-right: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; align-items: center; padding: 40px 0; }
    .planner-sidebar .nav-item { width: 54px; height: 54px; border-radius: 18px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.3); margin-bottom: 24px; cursor: pointer; transition: all 0.3s; }
    .planner-sidebar .nav-item:hover, .planner-sidebar .nav-item.active { color: var(--gold); background: rgba(180,161,138,0.1); }
    .planner-main { flex: 1; padding: 40px 60px; display: flex; flex-direction: column; position: relative; z-index: 10; overflow-y: auto; }
    .planner-header { margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px; }
    .planner-header h1 { font-family: var(--f-grotesk); font-size: 42px; font-weight: 800; letter-spacing: -0.04em; margin: 0 0 4px 0; }
    .planner-header p { color: rgba(255,255,255,0.75); font-size: 15px; margin: 0; }
    .planner-header .btn-create { background: var(--gold); color: #000; border: none; border-radius: 100px; padding: 12px 24px; font-size: 14px; font-weight: 700; cursor: pointer; transition: 0.3s; }
    .planner-header .btn-create:hover { filter: brightness(1.1); transform: scale(1.02); }
    .calendar-layout { display: grid; grid-template-columns: 1fr 340px; gap: 32px; flex: 1; align-items: start; }
    .calendar-card { background: #1a1816; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 28px; }
    .calendar-card .month-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .calendar-card .month-row h2 { font-family: var(--f-grotesk); font-size: 22px; font-weight: 800; margin: 0; color: #fff; }
    .calendar-card .month-nav { display: flex; gap: 8px; }
    .calendar-card .month-nav button { width: 40px; height: 40px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: #fff; font-size: 18px; cursor: pointer; transition: 0.3s; }
    .calendar-card .month-nav button:hover { background: rgba(255,255,255,0.1); border-color: var(--gold); }
    .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; }
    .calendar-grid .day-name { text-align: center; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.7); padding: 8px 0; }
    .calendar-grid .day-cell { aspect-ratio: 1; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 8px; cursor: pointer; transition: 0.2s; min-height: 44px; display: flex; flex-direction: column; }
    .calendar-grid .day-cell:hover { background: rgba(255,255,255,0.06); border-color: rgba(180,161,138,0.3); }
    .calendar-grid .day-cell.active { border-color: var(--gold); background: rgba(180,161,138,0.08); }
    .calendar-grid .day-cell.other-month { opacity: 0.4; }
    .calendar-grid .day-cell .day-num { font-weight: 700; font-size: 13px; }
    .calendar-grid .day-cell .day-dots { margin-top: 4px; display: flex; flex-direction: column; gap: 2px; }
    .calendar-grid .day-cell .day-dot { height: 3px; border-radius: 2px; background: var(--sage); }
    .calendar-grid .day-cell .day-dot.gold { background: var(--gold); }
    .ai-block { display: flex; flex-direction: column; gap: 20px; }
    .ai-block h3 { font-family: var(--f-grotesk); font-size: 18px; font-weight: 800; margin: 0 0 4px 0; color: #fff; }
    .ai-card { background: rgba(134,150,137,0.06); border: 1px solid rgba(134,150,137,0.12); border-radius: 20px; padding: 20px; position: relative; transition: 0.3s; }
    .ai-card:hover { border-color: var(--sage); background: rgba(134,150,137,0.1); }
    .ai-card.is-done { opacity: 0.55; pointer-events: none; }
    .ai-card.is-done .ai-card-btn { display: none; }
    .ai-card.is-done .ai-done-text { display: block !important; font-size: 13px; color: #c8ddcb; font-weight: 700; margin-top: 10px; }
    .ai-done-text { display: none; }
    .ai-card::before { content: 'AI'; position: absolute; top: 12px; right: 12px; background: var(--sage); color: #000; font-size: 9px; font-weight: 900; padding: 2px 6px; border-radius: 4px; }
    .ai-card-title { font-weight: 700; font-size: 14px; color: #b0c4b3; margin-bottom: 6px; }
    .ai-card-body { font-size: 13px; color: rgba(255,255,255,0.88); line-height: 1.45; }
    .ai-card-btn { margin-top: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.12); color: #fff; font-size: 12px; font-weight: 700; padding: 8px 14px; border-radius: 10px; cursor: pointer; transition: 0.3s; }
    .ai-card-btn:hover { background: var(--sage); color: #000; }
    .planner-modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 10000; align-items: center; justify-content: center; padding: 20px; }
    .planner-modal.is-open { display: flex; }
    .planner-modal-box { background: #1a1816; border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 28px; max-width: 420px; width: 100%; max-height: 90vh; overflow-y: auto; }
    .planner-modal-box h3 { font-family: var(--f-grotesk); font-size: 20px; margin: 0 0 20px 0; color: #fff; font-weight: 800; }
    .planner-modal-box label { display: block; font-size: 13px; color: rgba(255,255,255,0.85); margin-bottom: 6px; font-weight: 600; }
    .planner-modal-box input, .planner-modal-box textarea { width: 100%; box-sizing: border-box; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; padding: 10px 14px; color: #fff; font-size: 15px; margin-bottom: 14px; }
    .planner-modal-box input::placeholder, .planner-modal-box textarea::placeholder { color: rgba(255,255,255,0.5); }
    .planner-modal-box textarea { min-height: 72px; resize: vertical; }
    .planner-modal-actions { display: flex; gap: 10px; margin-top: 20px; }
    .planner-modal-actions button { flex: 1; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer; border: none; transition: 0.3s; }
    .planner-modal-save { background: var(--gold); color: #000; }
    .planner-modal-cancel { background: rgba(255,255,255,0.12); color: #fff; border: 1px solid rgba(255,255,255,0.25); }
    .day-tasks-list { list-style: none; margin: 0; padding: 0; }
    .day-tasks-list li { padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; gap: 12px; color: #fff; font-size: 15px; }
    .day-tasks-list li:last-child { border-bottom: none; }
    .day-tasks-list .task-delete { background: none; border: none; color: rgba(255,255,255,0.4); cursor: pointer; padding: 4px 8px; font-size: 18px; line-height: 1; }
    .day-tasks-list .task-delete:hover { color: #e55; }
    .day-modal-quick { margin-bottom: 20px; }
    .day-modal-quick label { display: block; font-size: 13px; color: rgba(255,255,255,0.9); margin-bottom: 8px; font-weight: 600; }
    .day-modal-quick-row { display: flex; gap: 10px; }
    .day-modal-quick-row input { flex: 1; margin-bottom: 0; }
    .day-modal-quick-row .btn-add-quick { flex-shrink: 0; padding: 10px 18px; background: var(--gold); color: #000; border: none; border-radius: 10px; font-weight: 700; font-size: 14px; cursor: pointer; }
    .day-modal-quick-row .btn-add-quick:hover { filter: brightness(1.1); }
    .planner-warn { position: fixed; top: 16px; left: 50%; transform: translateX(-50%); background: #b4532a; color: #fff; padding: 12px 20px; border-radius: 12px; font-size: 13px; z-index: 10001; max-width: 90%; text-align: center; }
    
    /* Унифицированная кнопка навигации */
    .nav-link-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 18px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 100px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .nav-link-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(180, 161, 138, 0.1), transparent);
        transform: translateX(-100%);
        transition: transform 0.6s ease;
    }
    .nav-link-btn:hover {
        color: #C5B49E;
        border-color: rgba(180, 161, 138, 0.3);
        background: rgba(180, 161, 138, 0.05);
        transform: translateX(-5px);
    }
    .nav-link-btn:hover::before {
        transform: translateX(100%);
    }
    .nav-link-btn svg {
        transition: transform 0.4s ease;
    }
    .nav-link-btn:hover svg {
        transform: translateX(-3px);
    }
    
    @media (max-width: 1000px) { .calendar-layout { grid-template-columns: 1fr; } .planner-main-inner { padding: 16px; } }
</style>

<style>
.planner-inner { min-height: 100%; }
.planner-main-inner { display: flex; flex-direction: column; gap: 0; }
/* Override old bg since we're inside dash-main now */
.planner-page { background: none !important; min-height: auto !important; display: block !important; }
</style>

<div class="planner-inner">
    <header class="planner-header">
            <div>
                <h1>Планировщик</h1>
                <p>Задачи и рекомендации</p>
            </div>
            <button type="button" class="btn-create" id="btnCreateTask">Создать задачу</button>
        </header>

        <div class="calendar-layout">
            <div class="calendar-card">
                <div class="month-row">
                    <h2 id="calendarMonthLabel">Февраль 2026</h2>
                    <div class="month-nav">
                        <button type="button" id="btnMonthPrev" aria-label="Предыдущий месяц">&lt;</button>
                        <button type="button" id="btnMonthNext" aria-label="Следующий месяц">&gt;</button>
                    </div>
                </div>
                <div class="calendar-grid" id="calendarGrid"></div>
            </div>

            <div class="ai-block">
                <h3>Рекомендации AI</h3>
                <div class="ai-card" data-ai-id="irrigation-a2">
                    <div class="ai-card-title">Полив участка А-2</div>
                    <div class="ai-card-body">Влажность почвы ниже 45%. Рекомендуется включить орошение на 40 минут.</div>
                    <span class="ai-done-text">Выполнено</span>
                    <button type="button" class="ai-card-btn">Выполнить</button>
                </div>
                <div class="ai-card" data-ai-id="inspection-krs5">
                    <div class="ai-card-title">Осмотр КРС #5</div>
                    <div class="ai-card-body">Снижение активности на 15%. Рекомендуется визуальный осмотр.</div>
                    <span class="ai-done-text">Запланировано</span>
                    <button type="button" class="ai-card-btn">Запланировать</button>
                </div>
                <div class="ai-card" data-ai-id="fertilizers-buy">
                    <div class="ai-card-title">Закупка удобрений</div>
                    <div class="ai-card-body">Через 5 дней потребуется азотная подкормка для сектора «Север».</div>
                    <span class="ai-done-text">В корзину добавлено</span>
                    <button type="button" class="ai-card-btn">В корзину</button>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Модалка: создать задачу -->
<div class="planner-modal" id="modalCreate" role="dialog" aria-modal="true" aria-label="Создать задачу">
    <div class="planner-modal-box" onclick="event.stopPropagation()">
        <h3>Создать задачу</h3>
        <form id="formCreateTask">
            <label for="inputTaskTitle">Название</label>
            <input type="text" id="inputTaskTitle" required placeholder="Например: Полив участка А-2" autocomplete="off">
            <label for="inputTaskDate">Дата</label>
            <input type="date" id="inputTaskDate" required>
            <label for="inputTaskNote">Заметка (необязательно)</label>
            <textarea id="inputTaskNote" placeholder="Дополнительные детали"></textarea>
            <div class="planner-modal-actions">
                <button type="button" class="planner-modal-cancel" id="btnCreateCancel">Отмена</button>
                <button type="submit" class="planner-modal-save">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<!-- Модалка: задачи на день -->
<div class="planner-modal" id="modalDay" role="dialog" aria-modal="true" aria-label="Задачи на день">
    <div class="planner-modal-box" onclick="event.stopPropagation()">
        <h3 id="modalDayTitle">Задачи на день</h3>
        <div class="day-modal-quick">
            <label for="dayModalQuickInput">Добавить задачу на этот день</label>
            <div class="day-modal-quick-row">
                <input type="text" id="dayModalQuickInput" placeholder="Название задачи" autocomplete="off">
                <button type="button" class="btn-add-quick" id="btnDayModalAddQuick">Добавить</button>
            </div>
        </div>
        <ul class="day-tasks-list" id="dayTasksList"></ul>
        <div class="planner-modal-actions" style="margin-top: 16px;">
            <button type="button" class="planner-modal-cancel" id="btnDayClose">Закрыть</button>
            <button type="button" class="planner-modal-save" id="btnDayAdd">Полная форма задачи</button>
        </div>
    </div>
</div>

<script>
(function() {
    var MONTH_NAMES = <?= json_encode($MONTH_NAMES, JSON_UNESCAPED_UNICODE) ?>;
    
    var viewYear, viewMonth;
    var selectedDateForDayModal = null;
    var calendarEl, monthLabelEl, gridEl;
    var allTasks = []; // Combined manual and auto tasks

    async function fetchTasks() {
        try {
            const r = await fetch('/api/planner/tasks');
            const data = await r.json();
            if (data.success) {
                // Combine manual and auto tasks
                allTasks = [
                    ...data.manual_tasks.map(t => ({ ...t, id: t.id, type: 'manual' })),
                    ...data.auto_tasks.map(t => ({ ...t, type: t.task_type }))
                ];
                renderCalendar();
            }
        } catch (e) {
            console.error("Fetch error:", e);
        }
    }

    function dateStr(y, m, d) {
        return y + '-' + String(m).padStart(2, '0') + '-' + String(d).padStart(2, '0');
    }

    function tasksForDate(dStr) {
        return allTasks.filter(function(t) { return t.task_date === dStr; });
    }

    function renderCalendar() {
        if (!gridEl) return;
        var y = viewYear, m = viewMonth;
        var first = new Date(y, m - 1, 1);
        var last = new Date(y, m, 0);
        var daysInMonth = last.getDate();
        var startWeekday = (first.getDay() + 6) % 7;
        monthLabelEl.textContent = MONTH_NAMES[m - 1] + ' ' + y;

        var html = '';
        ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'].forEach(function(name) {
            html += '<div class="day-name">' + name + '</div>';
        });
        for (var i = 0; i < startWeekday; i++) {
            html += '<div class="day-cell other-month" style="pointer-events:none;"></div>';
        }
        
        const typeColors = {
            'manual': 'gold',
            'plan_event': 'var(--sage)',
            'vet_visit': '#fd7e14',
            'treatment': '#228be6'
        };

        for (var d = 1; d <= daysInMonth; d++) {
            var dt = dateStr(y, m, d);
            var tasks = tasksForDate(dt);
            var activeClass = selectedDateForDayModal === dt ? ' active' : '';
            html += '<div class="day-cell' + activeClass + '" data-date="' + dt + '" data-day="' + d + '" role="button" tabindex="0">';
            html += '<span class="day-num">' + d + '</span><div class="day-dots">';
            tasks.slice(0, 3).forEach(t => {
                const color = typeColors[t.type] || 'var(--gold)';
                html += `<div class="day-dot" style="background: ${color}"></div>`;
            });
            html += '</div></div>';
        }
        gridEl.innerHTML = html;

        gridEl.querySelectorAll('.day-cell[data-date]').forEach(function(cell) {
            cell.addEventListener('click', function() {
                var date = this.getAttribute('data-date');
                var day = this.getAttribute('data-day');
                selectedDateForDayModal = date;
                openDayModal(date, day);
            });
        });
    }

    var modalCreate = document.getElementById('modalCreate');
    var modalDay = document.getElementById('modalDay');
    var formCreate = document.getElementById('formCreateTask');
    var inputTitle = document.getElementById('inputTaskTitle');
    var inputDate = document.getElementById('inputTaskDate');
    var inputNote = document.getElementById('inputTaskNote');
    var modalDayTitle = document.getElementById('modalDayTitle');
    var dayTasksList = document.getElementById('dayTasksList');
    var dayModalQuickInput = document.getElementById('dayModalQuickInput');
    var btnDayModalAddQuick = document.getElementById('btnDayModalAddQuick');

    function openCreateModal(presetDate) {
        if (presetDate) inputDate.value = presetDate;
        else {
            var d = new Date();
            inputDate.value = dateStr(d.getFullYear(), d.getMonth() + 1, d.getDate());
        }
        inputTitle.value = '';
        inputNote.value = '';
        modalCreate.classList.add('is-open');
    }

    async function doSaveTask() {
        var title = inputTitle.value.trim();
        var date = inputDate.value;
        var note = inputNote.value.trim();
        
        if (!title || !date) return alert('Заполните заголовок и дату');

        try {
            const r = await fetch('/api/planner/tasks', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title: title, task_date: date, description: note })
            });
            const res = await r.json();
            if (res.success) {
                closeCreateModal();
                fetchTasks();
            }
        } catch (e) {
            alert('Ошибка сохранения');
        }
    }

    document.getElementById('btnCreateTask').addEventListener('click', () => openCreateModal(null));
    document.getElementById('btnCreateCancel').addEventListener('click', () => modalCreate.classList.remove('is-open'));
    formCreate.addEventListener('submit', (e) => { e.preventDefault(); doSaveTask(); });

    async function openDayModal(dateStrVal, dayNum) {
        modalDayTitle.textContent = 'Задачи на ' + dayNum + ' ' + MONTH_NAMES[viewMonth - 1];
        selectedDateForDayModal = dateStrVal;
        
        var tasks = tasksForDate(dateStrVal);
        dayTasksList.innerHTML = '';

        if (tasks.length) {
            tasks.forEach(function(t) {
                var li = document.createElement('li');
                const isManual = t.type === 'manual';
                li.innerHTML = `
                    <div style="display:flex; flex-direction:column; gap:2px;">
                        <span style="font-weight:600;">${t.title}</span>
                        ${t.description ? `<span style="font-size:11px; opacity:0.5;">${t.description}</span>` : ''}
                    </div>
                `;
                if (isManual) {
                    var del = document.createElement('button');
                    del.className = 'task-delete';
                    del.textContent = '×';
                    del.onclick = async () => {
                        await fetch('/api/planner/tasks/' + t.id, { method: 'DELETE' });
                        fetchTasks();
                        openDayModal(dateStrVal, dayNum);
                    };
                    li.appendChild(del);
                }
                dayTasksList.appendChild(li);
            });
        } else {
            dayTasksList.innerHTML = '<li style="color:rgba(255,255,255,0.4)">Нет задач</li>';
        }
        modalDay.classList.add('is-open');
    }

    document.getElementById('btnDayClose').addEventListener('click', () => modalDay.classList.remove('is-open'));

    document.getElementById('btnMonthPrev').addEventListener('click', () => {
        viewMonth--;
        if (viewMonth < 1) { viewMonth = 12; viewYear--; }
        renderCalendar();
    });

    document.getElementById('btnMonthNext').addEventListener('click', () => {
        viewMonth++;
        if (viewMonth > 12) { viewMonth = 1; viewYear++; }
        renderCalendar();
    });

    var now = new Date();
    viewYear = now.getFullYear();
    viewMonth = now.getMonth() + 1;
    monthLabelEl = document.getElementById('calendarMonthLabel');
    gridEl = document.getElementById('calendarGrid');
    
    fetchTasks();
})();
</script>
</div><!-- /.planner-inner -->
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
