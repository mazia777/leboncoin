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

## Deploiement Railway

Railway detecte automatiquement les applications Laravel et les sert via PHP-FPM/Caddy. Le projet contient une configuration `railway.json` pour encadrer le build et les actions avant demarrage.

Fichiers Railway ajoutes :

- `railway.json` : utilise Railpack, lance `npm run build`, puis le script de pre-deploiement.
- `railway/init-app.sh` : vide les caches Laravel, lance les migrations, cree le lien `storage` et seed les donnees de demo si la base est vide.

Railway peut deployer depuis GitHub :

1. Creer un projet Railway.
2. Ajouter un service MySQL Railway.
3. Ajouter un service depuis le repository GitHub.
4. Generer un domaine public dans l'onglet `Networking`.
5. Configurer les variables d'environnement ci-dessous.

Railway peut aussi deployer en CLI :

```bash
railway init
railway up
```

Variables minimales pour le service Laravel :

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://votre-domaine.up.railway.app
LOG_CHANNEL=stderr
FILESYSTEM_DISK=public
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

Variables MySQL avec un service MySQL Railway :

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

Le pre-deploiement execute automatiquement :

```bash
php artisan app:deploy-prepare --seed-demo
```

Cette commande :

- lance les migrations avec `--force`;
- tente de creer le lien public `storage`;
- cree les donnees de demonstration uniquement si la base ne contient encore aucune donnee applicative;
- evite de reseeder la base a chaque redeploiement.

Point important : le disque local Railway est ephemere. Les images uploadees peuvent etre perdues au redeploiement si aucun volume ou stockage externe n'est configure. Pour une vraie production, utiliser un volume Railway monte sur `storage`, ou migrer les images vers un stockage objet compatible S3.

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
