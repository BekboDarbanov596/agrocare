<?php
$activePage = 'reports';
$pageHeaderTitle = 'Digital Farm Passport';
include __DIR__ . '/layouts/sidebar.php';
?>

<div class="reports-module-wrap">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Space+Grotesk:wght@300..700&display=swap');

    :root {
        --h-bg: #0e0c0b;
        --h-accent: #b4a18a;
        --f-serif: 'Playfair Display', serif;
        --f-grotesk: 'Space Grotesk', sans-serif;
    }

    .reports-module-wrap {
        min-height: 100%;
        position: relative;
    }

    .report-wrap {
        max-width: 1000px;
        margin: 60px auto;
        padding: 80px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 40px;
        position: relative;
        overflow: hidden;
    }

    /* Print styling specifically for saving as PDF */
    @media print {
        body {
            background: #fff !important;
            color: #000 !important;
        }

        .report-wrap {
            margin: 0;
            padding: 40px;
            background: #fff !important;
            border: none;
            border-radius: 0;
            box-shadow: none;
            max-width: none;
        }

        .no-print {
            display: none !important;
        }

        .report-header h1 {
            color: #000 !important;
        }

        .sidebar-links {
            display: none !important;
        }
    }

    .report-header {
        border-bottom: 2px solid var(--h-accent);
        padding-bottom: 40px;
        margin-bottom: 60px;
    }

    .report-header h1 {
        font-family: var(--f-grotesk);
        font-size: 64px;
        font-weight: 800;
        letter-spacing: -0.05em;
        line-height: 0.95;
        margin: 0;
        text-transform: uppercase;
        background: linear-gradient(180deg, #fff 0%, rgba(255, 255, 255, 0.4) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .report-meta {
        display: flex;
        justify-content: space-between;
        margin-top: 24px;
        font-family: var(--f-grotesk);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 11px;
        opacity: 0.5;
    }

    .report-section {
        margin-bottom: 80px;
    }

    .section-title {
        font-family: var(--f-serif);
        font-size: 32px;
        font-style: italic;
        margin-bottom: 32px;
        color: var(--h-accent);
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }

    .summary-card {
        padding: 32px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .summary-val {
        font-family: var(--f-grotesk);
        font-size: 40px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .summary-label {
        font-size: 12px;
        opacity: 0.4;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .ledger-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ledger-table th {
        text-align: left;
        padding: 16px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        opacity: 0.3;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .ledger-table td {
        padding: 24px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 14px;
    }

    .badge-triage {
        padding: 4px 12px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .triage-low {
        background: rgba(132, 148, 131, 0.2);
        color: #869689;
    }

    .triage-medium {
        background: rgba(180, 161, 138, 0.2);
        color: #b4a18a;
    }

    .triage-high {
        background: rgba(250, 82, 82, 0.2);
        color: #fa5252;
    }

    .no-print-btn {
        position: fixed;
        top: 24px;
        right: 24px;
        background: var(--h-accent);
        color: #000;
        padding: 12px 24px;
        border-radius: 100px;
        text-decoration: none;
        font-weight: 800;
        font-size: 12px;
        z-index: 1000;
        box-shadow: 0 10px 20px rgba(180, 161, 138, 0.2);
    }

    @media (max-width: 768px) {
        .report-wrap {
            padding: 40px 24px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .report-header h1 {
            font-size: 32px;
        }
    }
</style>

<div class="report-aura"></div>

<a href="#" onclick="window.print()" class="no-print-btn no-print">Export to PDF</a>

<div class="report-wrap">
    <header class="report-header">
        <h1>Digital Farm<br>Passport</h1>
        <div class="report-meta">
            <span>Issue Date:
                <?= date('d.m.Y') ?>
            </span>
            <span>Farm ID: AC-88242</span>
            <span>Type: Semantic Analysis Report</span>
        </div>
    </header>

    <section class="report-section">
        <h2 class="section-title">Executive Summary</h2>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-val">88%</div>
                <div class="summary-label">Health Index</div>
            </div>
            <div class="summary-card">
                <div class="summary-val">12</div>
                <div class="summary-label">Active Plots</div>
            </div>
            <div class="summary-card">
                <div class="summary-val">04</div>
                <div class="summary-label">Critical Alerts</div>
            </div>
        </div>
    </section>

    <section class="report-section">
        <h2 class="section-title">Animal Diagnostics Ledger</h2>
        <table class="ledger-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Diagnosis</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Cattle #124</strong></td>
                    <td>Signs of early mastitis detected.</td>
                    <td><span class="badge-triage triage-medium">Medium</span></td>
                    <td>19.02.2026</td>
                </tr>
                <tr>
                    <td><strong>Sheep #08</strong></td>
                    <td>Limping due to infection.</td>
                    <td><span class="badge-triage triage-high">Critical</span></td>
                    <td>18.02.2026</td>
                </tr>
                <tr>
                    <td><strong>Cattle #42</strong></td>
                    <td>Regular health check - Optimal.</td>
                    <td><span class="badge-triage triage-low">Healthy</span></td>
                    <td>15.02.2026</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="report-section">
        <h2 class="section-title">Field Performance</h2>
        <p style="opacity: 0.6; line-height: 1.8; font-size: 15px;">
            Based on multi-spectral satellite imagery and AI analysis, current field performance is stable.
            Soil humidity averages at 48%, with nitrogen levels within the top 10% for the region.
            Recommendation: Proceed with the scheduled fertilization for Plot A-3 within 48 hours.
        </p>
    </section>

    <footer
        style="margin-top: 100px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 40px; font-size: 12px; opacity: 0.3; text-align: center;">
        Certified by AgroCare AI Systems. This report is a digital artifact and valid for regulatory submission.
    </footer>
</div>

</div><!-- /.reports-module-wrap -->
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