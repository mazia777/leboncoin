<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $annonce->name }} - {{ config('app.name', 'Leboncoin') }}</title>

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

            .avatar,
            .seller-avatar {
                display: grid;
                place-items: center;
                border-radius: 50%;
                background: #172033;
                color: #ffffff;
                font-weight: 800;
            }

            .avatar {
                width: 42px;
                height: 42px;
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

            .breadcrumb {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin: 28px 0 20px;
                color: var(--muted);
                font-size: 14px;
            }

            .breadcrumb a {
                color: #475467;
                font-weight: 650;
            }

            .detail-layout {
                display: grid;
                grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
                gap: 28px;
                align-items: start;
                padding-bottom: 56px;
            }

            .detail-main,
            .seller-panel {
                border: 1px solid var(--line);
                border-radius: 8px;
                background: var(--surface);
            }

            .image-gallery {
                padding: 14px;
            }

            .main-image {
                overflow: hidden;
                aspect-ratio: 16 / 10;
                border-radius: 8px;
                background: #edf0f3;
            }

            .main-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-thumbs {
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 10px;
                margin-top: 10px;
            }

            .image-thumb {
                overflow: hidden;
                aspect-ratio: 1 / 1;
                border-radius: 8px;
                background: #edf0f3;
            }

            .image-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .detail-content {
                padding: 22px;
                border-top: 1px solid var(--line);
            }

            .detail-title {
                margin: 0 0 10px;
                font-size: clamp(28px, 4vw, 42px);
                line-height: 1.08;
                letter-spacing: 0;
            }

            .detail-date {
                margin: 0 0 18px;
                color: var(--muted);
                font-size: 14px;
            }

            .detail-price {
                margin: 0 0 26px;
                color: var(--accent-dark);
                font-size: 30px;
                font-weight: 850;
            }

            .description-title {
                margin: 0 0 10px;
                font-size: 20px;
            }

            .description-text {
                margin: 0;
                color: #344054;
                line-height: 1.7;
                white-space: pre-line;
            }

            .seller-panel {
                position: sticky;
                top: 104px;
                padding: 22px;
            }

            .seller-heading {
                display: flex;
                align-items: center;
                gap: 14px;
                margin-bottom: 22px;
            }

            .seller-avatar {
                width: 58px;
                height: 58px;
                font-size: 22px;
            }

            .seller-name {
                margin: 0 0 4px;
                font-size: 18px;
                font-weight: 800;
            }

            .seller-meta {
                margin: 0;
                color: var(--muted);
                font-size: 14px;
            }

            .buy-button {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                min-height: 48px;
                border: 0;
                border-radius: 8px;
                background: var(--accent);
                color: #ffffff;
                cursor: pointer;
                font: inherit;
                font-weight: 800;
            }

            .buy-button:hover {
                background: var(--accent-dark);
            }

            .buy-button:disabled {
                background: #c8ced6;
                cursor: not-allowed;
            }

            .seller-note {
                margin: 16px 0 0;
                color: var(--muted);
                font-size: 13px;
                line-height: 1.5;
            }

            .buy-form {
                margin: 0;
            }

            .notice {
                margin: 0 0 16px;
                padding: 12px 14px;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 750;
                line-height: 1.45;
            }

            .notice.success {
                background: #ecfdf3;
                color: #067647;
            }

            .notice.error {
                background: #fff5f4;
                color: #b42318;
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

                .detail-layout {
                    grid-template-columns: 1fr;
                }

                .seller-panel {
                    position: static;
                }
            }

            @media (max-width: 560px) {
                .image-thumbs {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
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

                    <a class="primary-button" href="{{ url('/#annonces') }}">Annonces</a>

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
                    <a class="category-pill" href="{{ url('/') }}">Toutes</a>
                    @foreach ($categories as $category)
                        <a
                            class="category-pill {{ $annonce->category_id === $category->id ? 'is-active' : '' }}"
                            href="{{ url('/?category_id='.$category->id) }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main class="container">
            <nav class="breadcrumb" aria-label="Fil d'ariane">
                <a href="{{ url('/') }}">Accueil</a>
                <span>/</span>
                @if ($annonce->category)
                    <a href="{{ url('/?category_id='.$annonce->category->id) }}">{{ $annonce->category->name }}</a>
                    <span>/</span>
                @endif
                <span>{{ $annonce->name }}</span>
            </nav>

            <div class="detail-layout">
                <article class="detail-main">
                    <div class="image-gallery">
                        <div class="main-image">
                            @if ($annonce->images->isNotEmpty())
                                <img src="{{ $annonce->images->first()->url }}" alt="{{ $annonce->name }}">
                            @endif
                        </div>

                        @if ($annonce->images->count() > 1)
                            <div class="image-thumbs" aria-label="Images de l'annonce">
                                @foreach ($annonce->images->skip(1)->take(5) as $image)
                                    <div class="image-thumb">
                                        <img src="{{ $image->url }}" alt="{{ $annonce->name }}" loading="lazy">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="detail-content">
                        <h1 class="detail-title">{{ $annonce->name }}</h1>
                        <p class="detail-date">Publiee le {{ $annonce->created_at?->format('d/m/Y') }}</p>
                        <p class="detail-price">{{ number_format((float) $annonce->price, 2, ',', ' ') }} €</p>

                        <h2 class="description-title">Description</h2>
                        <p class="description-text">{{ $annonce->description }}</p>
                    </div>
                </article>

                <aside class="seller-panel" aria-label="Informations vendeur">
                    @if (session('success'))
                        <p class="notice success">{{ session('success') }}</p>
                    @endif

                    @if (session('error'))
                        <p class="notice error">{{ session('error') }}</p>
                    @endif

                    <div class="seller-heading">
                        <div class="seller-avatar">
                            {{ strtoupper(mb_substr($annonce->seller?->name ?? 'V', 0, 1)) }}
                        </div>

                        <div>
                            <p class="seller-name">{{ $annonce->seller?->name ?? 'Vendeur' }}</p>
                            <p class="seller-meta">Vendeur particulier</p>
                        </div>
                    </div>

                    @auth
                        @if (auth()->id() === $annonce->seller_id)
                            <button class="buy-button" type="button" disabled>Votre annonce</button>
                        @elseif ($annonce->status)
                            <button class="buy-button" type="button" disabled>Article vendu</button>
                        @else
                            <form class="buy-form" action="{{ route('annonces.buy', $annonce) }}" method="POST">
                                @csrf
                                <button class="buy-button" type="submit">Acheter</button>
                            </form>
                        @endif
                    @else
                        <a class="buy-button" href="{{ route('login') }}">
                            Se connecter pour acheter
                        </a>
                    @endauth

                    <p class="seller-note">
                        Paiement a finaliser uniquement apres verification de l'annonce et du vendeur.
                    </p>
                </aside>
            </div>
        </main>
    </body>
</html>
