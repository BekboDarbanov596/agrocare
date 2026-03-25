<!-- Страница чата с AI -->
<div style="padding: 0; min-height: 100vh; background: #070605; color: #fff; font-family: 'Inter', sans-serif; display: flex; overflow: hidden; position: relative;"
    class="animate-fade-in chat-container">

    <!-- Agro Aura Background (Static) -->
    <div class="dash-aura">
        <div class="d-blob d-blob-1"></div>
        <div class="d-blob d-blob-2"></div>
    </div>

    <!-- SIDEBAR: История чатов -->
    <aside id="chatSidebar" class="chat-sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-title">История</h2>
            <button onclick="createNewChat()" class="btn-new-chat">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"></path>
                </svg>
                Новый чат
            </button>
        </div>

        <div class="sidebar-search">
            <input type="text" id="historySearch" placeholder="Поиск в истории..." oninput="filterHistory()">
        </div>

        <div id="historyList" class="history-list">
            <!-- Сюда подгрузится история -->
            <div class="history-skeleton"></div>
            <div class="history-skeleton"></div>
            <div class="history-skeleton"></div>
        </div>

        <div class="sidebar-footer">
            <a href="/dashboard" class="btn-sidebar-back">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                В панель управления
            </a>
        </div>
    </aside>

    <!-- ОСНОВНАЯ ОБЛАСТЬ -->
    <main class="chat-main">
        <!-- Заголовок (Glassmorphism) -->
        <header class="chat-header">
            <div class="header-content">
                <div class="header-left">
                    <button id="sidebarToggle" class="sidebar-toggle-btn" onclick="toggleSidebar()">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="chat-info">
                        <h1 id="chatHeaderTitle">Консультант AgroCare</h1>
                        <p id="chatSubtitle">
                            <span class="status-dot"></span>
                            Интеллектуальный помощник
                        </p>
                    </div>
                </div>
                <div class="header-right">
                    <div class="online-badge">
                        <div class="online-pulse"></div>
                        <span>AI Онлайн</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Область сообщений -->
        <div id="chatMessages" class="chat-scroll-area">
            <div class="messages-max-width">
                <div id="messagesContainer">
                    <!-- Сообщения появятся здесь -->
                </div>
            </div>
        </div>

        <!-- Поле ввода -->
        <footer class="chat-footer">
            <div class="input-max-width">
                <div class="input-wrapper">
                    <textarea id="chatInput" placeholder="Задайте вопрос агроному-наставнику..." rows="1"></textarea>
                    <div class="input-actions">
                        <button type="button" id="sendChatBtn" class="premium-send-btn">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="input-hints">
                    <p><span>●</span> Контекстный анализ</p>
                    <p><span>●</span> Шифрование сессии</p>
                </div>
            </div>
        </footer>
    </main>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;500;600;700&display=swap');

    :root {
        --accent: #849483;
        --accent-glow: rgba(132, 148, 131, 0.4);
        --bg-dark: #070605;
        --sidebar-w: 320px;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    /* --- MOBILE ADAPTIVE CHAT --- */
    @media (max-width: 768px) {
        :root {
            --sidebar-w: 280px;
        }

        .chat-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            transform: translateX(-100%);
        }

        .chat-sidebar.active {
            transform: translateX(0);
        }

        .sidebar-toggle-btn {
            display: flex !important;
        }

        .chat-info h1 {
            font-size: 16px;
        }

        .chat-footer {
            padding: 16px 20px 40px;
        }

        .input-wrapper {
            padding: 12px 16px;
        }

        .message-bubble {
            max-width: 90% !important;
        }
    }

    * {
        box-sizing: border-box;
    }

    .chat-container {
        height: 100vh;
        width: 100%;
    }

    /* SIDEBAR STYLES */
    .chat-sidebar {
        width: var(--sidebar-w);
        background: rgba(15, 14, 12, 0.8);
        backdrop-filter: blur(30px);
        border-right: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        z-index: 200;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .sidebar-header {
        padding: 32px 24px 16px;
    }

    .sidebar-title {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 24px;
    }

    .btn-new-chat {
        width: 100%;
        padding: 14px;
        border-radius: 16px;
        background: var(--accent);
        color: var(--bg-dark);
        border: none;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 8px 20px rgba(132, 148, 131, 0.2);
    }

    .btn-new-chat:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
        box-shadow: 0 12px 24px rgba(132, 148, 131, 0.3);
    }

    .sidebar-search {
        padding: 0 24px 20px;
    }

    .sidebar-search input {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 12px 16px;
        color: #fff;
        font-size: 13px;
        outline: none;
    }

    .history-list {
        flex: 1;
        overflow-y: auto;
        padding: 0 12px;
    }

    /* History Item */
    .history-item {
        padding: 14px 16px;
        border-radius: 14px;
        margin-bottom: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s;
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .history-item:hover {
        background: rgba(255, 255, 255, 0.03);
    }

    .history-item.active {
        background: rgba(132, 148, 131, 0.1);
        border-color: rgba(132, 148, 131, 0.2);
    }

    .history-content {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .history-item-title {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .history-item-meta {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-delete-session {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.2);
        opacity: 0;
        transition: all 0.2s;
    }

    .history-item:hover .btn-delete-session {
        opacity: 1;
    }

    .btn-delete-session:hover {
        background: rgba(255, 107, 107, 0.1);
        color: #ff6b6b;
    }

    .sidebar-footer {
        padding: 24px;
        border-top: 1px solid var(--glass-border);
    }

    .btn-sidebar-back {
        color: rgba(255, 255, 255, 0.4);
        text-decoration: none;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: color 0.3s;
    }

    .btn-sidebar-back:hover {
        color: #fff;
    }

    /* MAIN CONTENT STYLES */
    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        z-index: 10;
        position: relative;
    }

    .chat-header {
        height: 80px;
        background: rgba(7, 6, 5, 0.6);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--glass-border);
        display: flex;
        align-items: center;
        padding: 0 32px;
        flex-shrink: 0;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .sidebar-toggle-btn {
        background: transparent;
        border: none;
        color: #fff;
        cursor: pointer;
        display: none;
        padding: 8px;
    }

    .chat-info h1 {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        margin: 0;
    }

    #chatSubtitle {
        margin: 4px 0 0;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        background: var(--accent);
        border-radius: 50%;
    }

    .online-badge {
        background: rgba(132, 148, 131, 0.1);
        padding: 8px 16px;
        border-radius: 30px;
        border: 1px solid rgba(132, 148, 131, 0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        font-weight: 700;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* SCROLL AREA */
    .chat-scroll-area {
        flex: 1;
        overflow-y: auto;
        padding: 40px 32px;
        scroll-behavior: smooth;
    }

    .messages-max-width {
        max-width: 800px;
        margin: 0 auto;
        width: 100%;
    }

    /* MESSAGE BUBBLES */
    .message-user {
        background: rgba(132, 148, 131, 0.12);
        border: 1px solid rgba(132, 148, 131, 0.2);
        color: #fff;
        border-radius: 24px 24px 4px 24px;
        padding: 16px 20px;
        margin-bottom: 24px;
        max-width: 85%;
        margin-left: auto;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        line-height: 1.6;
    }

    .message-ai {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        color: rgba(255, 255, 255, 0.9);
        border-radius: 24px 24px 24px 4px;
        padding: 24px;
        margin-bottom: 32px;
        max-width: 90%;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        line-height: 1.7;
    }

    /* FOOTER / INPUT */
    .chat-footer {
        padding: 32px;
        background: linear-gradient(to top, var(--bg-dark), transparent);
        flex-shrink: 0;
    }

    .input-max-width {
        max-width: 800px;
        margin: 0 auto;
    }

    .input-wrapper {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 8px 8px 8px 24px;
        display: flex;
        align-items: flex-end;
        gap: 16px;
        transition: border-color 0.3s, background 0.3s;
    }

    .input-wrapper:focus-within {
        border-color: var(--accent);
        background: rgba(255, 255, 255, 0.05);
    }

    #chatInput {
        flex: 1;
        background: transparent;
        border: none;
        padding: 14px 0;
        color: #fff;
        font-size: 16px;
        resize: none;
        max-height: 180px;
        outline: none;
        line-height: 1.5;
    }

    .premium-send-btn {
        width: 48px;
        height: 48px;
        border-radius: 18px;
        background: var(--accent);
        color: var(--bg-dark);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .premium-send-btn:hover {
        transform: scale(1.05) translateY(-2px);
        box-shadow: 0 8px 20px var(--accent-glow);
    }

    .input-hints {
        display: flex;
        justify-content: center;
        gap: 24px;
        margin-top: 16px;
        color: rgba(255, 255, 255, 0.2);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .input-hints span {
        color: var(--accent);
    }

    /* DESKTOP AURA BLOBS */
    .dash-aura {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 1;
    }

    .d-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.15;
        transition: 2s;
    }

    .d-blob-1 {
        width: 40vw;
        height: 40vw;
        background: #b4a18a;
        top: -10%;
        left: -10%;
    }

    .d-blob-2 {
        width: 30vw;
        height: 30vw;
        background: #849483;
        bottom: -5%;
        right: -5%;
    }

    /* MOBILE ADAPTATION */
    @media (max-width: 1024px) {
        .chat-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            transform: translateX(-100%);
        }

        .chat-sidebar.open {
            transform: translateX(0);
        }

        .sidebar-toggle-btn {
            display: block;
        }

        .chat-header {
            padding: 0 20px;
        }

        .chat-scroll-area {
            padding: 30px 20px;
        }

        .chat-footer {
            padding: 20px;
        }
    }

    /* UTILITIES */
    .history-skeleton {
        height: 60px;
        margin: 10px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.5;
        }

        50% {
            opacity: 0.2;
        }
    }
</style>

<!-- SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>

<script>
    let currentContextType = 'general';
    let currentContextId = null;
    let allSessions = [];

    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        currentContextType = urlParams.get('context_type') || 'general';
        currentContextId = urlParams.get('context_id') || urlParams.get('plan_id') || urlParams.get('analysis_id') || urlParams.get('case_id');

        // Initial UI Setup
        loadChatSessions();
        if (currentContextId) {
            loadChatHistory(currentContextType, currentContextId);
        } else {
            renderWelcomeScreen();
        }

        // Event Listeners
        const chatInput = document.getElementById('chatInput');
        chatInput.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 180) + 'px';
        });

        document.getElementById('sendChatBtn').addEventListener('click', sendChatMessage);
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendChatMessage(); }
        });
    });

    async function loadChatSessions() {
        try {
            const res = await fetch('/api/ai/sessions');
            const data = await res.json();
            if (data.success) {
                allSessions = data.sessions;
                renderHistory(allSessions);
            }
        } catch (e) { console.error('Sessions load fail', e); }
    }

    function renderHistory(sessions) {
        const list = document.getElementById('historyList');
        list.innerHTML = '';

        if (sessions.length === 0) {
            list.innerHTML = '<p style="text-align:center; padding:20px; color:rgba(255,255,255,0.2); font-size:13px;">История пуста</p>';
            return;
        }

        sessions.forEach(s => {
            const isActive = (s.context_id === currentContextId && s.context_type === currentContextType);
            const item = document.createElement('div');
            item.className = `history-item ${isActive ? 'active' : ''}`;
            item.onclick = (e) => {
                if (e.target.closest('.btn-delete-session')) return;
                switchSession(s.context_type, s.context_id);
            };

            const typeLabel = {
                'general': 'Чат',
                'plant_analysis': 'Анализ',
                'animal_help': 'Животные',
                'plan_advice': 'План'
            }[s.context_type] || 'Диалог';

            const title = s.title || 'Без названия';
            const date = new Date(s.last_message_at).toLocaleDateString('ru-RU', { day: 'numeric', month: 'short' });

            item.innerHTML = `
                <div class="history-content">
                    <span class="history-item-title">${title}</span>
                    <span class="history-item-meta">${typeLabel} • ${date}</span>
                </div>
                <button class="btn-delete-session" onclick="deleteSession(event, '${s.context_type}', '${s.context_id}')">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </button>
            `;
            list.appendChild(item);
        });
    }

    function filterHistory() {
        const query = document.getElementById('historySearch').value.toLowerCase();
        const filtered = allSessions.filter(s =>
            (s.title && s.title.toLowerCase().includes(query)) ||
            s.context_type.toLowerCase().includes(query)
        );
        renderHistory(filtered);
    }

    function switchSession(type, id) {
        if (currentContextId === id && currentContextType === type) return;
        currentContextType = type;
        currentContextId = id;

        // Update URL without reload
        const newUrl = `/chat?context_type=${type}&context_id=${id}`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        loadChatHistory(type, id);
        loadChatSessions(); // Refresh active state

        if (window.innerWidth <= 1024) toggleSidebar();
    }

    async function deleteSession(event, type, id) {
        event.stopPropagation();
        if (!confirm('Удалить эту беседу?')) return;

        try {
            const res = await fetch('/api/ai/delete-session', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ context_type: type, context_id: id === 'null' ? null : id })
            });
            const data = await res.json();
            if (data.success) {
                gsap.to(event.target.closest('.history-item'), {
                    height: 0,
                    opacity: 0,
                    margin: 0,
                    padding: 0,
                    duration: 0.3,
                    onComplete: () => {
                        if (currentContextId === id && currentContextType === type) {
                            createNewChat();
                        } else {
                            loadChatSessions();
                        }
                    }
                });
            }
        } catch (e) { console.error('Delete fail', e); }
    }

    function createNewChat() {
        currentContextType = 'general';
        currentContextId = null;
        window.history.pushState({}, '', '/chat');
        document.getElementById('messagesContainer').innerHTML = '';
        renderWelcomeScreen();
        loadChatSessions();
        if (window.innerWidth <= 1024) document.getElementById('chatSidebar').classList.remove('open');
    }

    function loadChatHistory(type, id) {
        if (!id) return;
        const container = document.getElementById('messagesContainer');
        container.innerHTML = '<div class="history-skeleton"></div>';

        fetch(`/api/ai/history?context_type=${type}&context_id=${id}`)
            .then(r => r.json())
            .then(data => {
                container.innerHTML = '';
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => renderMessage(msg.content, msg.role === 'user'));
                    scrollBottom();
                } else {
                    renderWelcomeScreen();
                }
            });
    }

    function renderMessage(text, isUser) {
        const container = document.getElementById('messagesContainer');
        const bubble = document.createElement('div');
        bubble.className = isUser ? 'message-user' : 'message-ai';
        bubble.innerHTML = formatAIResponse(text);

        container.appendChild(bubble);
        gsap.from(bubble, { opacity: 0, y: 30, duration: 0.6, ease: "power3.out" });
    }

    function renderWelcomeScreen() {
        const container = document.getElementById('messagesContainer');
        container.innerHTML = `
            <div style="text-align: center; padding: 60px 20px;" class="welcome-screen">
                <div style="width: 80px; height: 80px; background: rgba(132, 148, 131, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px; border: 1px solid rgba(132, 148, 131, 0.2);">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#849483" stroke-width="1.5">
                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path>
                    </svg>
                </div>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 32px; margin-bottom: 12px;">Чем могу помочь?</h2>
                <p style="color: rgba(255,255,255,0.4); max-width: 400px; margin: 0 auto 40px; line-height: 1.6;">
                    Я — ваш персональный агроном-наставник. Помогу с планом посева, проанализирую состояние растений по фото или дам совет по лечению животных.
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; max-width: 600px; margin: 0 auto;">
                    <button class="suggest-card" onclick="setQuestion('Как подготовить почву к весне?')">Подготовка почвы</button>
                    <button class="suggest-card" onclick="setQuestion('Какие культуры лучше сажать после пшеницы?')">Севооборот</button>
                    <button class="suggest-card" onclick="setQuestion('Помоги составить график полива')">График полива</button>
                </div>
            </div>
        `;
    }

    function setQuestion(text) {
        const input = document.getElementById('chatInput');
        input.value = text;
        input.focus();
    }

    function sendChatMessage() {
        const input = document.getElementById('chatInput');
        const text = input.value.trim();
        if (!text) return;

        if (document.querySelector('.welcome-screen')) document.getElementById('messagesContainer').innerHTML = '';

        renderMessage(text, true);
        input.value = '';
        input.style.height = 'auto';
        scrollBottom();

        // Typing
        const typing = document.createElement('div');
        typing.className = 'message-ai typing-indicator';
        typing.innerHTML = '<span class="status-dot"></span> AI думает...';
        document.getElementById('messagesContainer').appendChild(typing);
        scrollBottom();

        fetch('/api/ai/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                message: text,
                context_type: currentContextType,
                context_id: currentContextId
            })
        })
            .then(r => r.json())
            .then(data => {
                typing.remove();
                if (data.success) {
                    renderMessage(data.message, false);
                    loadChatSessions(); // Update titles
                } else {
                    const errorMsg = data.error || 'Произошла ошибка. Попробуйте снова.';
                    renderMessage('⚠️ ' + errorMsg, false);
                }
                scrollBottom();
            });
    }

    function stripTechnicalBlocks(text) {
        if (!text) return '';
        return text
            .replace(/START_PLAN_JSON[\s\S]*?END_PLAN_JSON/gi, '')
            .replace(/START_[A-Z_]+[\s\S]*?END_[A-Z_]+/g, '')
            .replace(/\n{3,}/g, '\n\n')
            .trim();
    }

    function formatAIResponse(text) {
        const cleaned = stripTechnicalBlocks(text);
        return cleaned
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n\n/g, '<br><br>')
            .replace(/\n/g, '<br>')
            .replace(/^- (.*)/gm, '• $1');
    }

    function scrollBottom() {
        const area = document.getElementById('chatMessages');
        gsap.to(area, { scrollTo: area.scrollHeight, duration: 0.8, ease: "power2.out" });
    }

    function toggleSidebar() {
        document.getElementById('chatSidebar').classList.toggle('open');
    }
</script>

<style>
    .suggest-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 16px;
        border-radius: 16px;
        cursor: pointer;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        transition: all 0.3s;
        text-align: center;
        outline: none;
    }

    .suggest-card:hover {
        background: rgba(132, 148, 131, 0.1);
        border-color: var(--accent);
        color: #fff;
        transform: translateY(-2px);
    }

    .typing-indicator {
        font-style: italic;
        color: rgba(255, 255, 255, 0.4);
        padding: 15px 25px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>