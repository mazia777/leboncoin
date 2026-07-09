<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Connexion - {{ config('app.name', 'Leboncoin') }}</title>

        <style>
            :root {
                --accent: #ff6e14;
                --accent-dark: #d95708;
                --ink: #1f2933;
                --muted: #667085;
                --line: #e6e8ec;
                --page: #f6f7f9;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: var(--page);
                color: var(--ink);
                font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            .auth-header {
                border-bottom: 1px solid var(--line);
                background: #ffffff;
            }

            .container {
                width: min(1080px, calc(100% - 32px));
                margin: 0 auto;
            }

            .header-row {
                display: flex;
                min-height: 76px;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }

            .logo {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-weight: 850;
            }

            .logo-mark {
                display: grid;
                width: 34px;
                height: 34px;
                place-items: center;
                border-radius: 8px;
                background: var(--accent);
                color: #ffffff;
                font-weight: 900;
            }

            .header-link {
                color: var(--accent-dark);
                font-weight: 750;
            }

            .auth-shell {
                display: grid;
                grid-template-columns: minmax(0, 1fr) 420px;
                gap: 38px;
                align-items: center;
                min-height: calc(100vh - 76px);
                padding: 48px 0;
            }

            .auth-hero {
                min-height: 520px;
                display: flex;
                align-items: end;
                border-radius: 8px;
                overflow: hidden;
                color: #ffffff;
                background:
                    linear-gradient(180deg, rgba(18, 24, 38, 0.12), rgba(18, 24, 38, 0.82)),
                    url("https://picsum.photos/seed/leboncoin-login/900/700") center / cover;
            }

            .auth-hero-content {
                padding: 34px;
            }

            .auth-hero h1 {
                max-width: 520px;
                margin: 0 0 12px;
                font-size: clamp(34px, 5vw, 58px);
                line-height: 1.04;
                letter-spacing: 0;
            }

            .auth-hero p {
                max-width: 460px;
                margin: 0;
                color: rgba(255, 255, 255, 0.86);
                font-size: 17px;
                line-height: 1.55;
            }

            .auth-card {
                border: 1px solid var(--line);
                border-radius: 8px;
                background: #ffffff;
                padding: 28px;
            }

            .auth-card h2 {
                margin: 0 0 8px;
                font-size: 30px;
                letter-spacing: 0;
            }

            .auth-card-subtitle {
                margin: 0 0 24px;
                color: var(--muted);
                line-height: 1.5;
            }

            .status {
                margin-bottom: 18px;
                color: #067647;
                font-weight: 700;
            }

            .field {
                display: grid;
                gap: 7px;
                margin-bottom: 16px;
            }

            .field label {
                font-size: 14px;
                font-weight: 750;
            }

            .field input {
                width: 100%;
                min-height: 46px;
                border: 1px solid var(--line);
                border-radius: 8px;
                background: #ffffff;
                color: var(--ink);
                font: inherit;
                padding: 0 12px;
            }

            .field-error {
                color: #b42318;
                font-size: 13px;
            }

            .form-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
                margin: 6px 0 22px;
                color: var(--muted);
                font-size: 14px;
            }

            .remember {
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .forgot-link {
                color: var(--accent-dark);
                font-weight: 700;
            }

            .primary-button,
            .secondary-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                min-height: 48px;
                border-radius: 8px;
                font: inherit;
                font-weight: 800;
            }

            .primary-button {
                border: 0;
                background: var(--accent);
                color: #ffffff;
                cursor: pointer;
            }

            .primary-button:hover {
                background: var(--accent-dark);
            }

            .secondary-button {
                margin-top: 12px;
                border: 1px solid var(--line);
                background: #ffffff;
            }

            @media (max-width: 900px) {
                .auth-shell {
                    grid-template-columns: 1fr;
                }

                .auth-hero {
                    min-height: 320px;
                }
            }

            @media (max-width: 560px) {
                .header-row,
                .form-row {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }
        </style>
    </head>
    <body>
        <header class="auth-header">
            <div class="container header-row">
                <a class="logo" href="{{ url('/') }}" aria-label="Accueil">
                    <span class="logo-mark">L</span>
                    <span>leboncoin</span>
                </a>

                <a class="header-link" href="{{ route('register') }}">Creer un compte</a>
            </div>
        </header>

        <main class="container auth-shell">
            <section class="auth-hero" aria-label="Connexion">
                <div class="auth-hero-content">
                    <h1>Connectez-vous pour vendre et acheter plus vite</h1>
                    <p>Retrouvez vos annonces, contactez les vendeurs et publiez vos articles depuis votre espace.</p>
                </div>
            </section>

            <section class="auth-card" aria-labelledby="login-title">
                <h2 id="login-title">Connexion</h2>
                <p class="auth-card-subtitle">Accedez a votre compte pour continuer.</p>

                @if (session('status'))
                    <div class="status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @foreach ($errors->get('email') as $message)
                            <span class="field-error">{{ $message }}</span>
                        @endforeach
                    </div>

                    <div class="field">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                        @foreach ($errors->get('password') as $message)
                            <span class="field-error">{{ $message }}</span>
                        @endforeach
                    </div>

                    <div class="form-row">
                        <label class="remember" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Se souvenir de moi</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">Mot de passe oublie ?</a>
                        @endif
                    </div>

                    <button class="primary-button" type="submit">Se connecter</button>
                    <a class="secondary-button" href="{{ route('register') }}">Creer un compte</a>
                </form>
            </section>
        </main>
    </body>
</html>
