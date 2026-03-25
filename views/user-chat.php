<?php
// Чат между пользователями (Пользователь <-> Ветеринар)
?>
<div class="hero-wrap"
    style="padding: 0; background: #0e0c0b; height: 100vh; overflow: hidden; display: flex; flex-direction: column;">
    <!-- Advanced Mesh System synced with Home -->
    <div class="hero-mesh-bg">
        <div class="mesh-blob blob-1"></div>
        <div class="mesh-blob blob-2"></div>
        <div class="mesh-blob blob-3"></div>
    </div>
    <div class="hero-smoke"></div>
    <div class="hero-depth-layer"></div>

    <!-- Chat Header -->
    <div
        style="padding: 24px 32px; background: rgba(0,0,0,0.4); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); position: relative; z-index: 1000; border-radius: 0 0 40px 40px;">
        <div
            style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 24px;">
                <a href="/veterinarians" class="nav-btn-circle"
                    style="display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 50%; color: #fff; text-decoration: none; transition: 0.3s;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M19 12H5M12 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div id="chatHeader">
                    <div
                        style="font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 20px; color: #fff; letter-spacing: -0.02em;">
                        Загрузка...</div>
                    <div
                        style="font-size: 11px; color: #b4a18a; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-top: 2px;">
                        Консультация</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div
                    style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);">
                </div>
                <span
                    style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.4);">В
                    сети</span>
            </div>
        </div>
    </div>

    <!-- Messages Area -->
    <div id="chatMessages"
        style="flex: 1; overflow-y: auto; padding: 40px 24px; position: relative; z-index: 100; scroll-behavior: smooth;">
        <div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
            <p style="text-align: center; color: rgba(255,255,255,0.2); font-size: 14px; padding: 40px;">Загрузка
                истории сообщений...</p>
        </div>
    </div>

    <!-- Input Area -->
    <div
        style="padding: 32px 24px 48px; position: relative; z-index: 1000; background: linear-gradient(0deg, #0e0c0b 0%, transparent 100%);">
        <div style="max-width: 900px; margin: 0 auto;">
            <form id="chatForm"
                style="display: flex; gap: 16px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(40px); padding: 8px 8px 8px 24px; border-radius: 100px; box-shadow: 0 30px 60px rgba(0,0,0,0.5); transition: 0.3s;"
                onfocuswithin="this.style.borderColor='rgba(180, 161, 138, 0.5)'">
                <input type="text" id="messageInput" placeholder="Опишите проблему или задайте вопрос..."
                    style="flex: 1; background: transparent; border: none; color: #fff; font-size: 16px; font-family: 'Inter', sans-serif; outline: none; padding: 12px 0;"
                    autocomplete="off">
                <button type="submit" class="send-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <style>
        :root {
            --h-bg: #0e0c0b;
            --h-accent: #b4a18a;
            --f-serif: 'Playfair Display', serif;
            --f-sans: 'Inter', sans-serif;
            --f-grotesk: 'Space Grotesk', sans-serif;
        }

        /* --- MESH SYSTEM (SYNCED) --- */
        .hero-mesh-bg {
            position: absolute;
            inset: 0;
            z-index: 2;
            overflow: hidden;
            pointer-events: none;
        }

        .mesh-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.2;
            animation: blobFloat 40s ease-in-out infinite alternate;
            will-change: transform;
        }

        .blob-1 {
            width: 900px;
            height: 900px;
            background: radial-gradient(circle, rgba(180, 161, 138, 0.2) 0%, transparent 70%);
            top: -20%;
            left: -10%;
            animation-duration: 25s;
        }

        .blob-2 {
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(134, 150, 137, 0.15) 0%, transparent 70%);
            bottom: -10%;
            right: 10%;
            animation-duration: 35s;
            animation-delay: -5s;
        }

        .blob-3 {
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
            top: 40%;
            right: -5%;
            animation-duration: 40s;
            animation-delay: -10s;
        }

        @keyframes blobFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(12%, 18%) scale(1.1);
            }

            66% {
                transform: translate(-6%, 12%) scale(0.9);
            }

            100% {
                transform: translate(6%, -6%) scale(1.1);
            }
        }

        .hero-smoke {
            position: absolute;
            inset: 0;
            background-image: url('https://www.transparenttextures.com/patterns/dark-leather.png');
            opacity: 0.04;
            mix-blend-mode: overlay;
            pointer-events: none;
            z-index: 3;
        }

        .hero-depth-layer {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, transparent 20%, rgba(0, 0, 0, 0.6) 100%);
            pointer-events: none;
            z-index: 4;
        }

        .nav-btn-circle:hover {
            background: #fff !important;
            color: #000 !important;
            transform: scale(1.1);
        }

        .send-btn {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--h-accent);
            color: #000;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 20px rgba(180, 161, 138, 0.2);
        }

        .send-btn:hover {
            background: #fff;
            transform: scale(1.05) rotate(10deg);
            box-shadow: 0 15px 30px rgba(255, 255, 255, 0.2);
        }

        /* Message Styles */
        .msg-bubble {
            max-width: 80%;
            padding: 20px 24px;
            border-radius: 30px;
            position: relative;
            font-size: 16px;
            line-height: 1.6;
            transition: 0.3s;
            backdrop-filter: blur(20px);
        }

        .msg-sent {
            background: linear-gradient(135deg, #b4a18a 0%, #8c7b6a 100%);
            color: #000;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
            box-shadow: 0 15px 35px rgba(180, 161, 138, 0.15);
            font-weight: 500;
        }

        .msg-received {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #fff;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .msg-time {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 8px;
            opacity: 0.5;
            font-weight: 800;
        }

        .msg-sent .msg-time {
            color: rgba(0, 0, 0, 0.5);
        }

        /* Scrollbar */
        #chatMessages::-webkit-scrollbar {
            width: 5px;
        }

        #chatMessages::-webkit-scrollbar-track {
            background: transparent;
        }

        #chatMessages::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        #chatMessages::-webkit-scrollbar-thumb:hover {
            background: var(--h-accent);
        }

        /* --- MOBILE OVERRIDES --- */
        @media (max-width: 768px) {
            .hero-wrap>div:first-child {
                padding: 16px 20px !important;
                border-radius: 0 0 24px 24px !important;
            }

            .hero-wrap>div:first-child h1,
            #chatHeader div:first-child {
                font-size: 16px !important;
            }

            #chatMessages {
                padding: 24px 16px !important;
            }

            .hero-wrap>div:nth-child(3) {
                padding: 20px 16px 32px !important;
            }

            #chatForm {
                padding: 6px 6px 6px 18px !important;
            }

            #chatForm input {
                font-size: 14px !important;
            }

            .message-bubble {
                max-width: 85% !important;
            }
        }
    </style>
