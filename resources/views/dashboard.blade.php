<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --bg: #0f1419;
            --surface: #1a2332;
            --border: #2d3a4f;
            --text: #e7ecf3;
            --muted: #8b9cb3;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --success: #22c55e;
            --error: #ef4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            line-height: 1.5;
        }

        .wrap {
            max-width: 640px;
            margin: 0 auto;
            padding: 2rem 1.25rem 3rem;
        }

        header { margin-bottom: 2rem; }

        header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        header p {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 0.35rem;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .card h2 {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 0.4rem;
        }

        input[type="url"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg);
            color: var(--text);
            font-size: 1rem;
        }

        input[type="url"]:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .row { display: flex; gap: 0.75rem; margin-top: 1rem; flex-wrap: wrap; }

        button {
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.65rem 1.1rem;
            border-radius: 8px;
            border: none;
            transition: background 0.15s;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-primary:hover { background: var(--accent-hover); }
        .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-secondary {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover { background: var(--border); }

        .result { display: none; margin-top: 1rem; }
        .result.visible { display: block; }

        .short-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .short-link a {
            color: var(--accent);
            font-size: 1.1rem;
            word-break: break-all;
        }

        .short-link a:hover { text-decoration: underline; }

        .meta {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 0.75rem;
            word-break: break-all;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }

        .stat {
            background: var(--bg);
            border-radius: 8px;
            padding: 0.85rem;
            text-align: center;
        }

        .stat .value {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--success);
        }

        .stat .label {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 0.2rem;
        }

        .history { list-style: none; }

        .history li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.85rem;
        }

        .history li:last-child { border-bottom: none; }

        .history a { color: var(--accent); text-decoration: none; }
        .history a:hover { text-decoration: underline; }

        .history button {
            padding: 0.35rem 0.6rem;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .toast {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            font-size: 0.85rem;
            opacity: 0;
            transition: transform 0.25s, opacity 0.25s;
            z-index: 100;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast.error { border-color: var(--error); color: #fca5a5; }

        .empty-history { color: var(--muted); font-size: 0.85rem; }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .user-bar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .logout-form button {
            padding: 0.45rem 0.75rem;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <header class="header-row">
            <div>
                <h1>{{ config('app.name') }}</h1>
                <p>Сократите ссылку и следите за переходами в реальном времени</p>
            </div>
            <div class="user-bar">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-secondary">Выйти</button>
                </form>
            </div>
        </header>

        <section class="card">
            <h2>Новая ссылка</h2>
            <form id="form-create">
                <label for="url">Длинный URL</label>
                <input
                    type="url"
                    id="url"
                    name="url"
                    placeholder="https://example.com/very/long/path"
                    required
                    autocomplete="url"
                >
                <div class="row">
                    <button type="submit" class="btn-primary" id="btn-create">Сократить</button>
                </div>
            </form>

            <div class="result" id="result">
                <label>Короткая ссылка</label>
                <div class="short-link">
                    <a href="#" id="short-link" target="_blank" rel="noopener"></a>
                    <button type="button" class="btn-secondary" id="btn-copy">Копировать</button>
                    <button type="button" class="btn-secondary" id="btn-open">Открыть</button>
                </div>
                <p class="meta" id="original-meta"></p>
            </div>
        </section>

        <section class="card" id="stats-card" style="display: none;">
            <h2>Статистика</h2>
            <div class="stats-grid">
                <div class="stat">
                    <div class="value" id="stat-clicks">0</div>
                    <div class="label">Клики</div>
                </div>
                <div class="stat">
                    <div class="value" id="stat-unique">0</div>
                    <div class="label">Уникальные</div>
                </div>
                <div class="stat">
                    <div class="value" id="stat-last" style="font-size: 0.85rem; color: var(--text);">—</div>
                    <div class="label">Последний переход</div>
                </div>
            </div>
            <div class="row" style="margin-top: 1rem;">
                <button type="button" class="btn-secondary" id="btn-refresh">Обновить статистику</button>
            </div>
        </section>

        <section class="card">
            <h2>История (локально)</h2>
            <ul class="history" id="history"></ul>
            <p class="empty-history" id="history-empty">Пока нет созданных ссылок</p>
        </section>
    </div>

    <div class="toast" id="toast" role="status"></div>

    <script>
        const STORAGE_KEY = 'url_shortener_history_{{ auth()->id() }}';
        const API = '/api/v1';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        let currentId = null;

        const $ = (id) => document.getElementById(id);

        function apiHeaders() {
            return {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
            };
        }

        function showToast(message, isError = false) {
            const toast = $('toast');
            toast.textContent = message;
            toast.classList.toggle('error', isError);
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2800);
        }

        function loadHistory() {
            try {
                return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
            } catch {
                return [];
            }
        }

        function saveHistory(entry) {
            const list = loadHistory().filter((e) => e.id !== entry.id);
            list.unshift(entry);
            localStorage.setItem(STORAGE_KEY, JSON.stringify(list.slice(0, 10)));
            renderHistory();
        }

        function renderHistory() {
            const list = loadHistory();
            const ul = $('history');
            const empty = $('history-empty');
            ul.innerHTML = '';

            if (list.length === 0) {
                empty.style.display = 'block';
                return;
            }

            empty.style.display = 'none';

            list.forEach((item) => {
                const li = document.createElement('li');
                const link = document.createElement('a');
                link.href = item.short_url;
                link.target = '_blank';
                link.rel = 'noopener';
                link.textContent = item.short_url.replace(/^https?:\/\/[^/]+/, '') || item.short_code;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn-secondary';
                btn.textContent = 'Статистика';
                btn.addEventListener('click', () => selectLink(item));
                
                li.append(link, btn);
                ul.appendChild(li);
            });
        }

        function selectLink(item) {
            currentId = item.id;
            $('result').classList.add('visible');
            $('stats-card').style.display = 'block';

            const a = $('short-link');
            a.href = item.short_url;
            a.textContent = item.short_url;
            $('original-meta').textContent = 'Оригинал: ' + item.original_url;

            refreshStats();
        }

        async function refreshStats() {
            if (!currentId) return;

            try {
                const res = await fetch(`${API}/short-urls/${currentId}/stats`, {
                    headers: apiHeaders(),
                    credentials: 'same-origin',
                });
                if (!res.ok) throw new Error('Не удалось загрузить статистику');

                const data = await res.json();
                $('stat-clicks').textContent = data.clicks;
                $('stat-unique').textContent = data.unique_visitors;
                $('stat-last').textContent = data.last_click_at || '—';
            } catch (e) {
                showToast(e.message, true);
            }
        }

        $('form-create').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = $('btn-create');
            const url = $('url').value.trim();

            btn.disabled = true;

            try {
                const res = await fetch(`${API}/short-urls`, {
                    method: 'POST',
                    headers: apiHeaders(),
                    credentials: 'same-origin',
                    body: JSON.stringify({ url }),
                });

                const data = await res.json().catch(() => ({}));

                if (!res.ok) {
                    const msg = data.message || data.errors?.url?.[0] || 'Ошибка создания ссылки';
                    throw new Error(msg);
                }

                currentId = data.id;
                const entry = {
                    id: data.id,
                    short_url: data.short_url,
                    short_code: data.short_url.split('/').pop(),
                    original_url: data.original_url,
                    created_at: new Date().toISOString(),
                };

                saveHistory(entry);
                selectLink(entry);
                $('url').value = '';
                showToast('Ссылка создана');
            } catch (err) {
                showToast(err.message, true);
            } finally {
                btn.disabled = false;
            }
        });

        $('btn-copy').addEventListener('click', async () => {
            const text = $('short-link').href;
            try {
                await navigator.clipboard.writeText(text);
                showToast('Скопировано');
            } catch {
                showToast('Не удалось скопировать', true);
            }
        });

        $('btn-open').addEventListener('click', () => {
            window.open($('short-link').href, '_blank', 'noopener');
        });

        $('btn-refresh').addEventListener('click', refreshStats);

        renderHistory();
    </script>
</body>
</html>
