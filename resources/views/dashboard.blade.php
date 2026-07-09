<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tableau de bord - {{ config('app.name', 'Leboncoin') }}</title>

        <style>
            :root {
                --accent: #ff6e14;
                --accent-dark: #d95708;
                --danger: #b42318;
                --ink: #1f2933;
                --muted: #667085;
                --line: #e6e8ec;
                --surface: #ffffff;
                --page: #f6f7f9;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                background: var(--page);
                color: var(--ink);
                font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            img {
                display: block;
                max-width: 100%;
            }

            .page-header {
                position: sticky;
                top: 0;
                z-index: 10;
                background: rgba(255, 255, 255, 0.96);
                border-bottom: 1px solid var(--line);
            }

            .container {
                width: min(1180px, calc(100% - 32px));
                margin: 0 auto;
            }

            .header-row {
                display: flex;
                align-items: center;
                gap: 16px;
                min-height: 76px;
            }

            .logo {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-weight: 800;
                white-space: nowrap;
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

            .primary-button,
            .secondary-button,
            .danger-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 42px;
                padding: 0 16px;
                border-radius: 8px;
                font: inherit;
                font-weight: 750;
                white-space: nowrap;
            }

            .primary-button {
                border: 0;
                background: var(--accent);
                color: #ffffff;
            }

            .primary-button:hover {
                background: var(--accent-dark);
            }

            .secondary-button {
                border: 1px solid var(--line);
                background: #ffffff;
                color: var(--ink);
            }

            .danger-button {
                border: 1px solid #fecdca;
                background: #fff5f4;
                color: var(--danger);
                cursor: pointer;
            }

            .header-spacer {
                flex: 1;
            }

            .avatar {
                display: grid;
                width: 42px;
                height: 42px;
                place-items: center;
                border-radius: 50%;
                background: #172033;
                color: #ffffff;
                font-weight: 800;
            }

            .dashboard-title {
                margin: 34px 0 22px;
            }

            .dashboard-title h1 {
                margin: 0 0 8px;
                font-size: clamp(30px, 4vw, 46px);
                line-height: 1.08;
                letter-spacing: 0;
            }

            .dashboard-title p {
                margin: 0;
                color: var(--muted);
            }

            .summary-layout {
                display: grid;
                grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
                gap: 28px;
                align-items: stretch;
                margin-bottom: 30px;
            }

            .profile-panel,
            .wallet-panel,
            .list-panel {
                border: 1px solid var(--line);
                border-radius: 8px;
                background: var(--surface);
            }

            .profile-panel,
            .wallet-panel {
                padding: 24px;
            }

            .profile-panel {
                display: flex;
                align-items: center;
                gap: 18px;
            }

            .profile-avatar {
                display: grid;
                width: 84px;
                height: 84px;
                place-items: center;
                border-radius: 50%;
                background: #172033;
                color: #ffffff;
                font-size: 34px;
                font-weight: 850;
            }

            .profile-name {
                margin: 0 0 6px;
                font-size: 28px;
                line-height: 1.12;
            }

            .profile-email {
                margin: 0;
                color: var(--muted);
            }

            .wallet-label {
                margin: 0 0 10px;
                color: var(--muted);
                font-weight: 750;
            }

            .wallet-total {
                margin: 0 0 12px;
                color: var(--accent-dark);
                font-size: 34px;
                font-weight: 900;
            }

            .wallet-meta {
                margin: 0;
                color: var(--muted);
            }

            .list-panel {
                overflow: hidden;
                margin-bottom: 56px;
            }

            .list-header {
                display: flex;
                align-items: end;
                justify-content: space-between;
                gap: 16px;
                padding: 22px 24px;
                border-bottom: 1px solid var(--line);
            }

            .list-header h2 {
                margin: 0 0 6px;
                font-size: 24px;
                letter-spacing: 0;
            }

            .list-header p {
                margin: 0;
                color: var(--muted);
            }

            .annonce-list {
                display: grid;
            }

            .annonce-row {
                display: grid;
                grid-template-columns: 132px minmax(0, 1fr) auto;
                gap: 18px;
                align-items: center;
                padding: 18px 24px;
                border-bottom: 1px solid var(--line);
            }

            .annonce-row:last-child {
                border-bottom: 0;
            }

            .annonce-media {
                overflow: hidden;
                aspect-ratio: 4 / 3;
                border-radius: 8px;
                background: #edf0f3;
            }

            .annonce-media img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .annonce-title {
                margin: 0 0 7px;
                font-size: 18px;
                line-height: 1.32;
            }

            .annonce-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 8px 14px;
                color: var(--muted);
                font-size: 14px;
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                min-height: 28px;
                padding: 0 10px;
                border-radius: 999px;
                font-size: 13px;
                font-weight: 800;
            }

            .status-badge.available {
                background: #ecfdf3;
                color: #067647;
            }

            .status-badge.sold {
                background: #fff0e7;
                color: var(--accent-dark);
            }

            .annonce-actions {
                display: flex;
                gap: 8px;
                align-items: center;
                justify-content: flex-end;
            }

            .delete-form {
                margin: 0;
            }

            .empty-state {
                padding: 48px 24px;
                color: var(--muted);
                text-align: center;
            }

            @media (max-width: 900px) {
                .header-row {
                    flex-wrap: wrap;
                    padding: 14px 0;
                }

                .summary-layout,
                .annonce-row {
                    grid-template-columns: 1fr;
                }

                .annonce-actions {
                    justify-content: flex-start;
                }
            }

            @media (max-width: 560px) {
                .profile-panel {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .list-header {
                    align-items: flex-start;
                    flex-direction: column;
                }
            }
        </style>
    </head>
    <body>
        <header class="page-header">
            <div class="container">
                <div class="header-row">
                    <a class="logo" href="{{ url('/') }}" aria-label="Accueil">
                        <span class="logo-mark">L</span>
                        <span>leboncoin</span>
                    </a>

                    <a class="primary-button" href="{{ route('annonces.create') }}">Deposer une annonce</a>
                    <a class="secondary-button" href="{{ url('/#annonces') }}">Annonces</a>

                    <span class="header-spacer"></span>

                    <a class="avatar" href="{{ route('profile.edit') }}" aria-label="Mon profil">
                        {{ strtoupper(mb_substr($user->name ?? $user->email, 0, 1)) }}
                    </a>
                </div>
            </div>
        </header>

        <main class="container">
            <div class="dashboard-title">
                <h1>Mon tableau de bord</h1>
                <p>Suivez vos annonces, vos ventes et les actions a effectuer.</p>
            </div>

            <section class="summary-layout" aria-label="Resume utilisateur">
                <div class="profile-panel">
                    <div class="profile-avatar">
                        {{ strtoupper(mb_substr($user->name ?? $user->email, 0, 1)) }}
                    </div>

                    <div>
                        <h2 class="profile-name">{{ $user->name }}</h2>
                        <p class="profile-email">{{ $user->email }}</p>
                    </div>
                </div>

                <aside class="wallet-panel" aria-label="Porte monnaie">
                    <p class="wallet-label">Porte monnaie</p>
                    <p class="wallet-total">{{ number_format($totalSales, 2, ',', ' ') }} €</p>
                    <p class="wallet-meta">{{ $soldCount }} vente{{ $soldCount > 1 ? 's' : '' }} finalisee{{ $soldCount > 1 ? 's' : '' }}</p>
                </aside>
            </section>

            <section class="list-panel" aria-labelledby="annonces-title">
                <div class="list-header">
                    <div>
                        <h2 id="annonces-title">Mes annonces</h2>
                        <p>Annonces actuelles en premier, annonces vendues en dessous, triees par date.</p>
                    </div>

                    <a class="primary-button" href="{{ route('annonces.create') }}">Nouvelle annonce</a>
                </div>

                @if ($annonces->isNotEmpty())
                    <div class="annonce-list">
                        @foreach ($annonces as $annonce)
                            <article class="annonce-row">
                                <a class="annonce-media" href="{{ route('annonces.show', $annonce) }}">
                                    @if ($annonce->images->isNotEmpty())
                                        <img src="{{ $annonce->images->first()->url }}" alt="{{ $annonce->name }}" loading="lazy">
                                    @endif
                                </a>

                                <div>
                                    <h3 class="annonce-title">
                                        <a href="{{ route('annonces.show', $annonce) }}">{{ $annonce->name }}</a>
                                    </h3>

                                    <div class="annonce-meta">
                                        <span>{{ $annonce->created_at?->format('d/m/Y') }}</span>
                                        <span>{{ number_format((float) $annonce->price, 2, ',', ' ') }} €</span>
                                        <span>{{ $annonce->category?->name ?? 'Sans categorie' }}</span>
                                        <span class="status-badge {{ $annonce->status ? 'sold' : 'available' }}">
                                            {{ $annonce->status ? 'Vendue' : 'Actuelle' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="annonce-actions">
                                    <a class="secondary-button" href="{{ route('annonces.edit', $annonce) }}">Modifier</a>

                                    <form class="delete-form" action="{{ route('annonces.destroy', $annonce) }}" method="POST" onsubmit="return confirm('Supprimer definitivement cette annonce ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="danger-button" type="submit">Supprimer</button>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        Vous n'avez pas encore depose d'annonce.
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
