<!--
    HERO MASTER - Final Precision
    Concept: Balanced Excellence (Center-Aligned)
    Refinements: Ultra-sharp typography, expanded nav links
-->

<style>
    :root {
        --h-bg: #0e0c0b;
        /* Rich Charcoal - Slightly lighter/warmer for better visibility */
        --h-accent: #b4a18a;
        /* Premium Muted Bronze/Earth */
        --h-text: #ffffff;
        --h-text-dim: rgba(255, 255, 255, 0.9);
        /* Sharper, brighter dim text */
        --f-serif: 'Playfair Display', serif;
        --f-sans: 'Inter', sans-serif;
    }

    .hero-wrap {
        background: var(--h-bg);
        min-height: auto;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        color: var(--h-text);
        font-family: var(--f-sans);
        padding-bottom: 60px;
    }

    /* Убрали fade градиент, чтобы не перекрывал следующую секцию */

    /* --- PREMIUM NAV --- */
    .hero-nav {
        position: sticky;
        top: 0;
        left: 0;
        z-index: 1000;
        width: 100%;
        background: rgba(1, 2, 3, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        opacity: 0;
        transform: translateY(-10px);
        will-change: transform, opacity;
    }

    .nav-inner {
        max-width: 1400px;
        margin: 0 auto;
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


    .hero-logo {
        font-size: 14px;
        font-weight: 900;
        letter-spacing: -0.01em;
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .logo-dot {
        width: 4px;
        height: 4px;
        background: var(--h-accent);
        border-radius: 50%;
    }

    .nav-links {
        display: flex;
        gap: 32px;
        align-items: center;
    }

    .nav-link {
        text-decoration: none;
        color: rgba(255, 255, 255, 0.7);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        color: #fff;
    }

    .nav-btn {
        background: var(--h-accent);
        color: #000 !important;
        padding: 10px 24px;
        border-radius: 100px;
        font-weight: 900;
        font-size: 10px;
        letter-spacing: 0.1em;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 20px rgba(180, 161, 138, 0.2);
    }

    .nav-btn:hover {
        background: #fff;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(255, 255, 255, 0.2);
    }



    /* --- HERO CORE HYBRID LAYOUT --- */
    .hero-layout-split {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 60px;
        align-items: center;
        padding: 80px 40px 120px;
        position: relative;
        z-index: 10;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        min-height: 85vh;
    }

    .hero-text-side {
        text-align: left;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .hero-visual-side {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    /* Background & Contrast */
    .hero-image {
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1592982537447-7440774c093d?q=80&w=2000&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        filter: brightness(0.25) saturate(0.8);
        z-index: 1;
    }

    .hero-gradient {
        display: none;
    }

    /* Sharper & Larger Typography */
    .hero h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: clamp(48px, 6vw, 92px);
        /* Adjusted for split layout */
        font-weight: 800;
        line-height: 0.95;
        letter-spacing: -0.04em;
        margin-bottom: 32px;
        opacity: 0;
        transform: translateX(-40px);
        will-change: transform, opacity;

    }

    .h1-glow {
        color: #ffffff;
        text-shadow: 0 0 80px rgba(180, 161, 138, 0.2);
        display: block;
    }

    .hero h1 span.accent {
        font-family: var(--f-serif);
        font-weight: 300;
        font-style: italic;
        color: var(--h-accent);
        background: linear-gradient(135deg, var(--h-accent) 0%, #fff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: block;
        margin-top: -10px;
    }

    .hero-editorial-desc {
        font-size: 20px;
        color: rgba(255, 255, 255, 0.6);
        line-height: 1.6;
        max-width: 600px;
        margin: 0 0 48px 0;
        /* Left alignment */
        font-weight: 400;
        opacity: 0;
        transform: translateX(-20px);
        letter-spacing: 0.01em;
    }

    .hero-mission {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4em;
        color: var(--h-accent);
        margin-bottom: 16px;
        opacity: 0;
    }

    .hero-actions {
        display: flex;
        gap: 24px;
        justify-content: flex-start;
        /* Left alignment */
        opacity: 0;
        transform: translateY(20px);
        margin-top: 0;
    }

    .btn-ultra {
        position: relative;
        padding: 24px 56px;
        border-radius: 100px;
        font-size: 18px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        gap: 12px;
        overflow: hidden;
    }

    .btn-u-primary {
        background: #fff;
        color: #000;
        box-shadow: 0 20px 40px rgba(255, 255, 255, 0.1);
    }

    .btn-u-primary:hover {
        transform: scale(1.05) translateY(-5px);
        box-shadow: 0 30px 60px rgba(255, 255, 255, 0.2);
    }

    .btn-u-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
    }

    .btn-u-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--h-accent);
        transform: translateY(-2px);
    }

    /* --- ADVANCED MESH GRADIENT SYSTEM --- */
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
        filter: blur(80px);
        /* Reduced blur radius */
        opacity: 0.35;
        animation: blobFloat 40s ease-in-out infinite alternate;
        will-change: transform;
    }


    .blob-1 {
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(180, 161, 138, 0.15) 0%, transparent 70%);
        top: -20%;
        left: -10%;
        animation-duration: 25s;
    }

    .blob-2 {
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(134, 150, 137, 0.12) 0%, transparent 70%);
        bottom: -10%;
        right: 10%;
        animation-duration: 35s;
        animation-delay: -5s;
    }

    .blob-3 {
        width: 700px;
        height: 700px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
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
            transform: translate(10%, 15%) scale(1.1);
        }

        66% {
            transform: translate(-5%, 10%) scale(0.9);
        }

        100% {
            transform: translate(5%, -5%) scale(1);
        }
    }

    .hero-smoke {
        position: absolute;
        inset: 0;
        /* Replaced heavy feTurbulence with a much lighter static grain noise */
        background-image: url('https://www.transparenttextures.com/patterns/dark-leather.png');
        opacity: 0.03;
        mix-blend-mode: overlay;
        pointer-events: none;
        z-index: 3;
    }

    /* Subtle overlay gradient for depth instead of active SVG noise */
    .hero-depth-layer {
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, transparent 20%, rgba(0, 0, 0, 0.4) 100%);
        pointer-events: none;
        z-index: 4;
    }



    /* --- HERO 3D SHOWCASE (REPLACING FEATURES) --- */
    .hero-3d-showcase {
        position: relative;
        width: 100%;
        perspective: 2500px;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transform: translateX(60px);
    }

    .hero-device-stack {
        width: 380px;
        height: 600px;
        position: relative;
        transform-style: preserve-3d;
        transform: rotateY(-30deg) rotateX(15deg) rotateZ(5deg);
        transition: transform 0.1s ease-out;
    }

    /* Device Frame */
    .device-frame {
        position: absolute;
        inset: 0;
        background: #000;
        border-radius: 40px;
        box-shadow:
            0 50px 100px rgba(0, 0, 0, 0.8),
            inset 0 0 0 4px #1a1a1a,
            inset 0 0 0 6px #000;
        overflow: hidden;
        z-index: 10;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .device-screen {
        position: absolute;
        inset: 8px;
        background: #0d0d0d;
        border-radius: 32px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Screen Reflection Overlays */
    .screen-reflection {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%, rgba(255, 255, 255, 0.02) 100%);
        pointer-events: none;
        z-index: 100;
    }

    .device-bezel {
        position: absolute;
        inset: 2px;
        border-radius: 38px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        pointer-events: none;
        z-index: 5;
    }


    /* App UI inside device */
    .app-ui-header {
        height: 60px;
        background: rgba(255, 255, 255, 0.01);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 0 16px 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }

    .status-bar {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 16px;
        font-size: 8px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.6);
        z-index: 10;
    }

    .app-ui-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
        overflow-y: auto;
    }

    .yield-tracker {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 16px;
        position: relative;
        overflow: hidden;
    }

    .yield-tracker::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(180, 161, 138, 0.05), transparent 70%);
        pointer-events: none;
    }

    .field-card-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .field-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 18px;
        padding: 12px;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .field-card-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.03);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chart-pulse {
        animation: chartPulse 3s infinite ease-in-out;
    }

    @keyframes chartPulse {

        0%,
        100% {
            opacity: 0.4;
        }

        50% {
            opacity: 0.8;
        }
    }


    /* Floating Data Panels */
    .hero-panel {
        position: absolute;
        background: rgba(30, 30, 30, 0.85);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(180, 161, 138, 0.3);
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
        z-index: 20;
    }

    .panel-1 {
        width: 200px;
        top: 20%;
        left: -120px;
        transform: translateZ(100px);
    }

    .panel-2 {
        width: 180px;
        bottom: 15%;
        right: -100px;
        transform: translateZ(150px);
        border-color: rgba(16, 185, 129, 0.3);
    }

    /* Decorative Particle/Glow */
    .hero-glow-orb {
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(180, 161, 138, 0.08) 0%, transparent 70%);
        z-index: 5;
        pointer-events: none;
    }


    /* Apple-Style Actions - SIDE BY SIDE */
    /* This block is now redundant due to .hero-actions above */
    /*
    .hero-actions {
        display: flex;
        flex-direction: row;
        gap: 20px;
        width: 100%;
        max-width: 500px;
        justify-content: center;
        opacity: 0;
        transform: translateY(20px);
    }
    */

    .btn-premium {
        flex: 1;
        /* Equal width */
        padding: 22px 40px;
        border-radius: 18px;
        font-size: 17px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        text-align: center;
        white-space: nowrap;
    }

    .btn-p-main {
        background: #fff;
        color: #000;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-p-main:hover {
        transform: translateY(-4px);
        background: var(--h-accent);
        color: #fff;
        box-shadow: 0 15px 30px rgba(180, 161, 138, 0.3);
        /* Muted Bronze shadow */
    }

    .btn-p-sec {
        background: rgba(255, 255, 255, 0.05);
        /* More visible */
        border: 1px solid var(--h-accent);
        /* Green border */
        color: #fff;
        backdrop-filter: blur(12px);
    }

    .btn-p-sec:hover {
        background: rgba(16, 185, 129, 0.1);
        transform: translateY(-2px);
    }

    /* --- TAGS --- */
    .hero-category {
        font-size: 9px;
        color: #fbbf24;
        /* Muted Gold for Elite feel */
        font-weight: 800;
        letter-spacing: 0.6em;
        text-transform: uppercase;
        margin-bottom: 24px;
        opacity: 0;
    }

    /* --- SECTION 2: CAPABILITIES --- */
    .cap-section {
        background: linear-gradient(180deg, #0e0c0b 0%, #12100f 50%, #0e0c0b 100%);
        padding: 100px 40px 100px;
        color: #ffffff !important;
        position: relative;
        overflow: hidden;
        z-index: 10;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Элегантный фон с меш-градиентом */
    .cap-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background:
            radial-gradient(circle at 20% 30%, rgba(180, 161, 138, 0.05) 0%, transparent 40%),
            radial-gradient(circle at 80% 70%, rgba(16, 185, 129, 0.03) 0%, transparent 40%);
        z-index: 1;
        pointer-events: none;
    }

    .cap-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><filter id="n"><feTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch"/></filter><rect width="100%" height="100%" filter="url(%23n)" opacity="0.05"/></svg>');
        opacity: 0.15;
        pointer-events: none;
        z-index: 1;
    }

    .cap-header {
        text-align: left;
        margin-bottom: 0;
        position: sticky;
        top: 120px;
        z-index: 2;
    }

    .cap-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: clamp(32px, 4.5vw, 64px);
        font-weight: 900;
        line-height: 0.95;
        letter-spacing: -0.05em;
        color: #ffffff;
        margin: 0 0 24px 0;
        background: linear-gradient(180deg, #fff 0%, rgba(255, 255, 255, 0.4) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        -webkit-font-smoothing: antialiased;
    }

    .cap-description {
        font-size: 18px;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.6;
        max-width: 440px;
        margin: 0 0 48px 0;
        font-weight: 400;
    }

    /* Stats Block for Left Column */
    .cap-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        max-width: 440px;
    }

    .stat-item {
        padding: 24px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
    }

    .stat-value {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 32px;
        font-weight: 800;
        color: var(--h-accent);
        display: block;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255, 255, 255, 0.4);
        font-weight: 700;
    }

    /* Visual Divider Detail */
    .cap-divider {
        width: 1px;
        height: 60px;
        background: linear-gradient(to bottom, var(--h-accent), transparent);
        margin-top: 48px;
        opacity: 0.4;
    }

    .cap-grid-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        position: relative;
    }

    .cap-grid {
        display: flex;
        flex-direction: column;
        gap: 32px;
        width: 100%;
    }

    .cap-card {
        background: rgba(255, 255, 255, 0.015);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 40px;
        padding: 56px;
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
        gap: 40px;
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        transition:
            background 0.4s ease,
            border-color 0.4s ease,
            box-shadow 0.4s ease;
        opacity: 0;
        transform: translateY(40px);
        will-change: transform, opacity;
        position: relative;
        z-index: 2;
        overflow: hidden;
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05);
    }

    /* Side by side layout for all cards on desktop */
    .cap-card:nth-child(1),
    .cap-card:nth-child(2),
    .cap-card:nth-child(3) {
        grid-column: auto;
        width: 100%;
        margin: 0;
    }

    /* The "Spark" Effect (Growing & Burning) */
    .cap-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(180, 161, 138, 0.1) 0%, transparent 40%);
        opacity: 0;
        transition: opacity 0.8s ease;
        pointer-events: none;
        z-index: -1;
    }

    /* Floating Sparks */
    .cap-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, var(--h-accent) 0.5px, transparent 0.5px);
        background-size: 40px 40px;
        opacity: 0;
        transition: opacity 1s ease;
        mask-image: linear-gradient(to bottom, white, transparent);
    }

    .cap-card:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(180, 161, 138, 0.3);
        transform: translateX(12px) scale(1.02);
        box-shadow:
            0 40px 100px rgba(0, 0, 0, 0.7),
            0 0 60px rgba(180, 161, 138, 0.05),
            inset 0 1px 1px rgba(255, 255, 255, 0.1);
    }

    .cap-icon-box {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, rgba(180, 161, 138, 0.15), rgba(180, 161, 138, 0.05));
        border: 1px solid rgba(180, 161, 138, 0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--h-accent);
        transition: all 0.5s ease;
    }

    .cap-card:hover .cap-icon-box {
        background: var(--h-accent);
        color: #000;
        transform: rotate(10deg);
    }

    .cap-card-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: #fff;
        margin-bottom: 12px;
        transition: color 0.4s ease;
    }

    .cap-card:hover .cap-card-title {
        color: var(--h-accent);
    }

    /* --- SECTION 3: CINEMATIC IMPACT --- */
    .impact-section {
        background: #0e0c0b;
        padding: 100px 40px;
        position: relative;
        overflow: hidden;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Techno Grid Background */
    .impact-grid-bg {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(180, 161, 138, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(180, 161, 138, 0.03) 1px, transparent 1px);
        background-size: 60px 60px;
        mask-image: radial-gradient(circle at 70% 50%, black 20%, transparent 70%);
        pointer-events: none;
    }

    .impact-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 60px;
        max-width: 1400px;
        margin: 0 auto;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    /* 3D Mockup Container */
    .mockup-3d-container {
        position: relative;
        width: 100%;
        perspective: 2000px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .mockup-stack {
        width: 100%;
        height: 500px;
        position: relative;
        transform-style: preserve-3d;
        transform: rotateY(-25deg) rotateX(15deg);
        transition: transform 0.1s ease-out;
    }

    .mockup-layer {
        position: absolute;
        border-radius: 28px;
        box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6), inset 0 0 0 1px rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(25px);
        overflow: hidden;
        transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .mockup-layer::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), transparent 50%);
        pointer-events: none;
        z-index: 10;
    }


    .layer-base {
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at 0% 0%, #1a1a1a 0%, #0d0d0d 100%);
        z-index: 1;
        transform: translateZ(0);
        display: grid;
        grid-template-columns: 80px 1fr;
        padding: 0;
        border: 1px solid rgba(255, 255, 255, 0.03);
    }


    .mockup-sidebar {
        background: rgba(0, 0, 0, 0.4);
        border-right: 1px solid rgba(255, 255, 255, 0.03);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 30px 0;
        gap: 28px;
    }

    .sidebar-icon {
        width: 30px;
        height: 30px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        position: relative;
    }

    .sidebar-icon.active {
        background: var(--h-accent);
        box-shadow: 0 0 20px rgba(180, 161, 138, 0.4);
    }


    .layer-card {
        width: 300px;
        height: 220px;
        background: linear-gradient(135deg, rgba(40, 40, 40, 0.8), rgba(20, 20, 20, 0.95));
        border: 1px solid rgba(255, 255, 255, 0.08);
        z-index: 2;
        transform: translateZ(100px);
        top: 40px;
        left: -80px;
        padding: 28px;
        box-shadow: 0 60px 120px rgba(0, 0, 0, 0.7);
    }

    .layer-chart {
        width: 340px;
        height: 200px;
        background: linear-gradient(135deg, rgba(25, 25, 25, 0.9), rgba(15, 15, 15, 0.98));
        border: 1px solid rgba(180, 161, 138, 0.15);
        z-index: 3;
        transform: translateZ(200px);
        bottom: 30px;
        right: -60px;
        padding: 24px;
        box-shadow: 0 80px 160px rgba(0, 0, 0, 0.8);
    }



    .mockup-main {
        padding: 50px;
        background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.02) 0%, transparent 80%);
    }

    .mockup-ui-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 32px;
        letter-spacing: -0.02em;
    }

    .mockup-ui-row {
        height: 64px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        padding: 0 20px;
        gap: 16px;
        border: 1px solid rgba(255, 255, 255, 0.02);
    }

    .ui-avatar {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--h-accent), #8a7a6c);
        opacity: 0.8;
    }

    .ui-line {
        height: 10px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 5px;
    }






    .impact-tag {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.3em;
        color: var(--h-accent);
        text-transform: uppercase;
        margin-bottom: 24px;
        display: block;
        opacity: 0;
    }

    .impact-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: clamp(40px, 5vw, 76px);
        font-weight: 900;
        line-height: 0.9;
        letter-spacing: -0.05em;
        color: #fff;
        margin-bottom: 32px;
        opacity: 0;
    }

    .impact-desc {
        font-size: 19px;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.6;
        margin-bottom: 48px;
        max-width: 520px;
        opacity: 0;
    }

    .impact-metrics {
        display: flex;
        gap: 48px;
        opacity: 0;
    }

    .metric-box {
        position: relative;
    }

    .metric-num-small {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 32px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
        display: block;
        margin-bottom: 8px;
    }

    .metric-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: rgba(255, 255, 255, 0.4);
        font-weight: 700;
    }

    /* --- CINEMATIC FOOTER --- */
    .premium-footer {
        background: #050505;
        padding: 100px 40px 60px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        position: relative;
        overflow: hidden;
    }

    .footer-grid {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
        gap: 80px;
    }

    .footer-brand .footer-logo {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 20px;
        font-weight: 900;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        text-decoration: none;
    }

    .footer-brand p {
        color: rgba(255, 255, 255, 0.4);
        line-height: 1.6;
        font-size: 14px;
        max-width: 300px;
    }

    .footer-column h4 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: var(--h-accent);
        margin-bottom: 32px;
        font-weight: 800;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 16px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .footer-links a:hover {
        color: #fff;
        padding-left: 5px;
    }

    .footer-social {
        display: flex;
        gap: 20px;
        margin-top: 24px;
    }

    .social-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: all 0.3s ease;
    }

    .social-icon:hover {
        background: var(--h-accent);
        color: #000;
        transform: translateY(-5px);
    }

    .footer-bottom {
        max-width: 1400px;
        margin: 80px auto 0;
        padding-top: 40px;
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: rgba(255, 255, 255, 0.3);
        font-size: 12px;
    }

    /* =====================================================
       MOBILE-FIRST RESPONSIVE SYSTEM
       Breakpoints: 1024px (tablet), 768px (portrait), 480px (phone)
       ===================================================== */

    /* ---- TABLET: ≤ 1024px ---- */
    @media (max-width: 1024px) {

        /* Nav */
        .nav-inner {
            padding: 14px 20px;
        }

        .nav-links {
            gap: 20px;
        }

        /* Hero: switch from 2-col split to stacked */
        .hero-layout-split {
            grid-template-columns: 1fr;
            gap: 60px;
            padding: 60px 32px 80px;
            min-height: auto;
            text-align: center;
        }

        .hero-text-side {
            align-items: center;
        }

        .hero-actions {
            justify-content: center;
        }

        .hero-editorial-desc {
            max-width: 100%;
        }

        /* Device: scale down, center */
        .hero-visual-side {
            width: 100%;
        }

        .hero-3d-showcase {
            width: 100%;
        }

        .hero-device-stack {
            width: 280px;
            height: 460px;
            transform: rotateY(-20deg) rotateX(10deg) rotateZ(3deg);
        }

        /* Panels: tuck in to avoid overflow */
        .panel-1 {
            left: -60px;
            width: 160px;
        }

        .panel-2 {
            right: -60px;
            width: 150px;
        }

        /* Blobs: constrain to viewport */
        .blob-1 {
            width: 50vw;
            height: 50vw;
        }

        .blob-2 {
            width: 40vw;
            height: 40vw;
        }

        .blob-3 {
            width: 45vw;
            height: 45vw;
        }

        /* Capabilities */
        .cap-section {
            padding: 80px 32px 80px;
        }

        .cap-grid-container {
            grid-template-columns: 1fr;
            gap: 50px;
        }

        .cap-header {
            position: relative;
            top: 0;
        }

        .cap-stats {
            max-width: 100%;
        }

        /* Impact section */
        .impact-section {
            padding: 80px 32px;
        }

        .impact-layout {
            grid-template-columns: 1fr;
            gap: 60px;
        }

        .mockup-stack {
            height: 380px;
        }

        .layer-card {
            width: 46%;
            left: -20px;
        }

        .layer-chart {
            width: 50%;
            right: -20px;
        }

        /* Footer */
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .premium-footer {
            padding: 80px 32px 50px;
        }
    }

    /* ---- MOBILE PORTRAIT: ≤ 768px ---- */
    @media (max-width: 768px) {

        /* Nav: hide text links, keep logo + CTA */
        .nav-inner {
            padding: 14px 16px;
        }

        .nav-links {
            gap: 12px;
        }

        .nav-link {
            display: none;
        }

        /* Hide nav text links, keep CTA button */
        .nav-btn {
            padding: 10px 20px;
            font-size: 9px;
        }

        /* Hero */
        .hero-layout-split {
            padding: 40px 20px 50px;
            gap: 32px;
        }

        .hero h1 {
            font-size: clamp(40px, 12vw, 64px);
            margin-bottom: 20px;
        }

        .hero-editorial-desc {
            font-size: 16px;
            margin-bottom: 32px;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Buttons: Elegant, not heavy bricks */
        .hero-actions {
            flex-direction: column;
            gap: 12px;
            width: auto;
            align-self: stretch;
            align-items: center;
        }

        .btn-ultra {
            width: 100%;
            max-width: 320px; /* Cap width for elegance */
            justify-content: center;
            padding: 16px 32px;
            font-size: 15px;
            border-radius: 50px;
        }

        .btn-u-secondary {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.08);
        }

        /* Device: perfectly centered & scaled */
        .hero-visual-side {
            margin-top: 10px;
        }
        .hero-device-stack {
            width: 220px;
            height: 380px;
            transform: rotateY(-8deg) rotateX(4deg) rotateZ(0deg) !important;
            box-shadow: 0 40px 80px rgba(0,0,0,0.6);
        }

        /* Hide floating panels on mobile */
        .hero-panel {
            display: none;
        }

        /* Blobs */
        .blob-1,
        .blob-2,
        .blob-3 {
            display: none;
        }

        /* Capabilities */
        .cap-section {
            padding: 60px 20px;
        }

        .cap-card {
            padding: 40px 32px;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .cap-title {
            font-size: clamp(32px, 9vw, 52px);
        }

        .cap-stats {
            grid-template-columns: 1fr 1fr;
        }

        /* Impact */
        .impact-section {
            padding: 60px 20px;
        }

        .impact-title {
            font-size: clamp(36px, 10vw, 60px);
        }

        .impact-metrics {
            flex-wrap: wrap;
            gap: 28px;
        }

        .mockup-3d-container {
            display: none;
        }

        /* Hide on small screens */

        /* Footer */
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }

        .premium-footer {
            padding: 60px 20px 40px;
        }
    }

    /* ---- SMALL PHONE: ≤ 480px ---- */
    @media (max-width: 480px) {

        /* Hero */
        .hero-layout-split {
            padding: 40px 16px 50px;
            gap: 40px;
        }

        .hero h1 {
            font-size: clamp(38px, 14vw, 60px);
        }

        .hero-mission {
            letter-spacing: 0.2em;
            font-size: 9px;
        }

        .hero-editorial-desc {
            font-size: 15px;
            line-height: 1.55;
        }

        /* Buttons */
        .btn-ultra {
            padding: 18px 32px;
            font-size: 14px;
            border-radius: 80px;
        }

        /* Device even smaller */
        .hero-device-stack {
            width: 190px;
            height: 320px;
            transform: rotateY(-6deg) rotateX(4deg);
        }

        /* Capabilities */
        .cap-card {
            padding: 28px 20px;
            border-radius: 28px;
        }

        .cap-card-title {
            font-size: 22px;
        }

        .cap-stats {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .stat-item {
            padding: 16px;
        }

        .stat-value {
            font-size: 26px;
        }

        /* Impact */
        .impact-section {
            padding: 50px 16px;
        }

        .impact-desc {
            font-size: 15px;
        }

        /* Footer */
        .premium-footer {
            padding: 50px 16px 32px;
        }

        .footer-brand p {
            max-width: 100%;
        }
    }

    /* --- MOBILE ADAPTIVE TUNING (Agro Aura) --- */
    @media (max-width: 1024px) {
        .hero-layout-split {
            grid-template-columns: 1fr;
            padding: 120px 24px 60px;
            gap: 60px;
            text-align: center;
        }

        .hero-text-side {
            align-items: center;
            text-align: center;
        }

        .hero-title {
            font-size: 56px;
        }

        .hero-3d-showcase {
            transform: none !important;
            opacity: 1 !important;
        }

        .hero-device-stack {
            width: 280px;
            height: 460px;
            transform: rotateY(-10deg) rotateX(5deg) !important;
        }

        .nav-links {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 38px;
        }

        .hero-tag {
            font-size: 8px;
        }

        .feature-grid-hd {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
    }
</style>

<div class="hero-wrap hero">
    <div class="hero-image" id="heroImage"></div>

    <!-- Dynamic Mesh BG -->
    <div class="hero-mesh-bg">
        <div class="mesh-blob blob-1"></div>
        <div class="mesh-blob blob-2"></div>
        <div class="mesh-blob blob-3"></div>
    </div>

    <div class="hero-smoke"></div>


    <!-- Enhanced Nav -->
    <nav class="hero-nav" id="heroNav">
        <div class="nav-inner">
            <a href="/" class="hero-logo">
                <div class="logo-dot"></div>
                AGRO AI
            </a>
            <div class="nav-links">
                <a href="/services" class="nav-link">Сервисы</a>
                <a href="/login" class="nav-btn">Личный кабинет</a>
            </div>

        </div>
    </nav>

    <div class="mesh-leak"></div>

    <div class="hero-layout-split">
        <!-- LEFT SIDE: CONTENT -->
        <div class="hero-text-side">
            <div class="hero-mission" id="hMission">Precision Agriculture Elite</div>
            <div class="hero-category" id="hTag"
                style="color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 5px 16px; border-radius: 100px; font-size: 10px; margin-bottom: 24px;">
                AI INFRASTRUCTURE
            </div>

            <h1 id="hTitle">
                <span class="h1-glow">Революция</span>
                <span class="accent">Агротехнологий</span>
            </h1>

            <p class="hero-editorial-desc" id="hDesc">
                Мы объединяем мощь искусственного интеллекта и вековой опыт земледелия, чтобы создать
                экосистему будущего. Анализируйте, прогнозируйте и управляйте своим урожаем
                с ювелирной точностью из любой точки мира.
            </p>

            <div class="hero-actions" id="hActions">
                <a href="/register" class="btn-ultra btn-u-primary">
                    Начать работу
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <a href="/login" class="btn-ultra btn-u-secondary">Личный кабинет</a>
            </div>
        </div>

        <!-- RIGHT SIDE: 3D SHOWCASE -->
        <div class="hero-visual-side">
            <div class="hero-3d-showcase" id="hShowcase">
                <div class="hero-glow-orb" style="top: 10%; right: -10%;"></div>
                <div class="hero-device-stack" id="hStack">
                    <!-- Smartphone (In Front) -->
                    <div class="device-frame">
                        <div class="device-bezel"></div>
                        <div class="screen-reflection"></div>
                        <div class="device-screen">
                            <!-- Status Bar -->
                            <div class="status-bar">
                                <span>9:41</span>
                                <div style="display: flex; gap: 4px; align-items: center;">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 21l-12-18h24z" />
                                    </svg>
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0v12H4V6h16z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="app-ui-header">
                                <div
                                    style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                    <div style="font-size: 14px; font-weight: 800; color: #fff;">Overview</div>
                                    <div
                                        style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, var(--h-accent), #10b981); opacity: 0.3; border: 1px solid rgba(255,255,255,0.1);">
                                    </div>
                                </div>
                            </div>

                            <div class="app-ui-body">
                                <!-- Yield Tracker Chart -->
                                <div class="yield-tracker">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                        <div>
                                            <div
                                                style="font-size: 7px; color: var(--h-accent); font-weight: 900; letter-spacing: 0.05em; text-transform: uppercase;">
                                                Estimated Yield</div>
                                            <div
                                                style="font-size: 18px; font-weight: 900; color: #fff; margin-top: 2px;">
                                                +14.2%</div>
                                        </div>
                                        <div style="font-size: 7px; color: rgba(255,255,255,0.3); font-weight: 700;">
                                            LIVE v2.4</div>
                                    </div>

                                    <svg viewBox="0 0 100 40"
                                        style="width: 100%; height: 60px; filter: drop-shadow(0 4px 10px rgba(180, 161, 138, 0.2));">
                                        <path d="M0 35 Q 15 5, 30 25 T 60 5 T 100 20" fill="none"
                                            stroke="var(--h-accent)" stroke-width="2.5" stroke-linecap="round"
                                            class="chart-pulse" />
                                        <path d="M0 35 Q 15 5, 30 25 T 60 5 T 100 20 V 40 H 0 Z" fill="var(--h-accent)"
                                            opacity="0.05" />
                                        <circle cx="60" cy="5" r="2" fill="#fff" />
                                    </svg>
                                </div>

                                <!-- Field Stats Grid -->
                                <div class="field-card-grid">
                                    <div class="field-card">
                                        <div class="field-card-icon">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                stroke="var(--h-accent)" stroke-width="2">
                                                <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                                            </svg>
                                        </div>
                                        <div style="font-size: 7px; color: rgba(255,255,255,0.4); font-weight: 800;">
                                            Humidity</div>
                                        <div style="font-size: 14px; font-weight: 800; color: #fff; margin-top: 2px;">
                                            64.2%</div>
                                    </div>
                                    <div class="field-card">
                                        <div class="field-card-icon">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981"
                                                stroke-width="2">
                                                <path
                                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                            </svg>
                                        </div>
                                        <div style="font-size: 7px; color: rgba(255,255,255,0.4); font-weight: 800;">
                                            Nitrogen</div>
                                        <div style="font-size: 14px; font-weight: 800; color: #fff; margin-top: 2px;">
                                            Optimal</div>
                                    </div>
                                </div>

                                <!-- Notification Card -->
                                <div class="field-card"
                                    style="margin-top: auto; background: rgba(180, 161, 138, 0.05); border-color: rgba(180, 161, 138, 0.1);">
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <div
                                            style="width: 20px; height: 20px; border-radius: 50%; background: var(--h-accent); display: flex; align-items: center; justify-content: center; font-size: 10px; color: #000; font-weight: 900;">
                                            !</div>
                                        <div>
                                            <div style="font-size: 10px; color: #fff; font-weight: 700;">Harvest Alert
                                            </div>
                                            <div style="font-size: 8px; color: rgba(255,255,255,0.4);">Sector 04 ready
                                                in 2 days</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Floating Panels -->
                    <div class="hero-panel panel-1">
                        <div
                            style="font-size: 10px; color: var(--h-accent); font-weight: 800; margin-bottom: 10px; letter-spacing: 0.05em;">
                            AI ANALYSIS</div>
                        <div style="font-size: 16px; font-weight: 800; color: #fff; margin-bottom: 4px;">Plot Stability
                        </div>
                        <div style="font-size: 12px; color: rgba(255,255,255,0.4);">94.8% Nominal</div>
                    </div>

                    <div class="hero-panel panel-2">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <div
                                style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 10px #10b981;">
                            </div>
                            <span style="font-size: 9px; color: rgba(255,255,255,0.5); font-weight: 700;">LIVE
                                UPDATES</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 700; color: #fff;">Soil Humidity</div>
                        <div style="font-size: 20px; font-weight: 900; color: #10b981; margin-top: 5px;">62.4%</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- CAPABILITIES SECTION -->
<section class="cap-section">
    <div
        style="position: absolute; top: 10%; right: -5%; font-size: 20vw; font-weight: 900; color: rgba(255,255,255,0.02); pointer-events: none; z-index: 0; white-space: nowrap; font-family: 'Space Grotesk', sans-serif; letter-spacing: -0.05em;">
        ECOSYSTEM
    </div>
    <div class="cap-grid-container">
        <!-- Sticky Header on Left -->
        <div class="cap-header">
            <h2 class="cap-title">Интеллектуальная Экосистема</h2>
            <p class="cap-description">Передовые инструменты для точного земледелия, объединяющие данные, анализ и
                автоматизацию в единый мощный комплекс.</p>

            <div class="cap-stats">
                <div class="stat-item">
                    <span class="stat-value">+28%</span>
                    <span class="stat-label">Урожайность</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">-40%</span>
                    <span class="stat-label">Расходы воды</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">E2E</span>
                    <span class="stat-label">Шифрование</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Realtime</span>
                    <span class="stat-label">Отклик</span>
                </div>
            </div>

            <div class="cap-divider"></div>
        </div>

        <!-- Capability Cards on Right -->
        <div class="cap-grid">
            <div class="cap-card" data-cap>
                <div class="cap-icon-box">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
                <div>
                    <h3 class="cap-card-title">Автономный Мониторинг</h3>
                    <p class="cap-card-desc">Непрерывный поток сверхточных данных с каждого квадратного метра вашего
                        хозяйства в режиме реального времени.</p>
                </div>
            </div>

            <div class="cap-card" data-cap>
                <div class="cap-icon-box">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                        <path d="M2 12h20"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="cap-card-title">Предиктивный AI-Анализ</h3>
                    <p class="cap-card-desc">Прогностические модели на базе нейронных сетей, выявляющие риски и болезни
                        культур задолго до их проявления.</p>
                </div>
            </div>

            <div class="cap-card" data-cap>
                <div class="cap-icon-box">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m12 14 4-4"></path>
                        <path d="M3.34 19a10 10 0 1 1 17.32 0"></path>
                        <path d="M12 12v10"></path>
                        <path d="M12 12 2 12"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="cap-card-title">Бесшовное Управление</h3>
                    <p class="cap-card-desc">Полный контроль над ресурсами и автоматизированными системами полива и
                        удобрения в одно касание.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- SECTION 3: CINEMATIC IMPACT -->
<section class="impact-section">
    <div class="impact-grid-bg"></div>
    <div class="impact-layout">
        <!-- Content Side -->
        <div class="impact-content">
            <span class="impact-tag" id="iTag">Deep Analysis</span>
            <h2 class="impact-title" id="iTitle">Наука<br>Результата</h2>
            <p class="impact-desc" id="iDesc">Мы превращаем хаос данных в строгий математический порядок. Наши алгоритмы
                анализируют тысячи факторов в секунду, обеспечивая стабильность там, где другие видят лишь
                неопределенность.</p>

            <div class="impact-metrics" id="iMetrics">
                <div class="metric-box">
                    <span class="metric-num-small">32%</span>
                    <span class="metric-label">Efficiency Gain</span>
                </div>
                <div class="metric-box">
                    <span class="metric-num-small">E2E</span>
                    <span class="metric-label">Data Integrity</span>
                </div>
            </div>
        </div>

        <!-- Visual Side: 3D Mockup -->
        <div class="mockup-3d-container" id="iVisual">
            <div class="mockup-stack" id="mStack">
                <!-- Base Layer: Dashboard Main -->
                <div class="mockup-layer layer-base">
                    <div class="mockup-sidebar">
                        <div class="sidebar-icon active"></div>
                        <div class="sidebar-icon" style="opacity: 0.3;"></div>
                        <div class="sidebar-icon" style="opacity: 0.3;"></div>
                        <div class="sidebar-icon" style="opacity: 0.3; margin-top: auto;"></div>
                    </div>
                    <div class="mockup-main">
                        <div class="mockup-ui-title">Личный кабинет</div>
                        <div class="mockup-ui-row">
                            <div class="ui-avatar"></div>
                            <div class="ui-line" style="width: 45%;"></div>
                        </div>
                        <div class="mockup-ui-row">
                            <div class="ui-avatar" style="background: linear-gradient(135deg, #10b981, #059669);"></div>
                            <div class="ui-line" style="width: 65%;"></div>
                        </div>
                        <div class="mockup-ui-row" style="opacity: 0.4;">
                            <div class="ui-avatar" style="background: rgba(255,255,255,0.1);"></div>
                            <div class="ui-line" style="width: 30%;"></div>
                        </div>
                    </div>
                </div>
                <!-- Card Layer: Plot Status -->
                <div class="mockup-layer layer-card">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 24px;">
                        <span
                            style="font-size: 9px; color: var(--h-accent); font-weight: 900; letter-spacing: 0.1em;">SYSTEM
                            ONLINE</span>
                        <div
                            style="width: 32px; height: 32px; background: rgba(180, 161, 138, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <div
                                style="width: 6px; height: 6px; background: var(--h-accent); border-radius: 50%; box-shadow: 0 0 10px var(--h-accent);">
                            </div>
                        </div>
                    </div>
                    <div
                        style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 10px; letter-spacing: -0.01em;">
                        Чуйская долина</div>
                    <div style="font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 24px;">Влажность почвы:
                        68.4%</div>

                    <div style="height: 60px; display: flex; align-items: flex-end; gap: 4px;">
                        <div style="flex: 1; height: 40%; background: rgba(255,255,255,0.05); border-radius: 2px;">
                        </div>
                        <div style="flex: 1; height: 65%; background: rgba(255,255,255,0.05); border-radius: 2px;">
                        </div>
                        <div
                            style="flex: 1; height: 85%; background: var(--h-accent); border-radius: 2px; box-shadow: 0 -5px 15px rgba(180,161,138,0.2);">
                        </div>
                        <div style="flex: 1; height: 45%; background: rgba(255,255,255,0.05); border-radius: 2px;">
                        </div>
                        <div style="flex: 1; height: 30%; background: rgba(255,255,255,0.05); border-radius: 2px;">
                        </div>
                    </div>
                </div>
                <!-- Chart Layer: Forecast -->
                <div class="mockup-layer layer-chart">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <div
                            style="font-size: 10px; color: rgba(255,255,255,0.4); font-weight: 800; letter-spacing: 0.05em;">
                            AI PREDICTIVE YIELD</div>
                        <div
                            style="font-size: 10px; color: #fff; background: rgba(16, 185, 129, 0.2); padding: 4px 8px; border-radius: 6px;">
                            LIVE v2</div>
                    </div>
                    <svg viewBox="0 0 100 45"
                        style="width: 100%; height: 90px; filter: drop-shadow(0 5px 15px rgba(180, 161, 138, 0.2));">
                        <path d="M0 40 Q 15 10, 30 30 T 60 5 T 100 25" fill="none" stroke="var(--h-accent)"
                            stroke-width="2.5" stroke-linecap="round" />
                        <path d="M0 40 Q 15 10, 30 30 T 60 5 T 100 25 V 45 H 0 Z" fill="url(#mock-grad)"
                            opacity="0.1" />
                        <defs>
                            <linearGradient id="mock-grad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="var(--h-accent)" />
                                <stop offset="100%" stop-color="transparent" />
                            </linearGradient>
                        </defs>
                        <circle cx="60" cy="5" r="2.5" fill="#fff" />
                    </svg>
                    <div
                        style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 15px;">
                        <div>
                            <div style="font-size: 22px; font-weight: 800; color: #fff; line-height: 1;">+14.2%</div>
                            <div
                                style="font-size: 9px; color: rgba(255,255,255,0.3); margin-top: 4px; text-transform: uppercase;">
                                Confidence 98.2%</div>
                        </div>
                        <div
                            style="width: 40px; height: 40px; background: rgba(255,255,255,0.03); border-radius: 50%; border: 1px solid rgba(255,255,255,0.05);">
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>





<!-- FOOTER: CINEMATIC FINALE -->
<footer class="premium-footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <a href="#" class="footer-logo">
                <div class="logo-dot"></div>
                AGROCARE
            </a>
            <p>Будущее сельского хозяйства уже здесь. Мы внедряем интеллект в каждый гектар, обеспечивая
                продовольственную безопасность и устойчивое развитие бизнеса.</p>
            <div class="footer-social">
                <a href="#" class="social-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                </a>
                <a href="#" class="social-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path
                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                        </path>
                    </svg>
                </a>
                <a href="#" class="social-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                    </svg>
                </a>
            </div>
        </div>

        <div class="footer-column">
            <h4>Сервисы</h4>
            <ul class="footer-links">
                <li><a href="#">Анализ почты</a></li>
                <li><a href="#">Прогноз урожая</a></li>
                <li><a href="#">Мониторинг засухи</a></li>
                <li><a href="#">AI Ассистент</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Компания</h4>
            <ul class="footer-links">
                <li><a href="#">О нас</a></li>
                <li><a href="#">Технологии</a></li>
                <li><a href="#">Карьера</a></li>
                <li><a href="#">Контакты</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Поддержка</h4>
            <p style="margin-bottom: 24px;">Будьте в курсе последних обновлений AgroCare.</p>
            <div style="position: relative;">
                <input type="text" placeholder="Email адрес"
                    style="width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 50px; padding: 14px 20px; color: #fff; font-size: 14px; outline: none;">
                <button
                    style="position: absolute; right: 5px; top: 5px; bottom: 5px; background: var(--h-accent); border: none; border-radius: 50px; padding: 0 20px; font-weight: 800; font-size: 11px; text-transform: uppercase;">OK</button>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <span>© 2026 AgroCare AI Systems. Все права защищены.</span>
        <div style="display: flex; gap: 32px;">
            <a href="#" style="color: inherit; text-decoration: none;">Privacy Policy</a>
            <a href="#" style="color: inherit; text-decoration: none;">Terms of Service</a>
        </div>
    </div>
</footer>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tl = gsap.timeline({ defaults: { ease: "expo.out", duration: 1.6 } });

        tl.to("#heroNav", { opacity: 1, y: 0, delay: 0.2 })
            .to("#hMission", { opacity: 1 }, "-=1.2")
            .to("#hTag", { opacity: 1 }, "-=1.3")
            .to("#hTitle", { opacity: 1, x: 0 }, "-=1.4")
            .to("#hDesc", { opacity: 1, x: 0 }, "-=1.4")
            .to("#hActions", { opacity: 1, y: 0 }, "-=1.4")
            .to("#hShowcase", { opacity: 1, x: 0, duration: 2.2, ease: "expo.out" }, "-=1.8");

        // Hero 3D Parallax Tilt & Initial Composition
        const heroWrap = document.querySelector('.hero-wrap');
        const heroStack = document.getElementById('hStack');

        if (heroWrap && heroStack) {
            // Initial cinematic angle
            gsap.set(heroStack, {
                rotateY: -25,
                rotateX: 12,
                rotateZ: 4
            });

            heroWrap.addEventListener('mousemove', (e) => {
                const rect = heroWrap.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;

                gsap.to(heroStack, {
                    rotateY: -25 + x * 20,
                    rotateX: 12 - y * 20,
                    rotateZ: 4 + x * 3,
                    duration: 0.8,
                    ease: "power2.out"
                });
            });

            heroWrap.addEventListener('mouseleave', () => {
                gsap.to(heroStack, {
                    rotateY: -25,
                    rotateX: 12,
                    rotateZ: 4,
                    duration: 1.5,
                    ease: "expo.out"
                });
            });
        }


        gsap.fromTo("#heroImage",
            { scale: 1.05 },
            { scale: 1, duration: 20, ease: "sine.inOut", repeat: -1, yoyo: true }
        );


        // Scroll animations — через IntersectionObserver (работает с глобальным скроллом)
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -20px 0px'
        };

        // Заголовок секции — CSS анимация, без GSAP (чтобы opacity не блокировал дочерние элементы)

        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    gsap.to(entry.target, {
                        opacity: 1,
                        y: 0,
                        duration: 1.2,
                        ease: "expo.out",
                        delay: parseFloat(entry.target.dataset.delay || 0)
                    });
                    cardObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('[data-cap]').forEach((card, i) => {
            card.dataset.delay = i * 0.15;
            gsap.set(card, { opacity: 0, y: 60 });
            cardObserver.observe(card);
        });

        // Impact Section Animations
        const iTl = gsap.timeline({
            scrollTrigger: {
                trigger: ".impact-section",
                start: "top 70%",
                toggleActions: "play none none reverse"
            }
        });

        iTl.to("#iTag", { opacity: 1, y: 0, duration: 1 })
            .to("#iTitle", { opacity: 1, x: 0, duration: 1.2 }, "-=0.7")
            .to("#iDesc", { opacity: 1, x: 0, duration: 1.2 }, "-=1")
            .to("#iMetrics", { opacity: 1, y: 0, duration: 1 }, "-=1")
            .to("#iVisual", { opacity: 1, x: 0, scale: 1, duration: 1.5, ease: "expo.out" }, "-=1.5");

        // 3D Parallax Tilt
        const section = document.querySelector('.impact-section');
        const stack = document.getElementById('mStack');
        if (section && stack) {
            section.addEventListener('mousemove', (e) => {
                const rect = section.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width - 0.5;
                const y = (e.clientY - rect.top) / rect.height - 0.5;

                gsap.to(stack, {
                    rotateY: -25 + x * 20,
                    rotateX: 15 - y * 20,
                    duration: 0.5,
                    ease: "power2.out"
                });
            });

            section.addEventListener('mouseleave', () => {
                gsap.to(stack, {
                    rotateY: -25,
                    rotateX: 15,
                    duration: 1,
                    ease: "power2.out"
                });
            });
        }

    });
</script>