</div>

<script>
    const chatUserId = '<?= $GLOBALS['chat_user_id'] ?? '' ?>';
    let chatId = null;
    let currentUserId = null;
    let lastMessageCount = 0;

    document.addEventListener('DOMContentLoaded', function () {
        gsap.from(".hero-wrap", { opacity: 0, duration: 1.5, ease: "power2.out" });

        fetch('/api/auth/me')
            .then(r => r.json())
            .then(data => {
                if (data.success && data.user) {
                    currentUserId = data.user.id;
                    initChat();
                }
            });

        document.getElementById('chatForm').addEventListener('submit', function (e) {
            e.preventDefault();
            sendMessage();
        });

        setInterval(() => { if (chatId) loadMessages(false); }, 4000);
    });

    async function initChat() {
        try {
            const res = await fetch(`/api/user-chats/with/${chatUserId}`);
            const data = await res.json();

            if (data.success) {
                chatId = data.chat.id;
                const otherUser = data.other_user;
                const name = otherUser.vet_profile?.full_name || otherUser.phone || otherUser.email || 'Ветеринар';

                document.getElementById('chatHeader').innerHTML = `
                <div style="font-family: 'Space Grotesk', sans-serif; font-weight: 800; font-size: 20px; color: #fff; letter-spacing: -0.02em;">${escapeHtml(name)}</div>
                <div style="font-size: 11px; color: #b4a18a; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 700; margin-top: 2px;">Консультация эксперта</div>
            `;
                loadMessages(true);
            }
        } catch (err) {
            console.error(err);
        }
    }

    function loadMessages(isInitial = false) {
        if (!chatId) return;

        fetch(`/api/user-chats/${chatId}/messages`)
            .then(r => r.json())
            .then(data => {
                if (data.success && data.messages) {
                    if (data.messages.length > lastMessageCount) {
                        displayMessages(data.messages, isInitial);
                        lastMessageCount = data.messages.length;
                    }
                }
            });
    }

    function displayMessages(messages, isInitial) {
        const container = document.querySelector('#chatMessages > div');
        const scrollContainer = document.getElementById('chatMessages');

        container.innerHTML = messages.map(msg => {
            const isMe = msg.sender_id === currentUserId;
            return `
            <div class="msg-bubble ${isMe ? 'msg-sent' : 'msg-received'}" style="opacity: ${isInitial ? 1 : 0}; transform: ${isInitial ? 'none' : 'translateY(20px)'}">
                <div>${escapeHtml(msg.content)}</div>
                <div class="msg-time">${new Date(msg.created_at).toLocaleTimeString('ru', { hour: '2-digit', minute: '2-digit' })}</div>
            </div>
        `;
        }).join('');

        if (!isInitial) {
            gsap.to(".msg-bubble", {
                opacity: 1,
                y: 0,
                duration: 0.6,
                stagger: 0.1,
                ease: "power2.out"
            });
        }

        setTimeout(() => {
            scrollContainer.scrollTo({ top: scrollContainer.scrollHeight, behavior: 'smooth' });
        }, 100);
    }

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const content = input.value.trim();
        if (!content || !chatId) return;

        fetch('/api/user-chats/message', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ chat_id: chatId, content: content })
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    input.value = '';
                    loadMessages();

                    // Subtle feedback animation
                    gsap.from(".send-btn", { scale: 1.2, duration: 0.4, ease: "back.out" });
                }
            });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>