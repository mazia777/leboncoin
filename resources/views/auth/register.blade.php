<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Inscription - {{ config('app.name', 'Leboncoin') }}</title>

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
                min-height: 560px;
                display: flex;
                align-items: end;
                border-radius: 8px;
                overflow: hidden;
                color: #ffffff;
                background:
                    linear-gradient(180deg, rgba(18, 24, 38, 0.10), rgba(18, 24, 38, 0.84)),
                    url("https://picsum.photos/seed/leboncoin-register/900/760") center / cover;
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

            .terms-note {
                margin: 16px 0 0;
                color: var(--muted);
                font-size: 13px;
                line-height: 1.5;
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
                .header-row {
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

                <a class="header-link" href="{{ route('login') }}">Deja un compte ?</a>
            </div>
        </header>

        <main class="container auth-shell">
            <section class="auth-hero" aria-label="Inscription">
                <div class="auth-hero-content">
                    <h1>Un compte pour vendre, acheter et suivre vos annonces</h1>
                    <p>Publiez vos articles, gardez vos favoris et contactez les vendeurs depuis un espace clair.</p>
                </div>
            </section>

            <section class="auth-card" aria-labelledby="register-title">
                <h2 id="register-title">Inscription</h2>
                <p class="auth-card-subtitle">Creez votre compte en moins d'une minute.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="field">
                        <label for="name">Nom</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                        @foreach ($errors->get('name') as $message)
                            <span class="field-error">{{ $message }}</span>
                        @endforeach
                    </div>

                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                        @foreach ($errors->get('email') as $message)
                            <span class="field-error">{{ $message }}</span>
                        @endforeach
                    </div>

                    <div class="field">
                        <label for="password">Mot de passe</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password">
                        @foreach ($errors->get('password') as $message)
                            <span class="field-error">{{ $message }}</span>
                        @endforeach
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                        @foreach ($errors->get('password_confirmation') as $message)
                            <span class="field-error">{{ $message }}</span>
                        @endforeach
                    </div>

                    <button class="primary-button" type="submit">Creer mon compte</button>
                    <a class="secondary-button" href="{{ route('login') }}">Se connecter</a>
                </form>

                <p class="terms-note">
                    En creant un compte, vous pourrez deposer une annonce et gerer vos publications depuis votre espace.
                </p>
            </section>
        </main>
    </body>
</html>
