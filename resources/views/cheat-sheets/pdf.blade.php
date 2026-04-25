<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sheet['title'] }} — Cheat Sheet | Quiz System</title>
    <meta name="description" content="{{ $sheet['description'] }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           DESIGN TOKENS — Light Paper + Terminal Code
           ============================================================ */
        :root {
            /* Surfaces (light) */
            --paper:        #ffffff;
            --paper-2:      #f7f8fa;
            --paper-3:      #eef1f5;
            --paper-tint:   #fafbfc;

            /* Borders */
            --border:       #e2e6ec;
            --border-soft:  #eef1f5;
            --border-hi:    #cbd2db;

            /* Text */
            --ink:          #0b1220;
            --ink-2:        #1f2937;
            --ink-dim:      #475569;
            --ink-mute:     #64748b;
            --ink-faint:    #94a3b8;

            /* Brand / accents */
            --accent:       #047857;        /* deep terminal green for ink */
            --accent-2:     #10b981;
            --accent-soft:  #d1fae5;
            --warn:         #b45309;
            --warn-soft:    #fef3c7;
            --info:         #1d4ed8;
            --magenta:      #7c3aed;
            --pink:         #be185d;
            --red:          #b91c1c;

            /* Code (dark for contrast) */
            --code-bg:      #0b1020;
            --code-bg-2:    #131a2d;
            --code-bg-3:    #1b2440;
            --code-fg:      #f1f5f9;
            --code-fg-dim:  #cbd5e1;
            --code-comment: #94a3b8;
            --code-keyword: #f472b6;
            --code-string:  #fbbf24;
            --code-fn:      #60a5fa;
            --code-num:     #a78bfa;
            --code-line:    #64748b;

            /* Sheet-specific */
            --sheet-color:  {{ $sheet['color'] ?? '#047857' }};
            --sheet-bg:     {{ $sheet['bg']    ?? '#d1fae5' }};

            /* Type */
            --font-mono:    'JetBrains Mono', ui-monospace, 'SF Mono', Menlo, Consolas, monospace;
            --font-sans:    'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

            /* Radius / Shadow */
            --r-sm: 6px;
            --r-md: 10px;
            --r-lg: 14px;
            --shadow-sm: 0 1px 2px rgba(15,23,42,0.04), 0 1px 1px rgba(15,23,42,0.03);
            --shadow-md: 0 4px 12px rgba(15,23,42,0.06), 0 2px 4px rgba(15,23,42,0.04);
            --shadow-code: 0 8px 24px rgba(7,11,32,0.18), 0 2px 6px rgba(7,11,32,0.12);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            background: var(--paper);
            color: var(--ink);
        }

        body {
            font-family: var(--font-sans);
            font-size: 10.5pt;
            line-height: 1.55;
            padding: 36px 44px 60px;
            max-width: 1080px;
            margin: 0 auto;
            position: relative;
            /* Subtle paper grid */
            background-image:
                linear-gradient(to right, rgba(15,23,42,0.025) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(15,23,42,0.025) 1px, transparent 1px);
            background-size: 32px 32px;
            background-position: -1px -1px;
        }

        /* ============================================================
           WATERMARK — repeating diagonal pattern (visible but soft)
           ============================================================ */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            background-image: repeating-linear-gradient(
                -30deg,
                transparent 0,
                transparent 220px,
                rgba(4,120,87,0.045) 220px,
                rgba(4,120,87,0.045) 221px
            );
        }

        .watermark-layer {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 2;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            align-content: space-around;
            justify-content: space-around;
            transform: rotate(-28deg);
            transform-origin: center;
            padding: 0 -10%;
        }

        .watermark-layer span {
            font-family: var(--font-mono);
            font-size: 28pt;
            font-weight: 800;
            letter-spacing: 4px;
            color: rgba(4,120,87,0.06);
            text-transform: uppercase;
            white-space: nowrap;
            padding: 60px 40px;
            user-select: none;
        }

        /* All real content sits above watermarks */
        .hero, .toc, .section, .footer { position: relative; z-index: 3; }

        /* ============================================================
           HERO
           ============================================================ */
        .hero {
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 28px;
        }

        .hero-bar {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 18px;
            background: var(--paper-2);
            border-bottom: 1px solid var(--border);
            font-family: var(--font-mono);
            font-size: 9pt;
            color: var(--ink-mute);
        }

        .dots { display: flex; gap: 6px; }
        .dot {
            width: 11px; height: 11px; border-radius: 50%;
            display: inline-block;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.08);
        }
        .dot.r { background: #ff5f57; }
        .dot.y { background: #febc2e; }
        .dot.g { background: #28c840; }

        .path { display: flex; gap: 4px; flex: 1; align-items: center; }
        .crumb-sep { color: var(--ink-faint); }
        .crumb-active { color: var(--accent); font-weight: 600; }

        .hero-bar .badge {
            font-family: var(--font-mono);
            font-size: 7.5pt;
            font-weight: 600;
            color: var(--accent);
            background: var(--accent-soft);
            border: 1px solid #6ee7b7;
            padding: 3px 8px;
            border-radius: 999px;
            letter-spacing: 0.5px;
        }

        .hero-content {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 24px;
            padding: 28px 28px 26px;
            align-items: flex-start;
        }

        .logo-box {
            width: 76px; height: 76px;
            background: var(--paper-2);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            box-shadow: var(--shadow-sm);
        }
        .logo-box img, .logo-box svg {
            width: 44px; height: 44px;
        }

        .info { min-width: 0; }

        .prompt {
            font-family: var(--font-mono);
            font-size: 9pt;
            color: var(--ink-mute);
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .prompt .user { color: var(--accent); font-weight: 600; }
        .prompt .at, .prompt .colon { color: var(--ink-faint); }
        .prompt .host { color: var(--info); font-weight: 600; }
        .prompt .cwd { color: var(--magenta); }
        .prompt .arrow { color: var(--accent); margin: 0 4px; font-weight: 700; }
        .prompt .cmd { color: var(--ink); }

        .title {
            font-family: var(--font-sans);
            font-size: 26pt;
            font-weight: 800;
            line-height: 1.1;
            color: var(--ink);
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }
        .title .caret {
            display: inline-block;
            width: 3px; height: 0.85em;
            margin-left: 6px;
            background: var(--accent);
            transform: translateY(2px);
            animation: blink 1.05s step-end infinite;
        }
        @keyframes blink { 50% { opacity: 0; } }

        .description {
            font-size: 11pt;
            color: var(--ink-dim);
            margin-bottom: 14px;
            max-width: 65ch;
        }

        .tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
        .tag {
            font-family: var(--font-mono);
            font-size: 8pt;
            font-weight: 600;
            padding: 3px 9px;
            background: var(--paper-2);
            color: var(--accent);
            border: 1px solid var(--border);
            border-radius: 999px;
            letter-spacing: 0.3px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            overflow: hidden;
            margin-top: 4px;
        }
        .stat {
            background: var(--paper);
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .stat-label {
            font-family: var(--font-mono);
            font-size: 7.5pt;
            color: var(--ink-mute);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .stat-value {
            font-family: var(--font-mono);
            font-size: 14pt;
            font-weight: 700;
            color: var(--ink);
        }
        .stat-value .unit {
            font-size: 8pt;
            color: var(--ink-mute);
            font-weight: 500;
            margin-left: 2px;
        }

        /* ============================================================
           TABLE OF CONTENTS
           ============================================================ */
        .toc {
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 18px 22px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-sm);
        }
        .toc-title {
            font-family: var(--font-mono);
            font-size: 9pt;
            color: var(--ink-mute);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
        }
        .toc-title::before { content: "// "; color: var(--accent); }

        .toc-list {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px 24px;
        }
        .toc-list li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 8px;
            border-radius: var(--r-sm);
            text-decoration: none;
            color: var(--ink-2);
            font-size: 10pt;
            border: 1px solid transparent;
            transition: background 0.15s, border-color 0.15s;
        }
        .toc-list li a:hover {
            background: var(--paper-2);
            border-color: var(--border);
        }
        .toc-list li .num {
            font-family: var(--font-mono);
            font-size: 8.5pt;
            font-weight: 700;
            color: var(--accent);
            min-width: 22px;
        }
        .toc-list li .count {
            margin-left: auto;
            font-family: var(--font-mono);
            font-size: 8pt;
            color: var(--ink-faint);
        }

        /* ============================================================
           SECTION
           ============================================================ */
        .section {
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            margin-bottom: 22px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .section-header {
            padding: 16px 22px 14px;
            background: linear-gradient(180deg, var(--paper-2) 0%, var(--paper) 100%);
            border-bottom: 1px solid var(--border);
        }
        .section-header h2 {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: var(--font-sans);
            font-size: 14pt;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.01em;
        }
        .section-header h2 .num {
            font-family: var(--font-mono);
            font-size: 9pt;
            font-weight: 700;
            color: var(--accent);
            background: var(--accent-soft);
            padding: 4px 8px;
            border-radius: var(--r-sm);
            letter-spacing: 0.5px;
        }
        .section-note {
            margin-top: 8px;
            font-family: var(--font-mono);
            font-size: 9pt;
            color: var(--ink-mute);
            padding-left: 0;
        }
        .section-note::before { content: "// "; color: var(--accent); }

        /* ============================================================
           ITEM
           ============================================================ */
        .item {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border-soft);
        }
        .item:last-child { border-bottom: none; }

        .item-layout {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 22px;
            align-items: flex-start;
        }
        .item-label { padding-top: 8px; }

        .label-badge {
            display: inline-block;
            font-family: var(--font-mono);
            font-size: 9pt;
            font-weight: 600;
            color: var(--warn);
            background: var(--warn-soft);
            border: 1px solid #fcd34d;
            padding: 4px 10px;
            border-radius: var(--r-sm);
            letter-spacing: 0.2px;
        }

        /* ============================================================
           CODE BLOCK — high-contrast dark on light page
           ============================================================ */
        .code-block {
            background: var(--code-bg);
            border-radius: var(--r-md);
            overflow: hidden;
            border: 1px solid var(--code-bg-3);
            box-shadow: var(--shadow-code);
        }

        .code-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 14px;
            background: var(--code-bg-2);
            border-bottom: 1px solid var(--code-bg-3);
        }
        .code-lang {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-mono);
            font-size: 8.5pt;
            font-weight: 600;
            color: var(--code-fg-dim);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .code-lang::before {
            content: "";
            display: inline-block;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--accent-2);
            box-shadow: 0 0 8px rgba(16,185,129,0.7);
        }
        .code-actions { display: flex; gap: 5px; }
        .code-actions span {
            width: 8px; height: 8px;
            border-radius: 2px;
            background: var(--code-bg-3);
            display: inline-block;
        }

        .code-wrapper {
            display: flex;
            background: var(--code-bg);
        }

        .line-numbers {
            display: flex;
            flex-direction: column;
            padding: 14px 0;
            background: rgba(0,0,0,0.18);
            border-right: 1px solid var(--code-bg-3);
            user-select: none;
            flex-shrink: 0;
        }
        .line-number {
            font-family: var(--font-mono);
            font-size: 9pt;
            color: var(--code-line);
            padding: 0 14px;
            line-height: 1.65;
            text-align: right;
            min-width: 44px;
        }

        .code-content {
            margin: 0;
            padding: 14px 18px;
            font-family: var(--font-mono);
            font-size: 9.5pt;
            font-weight: 500;
            color: var(--code-fg);
            line-height: 1.65;
            white-space: pre;
            overflow-x: auto;
            flex: 1;
            background: var(--code-bg);
            tab-size: 4;
        }

        /* slim scrollbar inside code blocks */
        .code-content::-webkit-scrollbar,
        .code-wrapper::-webkit-scrollbar { height: 6px; }
        .code-content::-webkit-scrollbar-thumb,
        .code-wrapper::-webkit-scrollbar-thumb { background: var(--code-bg-3); border-radius: 3px; }

        /* ============================================================
           NOTE
           ============================================================ */
        .note {
            margin-top: 12px;
            padding: 10px 14px;
            background: var(--warn-soft);
            border-left: 3px solid var(--warn);
            border-radius: var(--r-sm);
            font-size: 9pt;
            color: #78350f;
            font-family: var(--font-mono);
        }
        .note::before { content: "// note: "; color: var(--warn); font-weight: 700; }

        /* ============================================================
           FOOTER
           ============================================================ */
        .footer {
            margin-top: 32px;
            padding: 18px 22px;
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            font-family: var(--font-mono);
            font-size: 8.5pt;
            color: var(--ink-mute);
            box-shadow: var(--shadow-sm);
        }
        .footer .row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .footer .row + .row { margin-top: 6px; color: var(--ink-faint); }
        .footer .accent { color: var(--accent); font-weight: 700; }
        .footer .sep { color: var(--ink-faint); }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width: 760px) {
            body { padding: 24px 16px 40px; }
            .hero-content { grid-template-columns: 1fr; padding: 22px 18px; gap: 18px; }
            .hero-bar { padding: 10px 14px; }
            .hero-bar .badge { display: none; }
            .title { font-size: 22pt; }
            .item-layout { grid-template-columns: 1fr; gap: 12px; }
            .item-label { padding-top: 0; }
            .stats { grid-template-columns: repeat(2, 1fr); }
            .toc-list { grid-template-columns: 1fr; }
            .watermark-layer span { font-size: 20pt; padding: 40px 24px; }
        }

        /* ============================================================
           PRINT / PDF
           ============================================================ */
        @page { size: A4; margin: 1.4cm 1.3cm; }

        @media print {
            html, body {
                background: #ffffff !important;
                color: #0b1220 !important;
            }
            body {
                padding: 0;
                background-image: none !important;
                max-width: none;
            }
            body::before { display: none !important; }

            /* Stronger watermark in print */
            .watermark-layer { position: fixed !important; }
            .watermark-layer span {
                color: rgba(4,120,87,0.085) !important;
                font-size: 32pt !important;
            }

            .hero, .section, .toc, .footer {
                box-shadow: none !important;
                break-inside: avoid;
                page-break-inside: avoid;
            }

            /* Code stays dark for legibility on paper */
            .code-block {
                background: #0b1020 !important;
                border-color: #1b2440 !important;
                box-shadow: none !important;
            }
            .code-content, .code-wrapper { background: #0b1020 !important; color: #f1f5f9 !important; }
            .code-header { background: #131a2d !important; }
            .line-numbers { background: rgba(0,0,0,0.25) !important; }

            .toc { break-after: page; }
            .title .caret { display: none !important; }
        }
    </style>
</head>
<body>

    {{-- ==================== WATERMARK LAYER ==================== --}}
    @php
        $wmText = strtoupper($sheet['title'] ?? 'QUIZ SYSTEM') . ' · QUIZ SYSTEM';
    @endphp
    <div class="watermark-layer" aria-hidden="true">
        @for($i = 0; $i < 18; $i++)
            <span>{{ $wmText }}</span>
        @endfor
    </div>

    {{-- ==================== HERO ==================== --}}
    @php
        $slug = \Illuminate\Support\Str::slug($sheet['title']);
        $totalSnippets = collect($sheet['sections'])->sum(fn($s) => count($s['items']));
        $totalSections = count($sheet['sections']);
    @endphp

    <header class="hero">
        <div class="hero-bar">
            <div class="dots">
                <span class="dot r"></span>
                <span class="dot y"></span>
                <span class="dot g"></span>
            </div>
            <div class="path">
                <span>~</span>
                <span class="crumb-sep">/</span>
                <span>quiz-system</span>
                <span class="crumb-sep">/</span>
                <span>cheatsheets</span>
                <span class="crumb-sep">/</span>
                <span class="crumb-active">{{ $slug }}.md</span>
            </div>
            <span class="badge">v1.0</span>
        </div>

        <div class="hero-content">
            <div class="logo-box">
                @if(!empty($sheet['image']))
                    <img src="{{ public_path($sheet['image']) }}" alt="{{ $sheet['title'] }}">
                @else
                    {!! $sheet['svg'] !!}
                @endif
            </div>

            <div class="info">
                <div class="prompt">
                    <span class="user">dev</span><span class="at">@</span><span class="host">quiz-system</span><span class="colon">:</span><span class="cwd">~/cheatsheets</span><span class="arrow">❯</span><span class="cmd">cat {{ $slug }}.md</span>
                </div>

                <h1 class="title">{{ $sheet['title'] }}<span class="caret"></span></h1>

                <p class="description">{{ $sheet['description'] }}</p>

                @if(!empty($sheet['tags']))
                    <div class="tags">
                        @foreach($sheet['tags'] as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="stats">
                    <div class="stat">
                        <span class="stat-label">Sections</span>
                        <span class="stat-value">{{ str_pad($totalSections, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Snippets</span>
                        <span class="stat-value">{{ str_pad($totalSnippets, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Updated</span>
                        <span class="stat-value" style="font-size:11pt;">{{ now()->format('Y-m-d') }}</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Format</span>
                        <span class="stat-value" style="font-size:11pt;">A4 <span class="unit">PDF</span></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ==================== TABLE OF CONTENTS ==================== --}}
    @if($totalSections > 1)
        <nav class="toc" aria-label="Table of contents">
            <div class="toc-title">Contents</div>
            <ol class="toc-list">
                @foreach($sheet['sections'] as $i => $section)
                    <li>
                        <a href="#section-{{ $i + 1 }}">
                            <span class="num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ $section['title'] }}</span>
                            <span class="count">{{ count($section['items']) }}</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </nav>
    @endif

    {{-- ==================== SECTIONS ==================== --}}
    @foreach($sheet['sections'] as $i => $section)
        <section class="section" id="section-{{ $i + 1 }}">
            <div class="section-header">
                <h2>
                    <span class="num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span>{{ $section['title'] }}</span>
                </h2>
                @if(!empty($section['note']))
                    <p class="section-note">{{ $section['note'] }}</p>
                @endif
            </div>

            @foreach($section['items'] as $item)
                <article class="item">
                    <div class="item-layout">
                        <div class="item-label">
                            <span class="label-badge">{{ $item['label'] }}</span>
                        </div>

                        <div class="item-code">
                            <div class="code-block">
                                <div class="code-header">
                                    <span class="code-lang">{{ $item['lang'] ?? 'code' }}</span>
                                    <span class="code-actions"><span></span><span></span><span></span></span>
                                </div>

                                @php
                                    $lines = explode("\n", rtrim($item['code']));
                                @endphp

                                <div class="code-wrapper">
                                    <div class="line-numbers">
                                        @foreach($lines as $lineNum => $line)
                                            <span class="line-number">{{ str_pad($lineNum + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        @endforeach
                                    </div>
                                    <pre class="code-content">{{ $item['code'] }}</pre>
                                </div>
                            </div>

                            @if(!empty($item['note']))
                                <div class="note">{{ $item['note'] }}</div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </section>
    @endforeach

    {{-- ==================== FOOTER ==================== --}}
    <footer class="footer">
        <div class="row">
            <span class="accent">$</span>
            <span>echo "Quiz System — {{ $sheet['title'] }} Cheat Sheet"</span>
        </div>
        <div class="row meta">
            <span>Generated {{ now()->format('M d, Y · H:i') }}</span>
            <span class="sep">•</span>
            <span>{{ $totalSections }} sections / {{ $totalSnippets }} snippets</span>
            <span class="sep">•</span>
            <span>quiz-system.local</span>
        </div>
    </footer>

</body>
</html>
