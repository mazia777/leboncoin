# Clone Leboncoin Laravel

Clone simplifie du site Leboncoin realise avec Laravel. Le projet couvre les fondations produit principales : accueil avec recherche, categories, details d'annonce, depot d'annonce, authentification, dashboard utilisateur, modification et suppression des annonces.

## Fonctionnalites

- Authentification utilisateur Laravel.
- Page d'accueil avec hero, categories et listing des dernieres annonces.
- Recherche par nom d'annonce et par categorie.
- Page detail d'une annonce avec images, description, prix et vendeur.
- Depot d'annonce reserve aux utilisateurs connectes.
- Upload de 1 a 5 images avec apercu et optimisation cote navigateur.
- Dashboard utilisateur avec avatar, porte-monnaie, total des ventes et listing des annonces.
- Modification et suppression des annonces par leur vendeur uniquement.
- Donnees fictives via seeder : utilisateurs, categories, annonces et images Picsum.

## Prerequis

- PHP 8.3 ou superieur.
- Composer.
- Node.js et npm.
- MySQL ou SQLite.
- Extension PHP GD activee pour la gestion des images.

## Installation

Cloner le projet puis installer les dependances PHP :

```bash
composer install
```

Installer les dependances front :

```bash
npm install
```

Copier le fichier d'environnement si necessaire :

```bash
cp .env.example .env
```

Generer la cle d'application :

```bash
php artisan key:generate
```

Configurer la base de donnees dans `.env`. Exemple MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=leboncoin
DB_USERNAME=root
DB_PASSWORD=
```

Configurer aussi l'URL locale utilisee par Laravel :

```env
APP_URL=http://127.0.0.1:8000
```

## Base de donnees

Lancer les migrations :

```bash
php artisan migrate
```

Generer les fausses donnees :

```bash
php artisan db:seed
```

Le seeder genere :

- 20 categories.
- 50 utilisateurs.
- 1 a 5 annonces par utilisateur.
- 0 a 3 annonces vendues par utilisateur.
- 1 a 5 images Picsum par annonce.

## Stockage des images

Les images uploadees sont stockees dans :

```text
storage/app/public/annonces
```

Creer le lien public Laravel :

```bash
php artisan storage:link
```

Sans ce lien, les images stockees ne seront pas accessibles via `/storage/...`.

## Lancement local

Lancer le serveur Laravel :

```bash
php artisan serve
```

Lancer Vite si besoin pour les assets :

```bash
npm run dev
```

Ouvrir ensuite :

```text
http://127.0.0.1:8000
```

## Deploiement InfinityFree

InfinityFree est un hebergement mutualise PHP/MySQL avec publication par FTP. Le deploiement doit donc etre prepare localement, puis envoye sur le serveur avec les dependances deja installees.

Le projet est verrouille sur PHP `8.3.32` via Composer afin de rester compatible avec InfinityFree et avec les dependances Laravel actuelles.

Avant upload, generer le projet en local :

```bash
composer install --no-dev --optimize-autoloader
npm run build
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Structure FTP recommandee :

```text
/
├── htdocs/
│   ├── index.php
│   ├── .htaccess
│   ├── build/
│   ├── storage/
│   ├── favicon.ico
│   └── robots.txt
└── leboncoin/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    ├── artisan
    ├── composer.json
    └── composer.lock
```

Copier dans `/htdocs` :

- le contenu de `public/build` apres `npm run build`;
- `public/favicon.ico` et `public/robots.txt`;
- les fichiers fournis dans `infinityfree/htdocs`.

Copier le reste du projet dans `/leboncoin`, sans le dossier `node_modules`. Le dossier `vendor` doit etre present, car InfinityFree ne doit pas executer Composer en production.

Configurer le fichier `/leboncoin/.env` :

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://votre-domaine.infinityfreeapp.com
FILESYSTEM_DISK=public
PUBLIC_DISK_ROOT=/chemin/absolu/vers/htdocs/storage
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

Configurer aussi les variables MySQL fournies par InfinityFree :

```env
DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...
```

Les migrations ne peuvent pas etre lancees automatiquement si aucun acces SSH n'est disponible. Les executer localement sur une base equivalente, exporter le SQL, puis l'importer dans phpMyAdmin InfinityFree. La commande suivante reste disponible sur un environnement qui permet Artisan :

```bash
php artisan app:deploy-prepare --seed-demo
```

Point important : garder `.env`, `vendor`, `storage`, `database` et le code applicatif hors du dossier public `htdocs`. Seuls le front controller, les assets publics et le dossier `storage` public doivent etre exposes.

## Routes principales

- `/` : page d'accueil.
- `/login` : connexion.
- `/register` : inscription.
- `/annonces/create` : depot d'annonce, utilisateur connecte requis.
- `/annonces/{annonce}` : detail d'annonce.
- `/annonces/{annonce}/edit` : modification d'annonce, vendeur uniquement.
- `/dashboard` : tableau de bord utilisateur.

## Notes de securite

- Le depot, la modification et la suppression d'annonce sont proteges par `auth`.
- La modification et la suppression verifient que l'utilisateur connecte est bien le vendeur.
- Les images sont validees cote serveur avec la regle Laravel `image`.
- La taille maximale actuelle est limitee a environ 1,5 Mo par image pour rester compatible avec la configuration PHP locale.
- Les formulaires utilisent les protections CSRF Laravel.

## Collaboration

Nous avons structure progressivement le projet comme un MVP Leboncoin sous Laravel. La collaboration a commence par la modelisation de la base de donnees, puis l'ajout des seeders, des pages publiques, du depot d'annonce, de l'authentification personnalisee, du dashboard utilisateur et des actions de gestion des annonces. Les choix ont privilegie des changements courts, lisibles et reversibles, avec une attention particuliere a la stabilite, aux relations Eloquent, a la securite des actions utilisateur et a une interface coherente avec l'esprit marketplace du produit.
