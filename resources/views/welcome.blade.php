<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Leboncoin') }}</title>

        <style>
            :root {
                --accent: #ff6e14;
                --accent-dark: #d95708;
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
            .secondary-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 42px;
                padding: 0 16px;
                border-radius: 8px;
                font-weight: 700;
                border: 1px solid transparent;
                white-space: nowrap;
            }

            .primary-button {
                background: var(--accent);
                color: #ffffff;
            }

            .primary-button:hover {
                background: var(--accent-dark);
            }

            .secondary-button {
                background: #ffffff;
                color: var(--ink);
                border-color: var(--line);
            }

            .search-form {
                display: grid;
                grid-template-columns: minmax(180px, 1fr) 190px auto;
                flex: 1;
                gap: 8px;
                min-width: 280px;
            }

            .search-form input,
            .search-form select {
                width: 100%;
                min-height: 42px;
                border: 1px solid var(--line);
                border-radius: 8px;
                background: #ffffff;
                color: var(--ink);
                font: inherit;
                padding: 0 12px;
            }

            .account-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 10px;
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

            .categories-bar {
                display: flex;
                gap: 10px;
                padding: 0 0 16px;
                overflow-x: auto;
            }

            .category-pill {
                flex: 0 0 auto;
                padding: 9px 13px;
                border: 1px solid var(--line);
                border-radius: 999px;
                background: #ffffff;
                color: #344054;
                font-size: 14px;
                font-weight: 650;
            }

            .category-pill.is-active {
                border-color: var(--accent);
                color: var(--accent-dark);
            }

            .hero {
                min-height: 310px;
                display: flex;
                align-items: center;
                margin-top: 28px;
                color: #ffffff;
                background:
                    linear-gradient(90deg, rgba(18, 24, 38, 0.82), rgba(18, 24, 38, 0.24)),
                    url("https://picsum.photos/seed/leboncoin-home/1400/520") center / cover;
            }

            .hero-content {
                width: min(1180px, calc(100% - 32px));
                margin: 0 auto;
                padding: 64px 0;
            }

            .hero h1 {
                max-width: 620px;
                margin: 0 0 24px;
                font-size: clamp(38px, 6vw, 72px);
                line-height: 1.02;
                letter-spacing: 0;
            }

            .section-heading {
                display: flex;
                align-items: end;
                justify-content: space-between;
                gap: 16px;
                margin: 40px 0 18px;
            }

            .section-heading h2 {
                margin: 0;
                font-size: 26px;
                letter-spacing: 0;
            }

            .section-heading p {
                margin: 6px 0 0;
                color: var(--muted);
            }

            .annonces-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 18px;
                padding-bottom: 48px;
            }

            .annonce-card {
                overflow: hidden;
                border: 1px solid var(--line);
                border-radius: 8px;
                background: var(--surface);
            }

            .annonce-media {
                position: relative;
                aspect-ratio: 4 / 3;
                background: #edf0f3;
            }

            .annonce-media img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .sold-badge {
                position: absolute;
                top: 10px;
                left: 10px;
                padding: 6px 9px;
                border-radius: 999px;
                background: rgba(23, 32, 51, 0.86);
                color: #ffffff;
                font-size: 12px;
                font-weight: 800;
            }

            .annonce-body {
                padding: 14px;
            }

            .annonce-title {
                min-height: 44px;
                margin: 0 0 8px;
                font-size: 16px;
                line-height: 1.35;
            }

            .annonce-price {
                margin: 0 0 10px;
                color: var(--accent-dark);
                font-size: 18px;
                font-weight: 850;
            }

            .annonce-meta {
                display: flex;
                flex-direction: column;
                gap: 4px;
                color: var(--muted);
                font-size: 13px;
            }

            .empty-state {
                padding: 48px 24px;
                border: 1px dashed #c8ced6;
                border-radius: 8px;
                background: #ffffff;
                color: var(--muted);
                text-align: center;
            }

            @media (min-width: 560px) {
                .annonces-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (min-width: 760px) {
                .annonces-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }

            @media (min-width: 980px) {
                .annonces-grid {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                }
            }

            @media (min-width: 1180px) {
                .annonces-grid {
                    grid-template-columns: repeat(5, minmax(0, 1fr));
                }
            }

            @media (max-width: 900px) {
                .header-row,
                .search-form {
                    grid-template-columns: 1fr;
                }

                .header-row {
                    display: grid;
                    padding: 14px 0;
                }

                .search-form {
                    min-width: 0;
                }

                .account-actions {
                    justify-content: flex-start;
                    flex-wrap: wrap;
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

                    <a class="primary-button" href="#annonces">Annonces</a>

                    <form class="search-form" action="{{ url('/') }}" method="GET">
                        <input
                            type="search"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Rechercher une annonce ou une categorie"
                            aria-label="Rechercher une annonce ou une categorie"
                        >

                        <select name="category_id" aria-label="Categorie">
                            <option value="">Toutes categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <button class="secondary-button" type="submit">Rechercher</button>
                    </form>

                    <div class="account-actions">
                        @auth
                            <a class="avatar" href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}" aria-label="Mon compte">
                                {{ strtoupper(mb_substr(auth()->user()->name ?? auth()->user()->email, 0, 1)) }}
                            </a>
                        @else
                            @if (Route::has('login'))
                                <a class="secondary-button" href="{{ route('login') }}">Connexion</a>
                            @endif

                            @if (Route::has('register'))
                                <a class="primary-button" href="{{ route('register') }}">Inscription</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <nav class="categories-bar" aria-label="Categories">
                    <a class="category-pill {{ blank($categoryId) ? 'is-active' : '' }}" href="{{ url('/') }}">Toutes</a>
                    @foreach ($categories as $category)
                        <a
                            class="category-pill {{ (string) $categoryId === (string) $category->id ? 'is-active' : '' }}"
                            href="{{ url('/?category_id='.$category->id) }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main>
            <section class="hero" aria-labelledby="hero-title">
                <div class="hero-content">
                    <h1 id="hero-title">C’est le moment de vendre</h1>
                    <a class="primary-button" href="{{ Route::has('annonces.create') ? route('annonces.create') : '#' }}">
                        Creer une annonce
                    </a>
                </div>
            </section>

            <section id="annonces" class="container" aria-labelledby="annonces-title">
                <div class="section-heading">
                    <div>
                        <h2 id="annonces-title">Dernieres annonces</h2>
                        <p>{{ $annonces->count() }} annonce{{ $annonces->count() > 1 ? 's' : '' }} recente{{ $annonces->count() > 1 ? 's' : '' }}</p>
                    </div>
                </div>

                @if ($annonces->isNotEmpty())
                    <div class="annonces-grid">
                        @foreach ($annonces as $annonce)
                            <article class="annonce-card">
                                <a href="{{ route('annonces.show', $annonce) }}">
                                    <div class="annonce-media">
                                        @if ($annonce->images->isNotEmpty())
                                            <img src="{{ $annonce->images->first()->url }}" alt="{{ $annonce->name }}" loading="lazy">
                                        @endif

                                        @if ($annonce->status)
                                            <span class="sold-badge">Vendu</span>
                                        @endif
                                    </div>

                                    <div class="annonce-body">
                                        <h3 class="annonce-title">{{ $annonce->name }}</h3>
                                        <p class="annonce-price">{{ number_format((float) $annonce->price, 2, ',', ' ') }} €</p>
                                        <div class="annonce-meta">
                                            <span>{{ $annonce->category?->name ?? 'Sans categorie' }}</span>
                                            <span>{{ $annonce->seller?->name ?? 'Vendeur' }}</span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        Aucune annonce disponible pour le moment.
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
