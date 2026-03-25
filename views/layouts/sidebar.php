<?php
/**
 * Global Sidebar + Header partial
 * Usage: include with $activePage set:
 *   'plan' | 'photo-analysis' | 'animals' | 'planner' | 'reports' | 'dashboard'
 */
$activePage = $activePage ?? '';
?>
<style>
    :root {
        --dash-sidebar-w: 80px;
        --dash-header-h: 70px;
        --glass-bg: rgba(255,255,255,0.03);
        --glass-border: rgba(255,255,255,0.07);
        --accent-sage: #849483;
        --accent-gold: #b4a18a;
    }

    .dashboard-wrapper {
        min-height: 100vh;
        background: #070605;
        color: #fff;
        font-family: 'Inter', sans-serif;
        display: flex;
        overflow: hidden;
        position: relative;
    }

    /* ---- SIDEBAR ---- */
    .dash-sidebar {
        width: var(--dash-sidebar-w);
        height: 100vh;
        background: #141312;
        border-right: 1px solid rgba(255,255,255,0.08);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 28px 0;
        position: sticky;
        top: 0;
        left: 0;
        z-index: 9999;
        flex-shrink: 0;
    }

    .dash-logo-small {
        width: 32px;
        height: 32px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 48px;
        cursor: pointer;
        text-decoration: none;
    }

    .dash-nav {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }

    .dash-nav-item {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.3);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
        text-decoration: none;
        border: 1px solid transparent;
    }

    .dash-nav-item:hover {
        background: var(--glass-bg);
        color: #fff;
        border-color: var(--glass-border);
    }

    .dash-nav-item.active {
        background: rgba(132,148,131,0.08);
        color: #fff;
        border-color: rgba(132,148,131,0.25);
    }

    .dash-nav-item.active::after {
        content: '';
        position: absolute;
        left: -17px;
        width: 4px;
        height: 20px;
        background: var(--accent-sage);
        border-radius: 0 4px 4px 0;
        box-shadow: 0 0 12px var(--accent-sage);
    }

    .dash-nav-item svg { pointer-events: none; }

    .dash-sidebar-footer {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
        margin-top: auto;
    }

    /* ---- MAIN AREA ---- */
    .dash-main {
        flex: 1;
        height: 100vh;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 10;
        min-width: 0;
    }

    .dash-main::-webkit-scrollbar { width: 6px; }
    .dash-main::-webkit-scrollbar-track { background: transparent; }
    .dash-main::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

    /* ---- HEADER ---- */
    .dash-header {
        height: var(--dash-header-h);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        background: rgba(10,9,8,0.85);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255,255,255,0.07);
        z-index: 1000;
        padding: 0 36px;
        flex-shrink: 0;
    }

    .dash-header-title {
        font-family: 'Space Grotesk', 'Inter', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: rgba(255,255,255,0.85);
        letter-spacing: -0.02em;
    }

    .dash-header-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-user-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 16px 6px 6px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 100px;
        transition: all 0.4s;
        cursor: pointer;
    }

    .header-user-pill:hover {
        background: rgba(255,255,255,0.07);
        border-color: rgba(255,255,255,0.14);
    }

    .header-avatar {
        width: 34px;
        height: 34px;
        background: linear-gradient(135deg, var(--accent-gold), #8a7a68);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        color: #000;
        flex-shrink: 0;
    }

    .header-user-name {
        font-size: 13px;
        font-weight: 700;
        color: rgba(255,255,255,0.9);
        white-space: nowrap;
    }

    .header-status-dot {
        width: 7px;
        height: 7px;
        background: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 8px #10b981;
        flex-shrink: 0;
    }

    /* ---- PAGE CONTENT WRAPPER ---- */
    .dash-page-content {
        flex: 1;
        padding: 32px 36px 48px;
    }

    /* Tooltip on hover */
    .dash-nav-item[title]:hover::before {
        content: attr(title);
        position: absolute;
        left: 62px;
        background: rgba(20,19,18,0.95);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.12);
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .dash-sidebar { display: none; }
        .dash-header { padding: 0 20px; }
        .dash-page-content { padding: 20px 16px 80px; }
    }
</style>

<div class="dashboard-wrapper">
    <!-- SIDEBAR -->
    <aside class="dash-sidebar">
        <a class="dash-logo-small" href="/dashboard" title="Главная">
            <div style="width:14px;height:14px;background:#000;border-radius:4px;"></div>
        </a>

        <nav class="dash-nav">
            <a href="/dashboard" class="dash-nav-item <?= $activePage === 'dashboard' ? 'active' : '' ?>" title="Обзор">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
            </a>
            <a href="/plan" class="dash-nav-item <?= $activePage === 'plan' ? 'active' : '' ?>" title="Smart Plan">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </a>
            <a href="/photo-analysis" class="dash-nav-item <?= $activePage === 'photo-analysis' ? 'active' : '' ?>" title="Анализ фото">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
            </a>
            <a href="/animals" class="dash-nav-item <?= $activePage === 'animals' ? 'active' : '' ?>" title="Животные">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 9v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9"/>
                    <path d="M9 22V12h6v10M2 10.6L12 2l10 8.6"/>
                </svg>
            </a>
            <a href="/planner" class="dash-nav-item <?= $activePage === 'planner' ? 'active' : '' ?>" title="Планировщик">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </a>
            <a href="/reports" class="dash-nav-item <?= $activePage === 'reports' ? 'active' : '' ?>" title="Отчёты">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </a>
        </nav>

        <div class="dash-sidebar-footer">
            <a href="/dashboard" class="dash-nav-item" title="Выход" onclick="event.preventDefault(); fetch('/api/auth/logout',{method:'POST'}).then(()=>location.href='/')">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </a>
        </div>
    </aside>

    <!-- MAIN COLUMN -->
    <main class="dash-main">
        <!-- HEADER -->
        <header class="dash-header">
            <span class="dash-header-title"><?= htmlspecialchars($pageHeaderTitle ?? 'AgroCare') ?></span>
            <div class="dash-header-right">
                <div class="header-status-dot"></div>
                <div class="header-user-pill">
                    <div class="header-avatar" id="sidebarAvatarInitials">FA</div>
                    <span class="header-user-name" id="sidebarUserName">Фермер</span>
                </div>
            </div>
        </header>

        <div class="dash-page-content">
