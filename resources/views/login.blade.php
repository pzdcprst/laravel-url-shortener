<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход — {{ config('app.name') }}</title>
    <style>
        :root {
            --bg: #0f1419;
            --surface: #1a2332;
            --border: #2d3a4f;
            --text: #e7ecf3;
            --muted: #8b9cb3;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --error: #ef4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .card {
            width: 100%;
            max-width: 400px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
        }

        h1 {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }

        .subtitle {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 0.4rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg);
            color: var(--text);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .error {
            color: #fca5a5;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        button {
            width: 100%;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: none;
            background: var(--accent);
            color: #fff;
        }

        button:hover { background: var(--accent-hover); }

        .demo {
            margin-top: 1.25rem;
            padding: 0.85rem;
            background: var(--bg);
            border-radius: 8px;
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.6;
        }

        .demo strong { color: var(--text); }
    </style>
</head>
<body>
    <div class="card">
        <h1>{{ config('app.name') }}</h1>
        <p class="subtitle">Войдите, чтобы управлять своими ссылками</p>

        @if ($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
            >

            <label for="password">Пароль</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Войти</button>
        </form>

        <div class="demo">
            <strong>Тестовые пользователи</strong><br>
            alice@example.com / password<br>
            bob@example.com / password
        </div>
    </div>
</body>
</html>
