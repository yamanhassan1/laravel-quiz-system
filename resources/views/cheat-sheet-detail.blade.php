<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $sheet['description'] }}">
    <title>{{ $sheet['title'] }} — Cheat Sheets — Quiz System</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent: {{ $sheet['color'] }};
            --accent-bg: {{ $sheet['bg'] }};
            --sidebar-w: 260px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f8f9fc;
        }

        h1, h2, h3 {
            font-family: 'Syne', sans-serif;
        }

        code, pre, .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: #fff;
            border-right: 1px solid #e8eaf0;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            transition: all 0.15s ease;
            margin: 1px 6px;
        }

        .sidebar-item:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .sidebar-item.active {
            background: var(--accent-bg);
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar-logo {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--accent-bg);
            padding: 3px;
        }

        .sidebar-logo img,
        .sidebar-logo svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* ── Code Block Improvements ── */
        .code-block {
            background: #0f1117;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #1e2230;
            position: relative;
        }

        .code-block-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 14px;
            background: #161822;
            border-bottom: 1px solid #1e2230;
        }

        .code-block-dots {
            display: flex;
            gap: 5px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .dot-red   { background: #ff5f57; }
        .dot-yellow{ background: #febc2e; }
        .dot-green { background: #28c840; }

        .code-block-lang {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .code-copy-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #4a5568;
            background: none;
            border: 1px solid #2a2d3e;
            border-radius: 5px;
            padding: 3px 8px;
            cursor: pointer;
            font-family: 'JetBrains Mono', monospace;
            transition: all 0.15s ease;
        }

        .code-copy-btn:hover {
            color: #10b981;
            border-color: #10b981;
            background: #10b98115;
        }

        .code-copy-btn.copied {
            color: #10b981;
            border-color: #10b981;
            background: #10b98115;
        }

        .code-body {
            display: flex;
            overflow-x: auto;
            max-height: 500px;
        }

        .line-numbers {
            display: flex;
            flex-direction: column;
            padding: 14px 0;
            background: #0d0f1a;
            border-right: 1px solid #1e2230;
            user-select: none;
            flex-shrink: 0;
        }

        .line-number {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: #2d3348;
            padding: 0 12px;
            line-height: 1.75;
            text-align: right;
            min-width: 40px;
            white-space: nowrap;
        }

        /* Word wrap by default */
        .code-content {
            padding: 14px 16px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: #e2e8f0;
            line-height: 1.75;
            white-space: pre-wrap;
            word-wrap: break-word;
            word-break: break-word;
            overflow-x: hidden;
            flex: 1;
            margin: 0;
            background: #0f1117;
        }

        /* Optional horizontal scroll mode (when toggled) */
        .code-content.nowrap {
            white-space: pre;
            overflow-x: auto;
            word-wrap: normal;
            word-break: normal;
        }

        .code-content br {
            display: none;
        }

        /* ── Section Card ── */
        .section-card {
            background: #fff;
            border: 1px solid #e8eaf0;
            border-radius: 14px;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        .section-card:hover {
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }

        .section-header {
            padding: 14px 20px;
            border-bottom: 1px solid #f1f5f9;
            background: color-mix(in srgb, var(--accent) 6%, white);
        }

        .section-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .section-note {
            font-size: 12px;
            color: #64748b;
            margin-top: 6px;
            display: flex;
            align-items: flex-start;
            gap: 6px;
            line-height: 1.5;
        }

        /* ── Item Row ── */
        .item-row {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 14px;
            padding: 14px 20px;
            border-bottom: 1px solid #f8f9fc;
            align-items: start;
            transition: background 0.1s ease;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-row:hover {
            background: #fafbfd;
        }

        .item-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 3px 8px;
            border-radius: 5px;
            display: inline-block;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            margin-top: 2px;
        }

        .item-note {
            font-size: 11.5px;
            color: #94a3b8;
            margin-top: 6px;
            display: flex;
            align-items: flex-start;
            gap: 5px;
            line-height: 1.5;
        }

        /* ── Quick Jump ── */
        .jump-btn {
            font-size: 11px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            color: #64748b;
            background: #fff;
            cursor: pointer;
            transition: all 0.15s ease;
            white-space: nowrap;
            font-family: 'JetBrains Mono', monospace;
        }

        .jump-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-bg);
        }

        /* ── Hero Badge ── */
        .hero-logo {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border: 2px solid color-mix(in srgb, var(--accent) 20%, transparent);
            box-shadow: 0 8px 24px color-mix(in srgb, var(--accent) 20%, transparent);
            background: var(--accent-bg);
            flex-shrink: 0;
        }

        .hero-logo img, .hero-logo svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* ── Tag ── */
        .tag-pill {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 3px 8px;
            border-radius: 20px;
            border: 1px solid color-mix(in srgb, var(--accent) 30%, transparent);
            background: var(--accent-bg);
            color: var(--accent);
            text-transform: uppercase;
        }

        /* ── Item count badge ── */
        .count-badge {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
            background: rgba(255,255,255,0.8);
            color: var(--accent);
            border: 1px solid color-mix(in srgb, var(--accent) 25%, transparent);
        }

        /* ── Toast ── */
        #toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #0f1117;
            color: #e2e8f0;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            transform: translateY(12px);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: none;
            z-index: 100;
            border: 1px solid #1e2230;
        }

        #toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Download Button ── */
        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            background: linear-gradient(135deg, var(--accent), color-mix(in srgb, var(--accent) 80%, black));
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 600;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        }

        /* Wrap toggle button */
        .wrap-toggle {
            background: rgba(255,255,255,0.05);
            border: 1px solid #2a2d3e;
            border-radius: 5px;
            padding: 2px 8px;
            font-size: 10px;
            color: #94a3b8;
            cursor: pointer;
            font-family: 'JetBrains Mono', monospace;
            transition: all 0.15s;
        }

        .wrap-toggle:hover {
            background: #2a2d3e;
            color: #fff;
        }

        .wrap-toggle-small {
            background: rgba(255,255,255,0.05);
            border: 1px solid #2a2d3e;
            border-radius: 4px;
            padding: 2px 6px;
            font-size: 9px;
            color: #94a3b8;
            cursor: pointer;
            font-family: 'JetBrains Mono', monospace;
            transition: all 0.15s;
        }

        .wrap-toggle-small:hover {
            background: #2a2d3e;
            color: #fff;
        }

        /* ── Scrollbar ── */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 99px; }

        .code-body::-webkit-scrollbar { height: 4px; }
        .code-body::-webkit-scrollbar-track { background: #0f1117; }
        .code-body::-webkit-scrollbar-thumb { background: #2a2d3e; border-radius: 99px; }

        @media (max-width: 1024px) {
            .sidebar { display: none !important; }
        }

        @media (max-width: 640px) {
            .item-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <x-user-navbar></x-user-navbar>

    <div class="flex flex-1" style="min-height: calc(100vh - 56px);">

        {{-- ── Sidebar ── --}}
        <aside class="sidebar hidden lg:flex flex-col sticky top-14 h-[calc(100vh-3.5rem)] overflow-y-auto shrink-0">
            <div style="padding: 20px 18px 12px;">
                <p style="font-family:'Syne',sans-serif; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.1em;">
                    Cheat Sheets
                </p>
            </div>
            <nav style="padding-bottom: 20px;">
                @foreach($allSheets as $s)
                <a href="{{ route('cheat-sheets.show', $s['slug']) }}"
                    class="sidebar-item {{ $s['slug'] === $slug ? 'active' : '' }}">
                    <div class="sidebar-logo" style="background: {{ $s['bg'] }}">
                        @if(!empty($s['image']))
                            <img src="{{ $s['image'] }}" alt="{{ $s['title'] }}"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;">
                                {!! $s['svg'] !!}
                            </div>
                        @else
                            {!! $s['svg'] !!}
                        @endif
                    </div>
                    <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $s['title'] }}</span>
                </a>
                @endforeach
            </nav>
        </aside>

        {{-- ── Main ── --}}
        <main style="flex:1;min-width:0;padding:32px 28px 60px;max-width:900px;" id="print-content">

            {{-- Breadcrumb --}}
            <div class="no-print" style="display:flex;align-items:center;gap:8px;font-size:12px;color:#94a3b8;margin-bottom:24px;">
                <a href="{{ route('cheat-sheets.index') }}" style="color:#94a3b8;text-decoration:none;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#94a3b8'">
                    Cheat Sheets
                </a>
                <span style="color:#cbd5e1;">›</span>
                <span style="color:#475569;font-weight:600;">{{ $sheet['title'] }}</span>
            </div>

            {{-- Hero --}}
            <div style="display:flex;align-items:flex-start;gap:20px;margin-bottom:32px;padding:24px;background:#fff;border-radius:16px;border:1px solid #e8eaf0;">
                <div class="hero-logo">
                    @if(!empty($sheet['image']))
                        <img src="{{ $sheet['image'] }}" alt="{{ $sheet['title'] }}"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div style="display:none;width:100%;height:100%;align-items:center;justify-content:center;">
                            {!! $sheet['svg'] !!}
                        </div>
                    @else
                        {!! $sheet['svg'] !!}
                    @endif
                </div>
                <div style="flex:1;">
                    <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-bottom:8px;">
                        <h1 style="font-family:'Syne',sans-serif;font-size:26px;font-weight:800;color:#0f172a;margin:0;line-height:1.2;">
                            {{ $sheet['title'] }}
                        </h1>
                        @foreach($sheet['tags'] as $tag)
                            <span class="tag-pill">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <p style="font-size:14px;color:#64748b;line-height:1.6;margin:0;">
                        {{ $sheet['description'] }}
                    </p>
                    <div style="display:flex;align-items:center;gap:16px;margin-top:14px;">
                        <span style="font-size:12px;color:#94a3b8;font-family:'JetBrains Mono',monospace;">
                            {{ count($sheet['sections']) }} sections
                        </span>
                        <span style="color:#e2e8f0;">·</span>
                        <span style="font-size:12px;color:#94a3b8;font-family:'JetBrains Mono',monospace;">
                            {{ collect($sheet['sections'])->sum(fn($s) => count($s['items'])) }} items
                        </span>
                    </div>
                </div>
            </div>

            {{-- Download Button --}}
            <div class="no-print" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;gap:12px;flex-wrap:wrap;">
                <div style="display:flex;gap:8px;">
                    <button class="wrap-toggle" onclick="toggleAllCodeWrap()">Disable Word Wrap</button>
                </div>
                <form action="{{ route('cheat-sheets.download', $slug) }}" method="GET" target="_blank">
                    <button type="submit" class="download-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download PDF
                    </button>
                </form>
            </div>

            {{-- Quick Jump --}}
            @if(count($sheet['sections']) > 1)
            <div class="no-print" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:28px;padding:16px 20px;background:#fff;border-radius:12px;border:1px solid #e8eaf0;">
                <span style="font-family:'JetBrains Mono',monospace;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;margin-right:4px;">
                    Jump to
                </span>
                @foreach($sheet['sections'] as $i => $section)
                    <button class="jump-btn" onclick="scrollToSection('section-{{ $i }}')">
                        {{ $section['title'] }}
                    </button>
                @endforeach
            </div>
            @endif

            {{-- Sections --}}
            <div style="display:flex;flex-direction:column;gap:20px;">
                @foreach($sheet['sections'] as $i => $section)
                <div id="section-{{ $i }}" class="section-card" style="scroll-margin-top:80px;">

                    {{-- Section Header --}}
                    <div class="section-header">
                        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                            <h2>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="16 18 22 12 16 6"/>
                                    <polyline points="8 6 2 12 8 18"/>
                                </svg>
                                {{ $section['title'] }}
                            </h2>
                            <span class="count-badge">{{ count($section['items']) }} items</span>
                        </div>
                        @if(!empty($section['note']))
                            <div class="section-note">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $section['note'] }}
                            </div>
                        @endif
                    </div>

                    {{-- Items --}}
                    @foreach($section['items'] as $item)
                    <div class="item-row">

                        {{-- Label --}}
                        <div>
                            <span class="item-label" title="{{ $item['label'] }}">{{ $item['label'] }}</span>
                        </div>

                        {{-- Code + Note --}}
                        <div>
                            {{-- Code Block --}}
                            <div class="code-block">
                                <div class="code-block-header no-print">
                                    <div class="code-block-dots">
                                        <div class="dot dot-red"></div>
                                        <div class="dot dot-yellow"></div>
                                        <div class="dot dot-green"></div>
                                    </div>
                                    <span class="code-block-lang">{{ $slug }}</span>
                                    <div style="display:flex;gap:8px;">
                                        <button class="wrap-toggle-small no-print" onclick="toggleCodeWrap(this)">No Wrap</button>
                                        <button class="code-copy-btn no-print" onclick="copyItem(this, `{{ addslashes($item['code']) }}`)">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="9" y="9" width="13" height="13" rx="2"/>
                                                <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                                            </svg>
                                            copy
                                        </button>
                                    </div>
                                </div>
                                <div class="code-body">
                                    @php
                                        $lines = explode("\n", $item['code']);
                                    @endphp
                                    <div class="line-numbers">
                                        @foreach($lines as $lineNum => $line)
                                            <span class="line-number">{{ $lineNum + 1 }}</span>
                                        @endforeach
                                    </div>
                                    <pre class="code-content" data-raw-code="{{ base64_encode($item['code']) }}">{{ $item['code'] }}</pre>
                                </div>
                            </div>

                            {{-- Note --}}
                            @if(!empty($item['note']))
                            <div class="item-note">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;">
                                    <path d="M9 18V5l12-2v13"/>
                                    <circle cx="6" cy="18" r="3"/>
                                    <circle cx="18" cy="16" r="3"/>
                                </svg>
                                {{ $item['note'] }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
                @endforeach
            </div>

            {{-- Bottom Nav --}}
            <div class="no-print" style="display:flex;align-items:center;justify-content:space-between;margin-top:40px;padding-top:24px;border-top:1px solid #e8eaf0;">
                <a href="{{ route('cheat-sheets.index') }}"
                    style="display:inline-flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:#64748b;text-decoration:none;transition:color 0.15s;"
                    onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#64748b'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    All Cheat Sheets
                </a>
                <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
                    style="display:inline-flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:#64748b;background:none;border:none;cursor:pointer;transition:color 0.15s;"
                    onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#64748b'">
                    Back to Top
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="19" x2="12" y2="5"/>
                        <polyline points="5 12 12 5 19 12"/>
                    </svg>
                </button>
            </div>

        </main>
    </div>

    {{-- Toast --}}
    <div id="toast">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        Copied to clipboard!
    </div>

    <x-footer-user></x-footer-user>

    <script>
        let toastTimeout;

        function copyItem(btn, code) {
            navigator.clipboard.writeText(code).then(() => {
                btn.classList.add('copied');
                btn.innerHTML = `
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    copied!
                `;
                setTimeout(() => {
                    btn.classList.remove('copied');
                    btn.innerHTML = `
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2"/>
                            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                        </svg>
                        copy
                    `;
                }, 2000);
                showToast();
            }).catch(() => {
                const ta = document.createElement('textarea');
                ta.value = code;
                ta.style.cssText = 'position:fixed;opacity:0;';
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast();
            });
        }

        function showToast() {
            const toast = document.getElementById('toast');
            if (toastTimeout) clearTimeout(toastTimeout);
            toast.classList.add('show');
            toastTimeout = setTimeout(() => toast.classList.remove('show'), 2200);
        }

        function scrollToSection(id) {
            const el = document.getElementById(id);
            if (el) {
                const y = el.getBoundingClientRect().top + window.scrollY - 80;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }
        }

        // Toggle word wrap for individual code block
        function toggleCodeWrap(btn) {
            const codeBlock = btn.closest('.code-block').querySelector('.code-content');
            if (codeBlock.classList.contains('nowrap')) {
                codeBlock.classList.remove('nowrap');
                btn.textContent = 'No Wrap';
            } else {
                codeBlock.classList.add('nowrap');
                btn.textContent = 'Wrap';
            }
        }

        // Toggle all code blocks wrap
        function toggleAllCodeWrap() {
            const codeBlocks = document.querySelectorAll('.code-content');
            const globalBtn = document.querySelector('.wrap-toggle');
            let allWrapped = true;
            
            codeBlocks.forEach(block => {
                if (!block.classList.contains('nowrap')) {
                    allWrapped = false;
                }
            });
            
            codeBlocks.forEach(block => {
                if (allWrapped) {
                    block.classList.remove('nowrap');
                } else {
                    block.classList.add('nowrap');
                }
            });
            
            // Update all individual toggle buttons
            const individualBtns = document.querySelectorAll('.wrap-toggle-small');
            individualBtns.forEach(btn => {
                btn.textContent = allWrapped ? 'No Wrap' : 'Wrap';
            });
            
            globalBtn.textContent = allWrapped ? 'Disable Word Wrap' : 'Enable Word Wrap';
        }
    </script>
</body>
</html>