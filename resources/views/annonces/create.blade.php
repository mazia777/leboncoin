@php
    $isEditing = isset($annonce) && $annonce !== null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $isEditing ? 'Modifier une annonce' : 'Deposer une annonce' }} - {{ config('app.name', 'Leboncoin') }}</title>

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

            .page-header {
                background: #ffffff;
                border-bottom: 1px solid var(--line);
            }

            .container {
                width: min(1180px, calc(100% - 32px));
                margin: 0 auto;
            }

            .header-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 18px;
                min-height: 76px;
            }

            .brand-area {
                display: inline-flex;
                align-items: center;
                gap: 14px;
                min-width: 0;
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

            .header-title {
                color: #344054;
                font-size: 16px;
                font-weight: 750;
                white-space: nowrap;
            }

            .secondary-button,
            .primary-button {
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

            .secondary-button {
                border: 1px solid var(--line);
                background: #ffffff;
                color: var(--ink);
            }

            .primary-button {
                width: 100%;
                border: 0;
                background: var(--accent);
                color: #ffffff;
                cursor: pointer;
            }

            .primary-button:hover {
                background: var(--accent-dark);
            }

            .page-title {
                margin: 34px 0 22px;
            }

            .page-title h1 {
                margin: 0 0 8px;
                font-size: clamp(30px, 4vw, 46px);
                line-height: 1.08;
                letter-spacing: 0;
            }

            .page-title p {
                margin: 0;
                color: var(--muted);
            }

            .create-layout {
                display: grid;
                grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
                gap: 28px;
                align-items: start;
                padding-bottom: 56px;
            }

            .media-panel,
            .form-panel {
                border: 1px solid var(--line);
                border-radius: 8px;
                background: var(--surface);
            }

            .panel-body {
                padding: 22px;
            }

            .panel-title {
                margin: 0 0 16px;
                font-size: 22px;
                letter-spacing: 0;
            }

            .drop-zone {
                display: grid;
                min-height: 380px;
                place-items: center;
                border: 2px dashed #c8ced6;
                border-radius: 8px;
                background: #fbfcfd;
                cursor: pointer;
                text-align: center;
                transition: border-color 150ms ease, background 150ms ease;
            }

            .drop-zone:hover {
                border-color: var(--accent);
                background: #fff7f2;
            }

            .drop-zone.is-dragging {
                border-color: var(--accent);
                background: #fff7f2;
            }

            .drop-zone input {
                position: absolute;
                width: 1px;
                height: 1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
            }

            .drop-content {
                max-width: 360px;
                padding: 28px;
            }

            .drop-icon {
                display: grid;
                width: 58px;
                height: 58px;
                place-items: center;
                margin: 0 auto 16px;
                border-radius: 50%;
                background: #fff0e7;
                color: var(--accent-dark);
                font-size: 28px;
                font-weight: 900;
            }

            .drop-title {
                margin: 0 0 8px;
                font-size: 20px;
                font-weight: 850;
            }

            .drop-help {
                margin: 0;
                color: var(--muted);
                line-height: 1.5;
            }

            .image-rules {
                display: grid;
                gap: 8px;
                margin: 18px 0 0;
                padding: 0;
                color: var(--muted);
                font-size: 14px;
                list-style: none;
            }

            .image-preview-grid {
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 10px;
                margin-top: 18px;
            }

            .image-preview {
                overflow: hidden;
                aspect-ratio: 1 / 1;
                border: 1px solid var(--line);
                border-radius: 8px;
                background: #edf0f3;
            }

            .image-preview img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .current-images {
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 18px;
            }

            .image-feedback {
                display: none;
                margin: 12px 0 0;
                color: var(--accent-dark);
                font-size: 14px;
                font-weight: 750;
            }

            .form-grid {
                display: grid;
                gap: 16px;
            }

            .field {
                display: grid;
                gap: 7px;
            }

            .field label {
                font-size: 14px;
                font-weight: 750;
            }

            .field input,
            .field select,
            .field textarea {
                width: 100%;
                border: 1px solid var(--line);
                border-radius: 8px;
                background: #ffffff;
                color: var(--ink);
                font: inherit;
                padding: 12px;
            }

            .field input,
            .field select {
                min-height: 44px;
            }

            .field textarea {
                min-height: 150px;
                resize: vertical;
            }

            .field-help {
                color: var(--muted);
                font-size: 13px;
            }

            .checkbox-field {
                display: flex;
                align-items: center;
                gap: 10px;
                color: #344054;
                font-weight: 750;
            }

            .checkbox-field input {
                width: 18px;
                height: 18px;
            }

            .field-error {
                color: #b42318;
                font-size: 13px;
                font-weight: 700;
            }

            .form-note {
                margin: 14px 0 0;
                color: var(--muted);
                font-size: 13px;
                line-height: 1.5;
            }

            @media (max-width: 900px) {
                .create-layout {
                    grid-template-columns: 1fr;
                }

                .header-row {
                    align-items: flex-start;
                    flex-direction: column;
                    padding: 16px 0;
                }
            }

            @media (max-width: 560px) {
                .brand-area {
                    align-items: flex-start;
                    flex-direction: column;
                    gap: 8px;
                }

                .drop-zone {
                    min-height: 280px;
                }

                .image-preview-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .current-images {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }
        </style>
    </head>
    <body>
        <header class="page-header">
            <div class="container">
                <div class="header-row">
                    <div class="brand-area">
                        <a class="logo" href="{{ url('/') }}" aria-label="Accueil">
                            <span class="logo-mark">L</span>
                            <span>leboncoin</span>
                        </a>

                        <span class="header-title">{{ $isEditing ? 'Modifier une annonce' : 'Deposer une annonce' }}</span>
                    </div>

                    <a class="secondary-button" href="{{ $isEditing ? route('dashboard') : url('/') }}">Quitter</a>
                </div>
            </div>
        </header>

        <main class="container">
            <div class="page-title">
                <h1>{{ $isEditing ? 'Modifier une annonce' : 'Deposer une annonce' }}</h1>
                <p>{{ $isEditing ? 'Mettez a jour les informations de votre annonce.' : 'Ajoutez vos photos puis renseignez les informations essentielles de votre article.' }}</p>
            </div>

            <form class="create-layout" action="{{ $isEditing ? route('annonces.update', $annonce) : route('annonces.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($isEditing)
                    @method('PATCH')
                @endif

                <section class="media-panel" aria-labelledby="images-title">
                    <div class="panel-body">
                        <h2 id="images-title" class="panel-title">Photos de l'annonce</h2>

                        @if ($isEditing && $annonce->images->isNotEmpty())
                            <div class="current-images" aria-label="Images actuelles">
                                @foreach ($annonce->images->take(5) as $image)
                                    <div class="image-preview">
                                        <img src="{{ $image->url }}" alt="{{ $annonce->name }}" loading="lazy">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <label class="drop-zone" for="images" id="image-drop-zone">
                            <input id="images" type="file" name="images[]" accept="image/*" multiple>
                            <span class="drop-content">
                                <span class="drop-icon">+</span>
                                <span class="drop-title">Deposez vos images ici</span>
                                <span class="drop-help">Glissez-deposez vos fichiers ou cliquez pour selectionner jusqu'a 5 images.</span>
                            </span>
                        </label>

                        <div id="image-preview-grid" class="image-preview-grid" aria-live="polite"></div>
                        <p id="image-feedback" class="image-feedback"></p>
                        @error('images')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="field-error">{{ $message }}</p>
                        @enderror

                        <ul class="image-rules">
                            <li>Formats recommandes : JPG, PNG ou WebP.</li>
                            <li>La premiere image sera utilisee comme image principale.</li>
                            <li>Les images sont optimisees automatiquement avant l'envoi.</li>
                            <li>Evitez les captures floues ou trop sombres.</li>
                        </ul>
                    </div>
                </section>

                <aside class="form-panel" aria-labelledby="details-title">
                    <div class="panel-body">
                        <h2 id="details-title" class="panel-title">Informations</h2>

                        <div class="form-grid">
                            <div class="field">
                                <label for="name">Titre de l'annonce</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $annonce?->name) }}" maxlength="255" required placeholder="Ex : Canape 3 places en tres bon etat">
                                @error('name')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="category_id">Categorie</label>
                                <select id="category_id" name="category_id" required>
                                    <option value="">Choisir une categorie</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected((string) old('category_id', $annonce?->category_id) === (string) $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="price">Prix</label>
                                <input id="price" name="price" type="number" value="{{ old('price', $annonce?->price) }}" min="0" step="0.01" required placeholder="0,00">
                                @error('price')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" required placeholder="Decrivez l'etat, les dimensions, les accessoires inclus et les conditions de remise.">{{ old('description', $annonce?->description) }}</textarea>
                                <span class="field-help">Une description precise aide l'acheteur a se decider plus vite.</span>
                                @error('description')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($isEditing)
                                <label class="checkbox-field" for="status">
                                    <input id="status" type="checkbox" name="status" value="1" @checked(old('status', $annonce->status))>
                                    <span>Marquer l'article comme vendu</span>
                                </label>
                            @endif

                            <button class="primary-button" type="submit">{{ $isEditing ? 'Enregistrer les modifications' : "Publier l'annonce" }}</button>
                        </div>

                        <p class="form-note">
                            {{ $isEditing ? 'Les modifications seront visibles immediatement apres validation.' : "L'annonce sera publiee sur votre compte apres validation des informations." }}
                        </p>
                    </div>
                </aside>
            </form>
        </main>

        <script>
            const dropZone = document.getElementById('image-drop-zone');
            const imageInput = document.getElementById('images');
            const previewGrid = document.getElementById('image-preview-grid');
            const feedback = document.getElementById('image-feedback');
            const maxImageBytes = 1536 * 1024;
            const maxImageSize = 1600;
            let previewUrls = [];

            const updateInputFiles = (files) => {
                const dataTransfer = new DataTransfer();

                files.slice(0, 5).forEach((file) => {
                    dataTransfer.items.add(file);
                });

                imageInput.files = dataTransfer.files;
            };

            const loadImage = (file) => new Promise((resolve, reject) => {
                const image = new Image();
                const imageUrl = URL.createObjectURL(file);

                image.onload = () => {
                    URL.revokeObjectURL(imageUrl);
                    resolve(image);
                };

                image.onerror = () => {
                    URL.revokeObjectURL(imageUrl);
                    reject(new Error('Image illisible'));
                };

                image.src = imageUrl;
            });

            const canvasToBlob = (canvas, quality) => new Promise((resolve) => {
                canvas.toBlob(resolve, 'image/jpeg', quality);
            });

            const optimizeImage = async (file) => {
                if (file.size <= maxImageBytes) {
                    return file;
                }

                const image = await loadImage(file);
                const scale = Math.min(1, maxImageSize / Math.max(image.width, image.height));
                const canvas = document.createElement('canvas');
                canvas.width = Math.max(1, Math.round(image.width * scale));
                canvas.height = Math.max(1, Math.round(image.height * scale));

                canvas.getContext('2d').drawImage(image, 0, 0, canvas.width, canvas.height);

                let quality = 0.82;
                let blob = await canvasToBlob(canvas, quality);

                while (blob && blob.size > maxImageBytes && quality > 0.45) {
                    quality -= 0.08;
                    blob = await canvasToBlob(canvas, quality);
                }

                if (!blob || blob.size > maxImageBytes) {
                    return file;
                }

                return new File([blob], file.name.replace(/\.[^.]+$/, '') + '.jpg', {
                    type: 'image/jpeg',
                    lastModified: Date.now(),
                });
            };

            const renderPreviews = (files) => {
                previewUrls.forEach((url) => URL.revokeObjectURL(url));
                previewUrls = [];
                previewGrid.innerHTML = '';

                files.slice(0, 5).forEach((file) => {
                    const previewUrl = URL.createObjectURL(file);
                    previewUrls.push(previewUrl);

                    const preview = document.createElement('div');
                    preview.className = 'image-preview';

                    const image = document.createElement('img');
                    image.src = previewUrl;
                    image.alt = file.name;

                    preview.appendChild(image);
                    previewGrid.appendChild(preview);
                });

                if (files.length > 5) {
                    feedback.textContent = 'Seules les 5 premieres images seront conservees.';
                    feedback.style.display = 'block';
                } else {
                    feedback.textContent = '';
                    feedback.style.display = 'none';
                }
            };

            const handleFiles = async (fileList) => {
                feedback.textContent = 'Optimisation des images en cours...';
                feedback.style.display = 'block';

                const selectedImages = [...fileList].filter((file) => file.type.startsWith('image/'));
                const images = await Promise.all(selectedImages.slice(0, 5).map((file) => optimizeImage(file)));
                const oversizedImages = images.filter((file) => file.size > maxImageBytes);

                updateInputFiles(images);
                renderPreviews(images);

                if (oversizedImages.length > 0) {
                    feedback.textContent = 'Une ou plusieurs images restent trop lourdes. Choisissez une image de moins de 1,5 Mo.';
                    feedback.style.display = 'block';
                    return;
                }

                if (selectedImages.length > 5) {
                    feedback.textContent = 'Seules les 5 premieres images seront conservees.';
                    feedback.style.display = 'block';
                }
            };

            imageInput.addEventListener('change', () => {
                handleFiles(imageInput.files);
            });

            ['dragenter', 'dragover'].forEach((eventName) => {
                dropZone.addEventListener(eventName, (event) => {
                    event.preventDefault();
                    dropZone.classList.add('is-dragging');
                });
            });

            ['dragleave', 'drop'].forEach((eventName) => {
                dropZone.addEventListener(eventName, (event) => {
                    event.preventDefault();
                    dropZone.classList.remove('is-dragging');
                });
            });

            dropZone.addEventListener('drop', (event) => {
                handleFiles(event.dataTransfer.files);
            });
        </script>
    </body>
</html>
