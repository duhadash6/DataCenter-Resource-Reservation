<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
Description
Plateforme web développée sous Laravel pour la gestion, la réservation et la supervision des ressources d'un datacenter (serveurs, réseaux, stockage, etc.). Elle intègre un espace multi-rôles sécurisé adapté aux besoins des utilisateurs, des responsables, des ingénieurs et des administrateurs.

# DataCenter Resource Reservation

> Université Abdelmalek Essaadi — Faculté des Sciences et Techniques de Tanger
> Licence IDAI | Développement Web | 2025–2026

---

## Description

Plateforme web développée sous Laravel pour la gestion, la réservation et la supervision des ressources d'un datacenter (serveurs, réseaux, stockage, etc.). Elle intègre un espace multi-rôles sécurisé adapté aux besoins des utilisateurs, des responsables, des ingénieurs et des administrateurs.

---

## Fonctionnalités

| Fonctionnalité | Description |
|---|---|
| Carte mondiale interactive | Visualisation D3.js des datacenters dans le monde |
| Catalogue de ressources | Consultation en temps réel des ressources disponibles |
| Réservation en ligne | Système de demandes avec workflow de validation |
| Multi-rôles | Utilisateur, Responsable, Ingénieur, Administrateur |
| Dashboard analytique | Statistiques, graphiques et rapports mensuels PDF |
| Rack Map | Visualisation interactive des baies serveur |
| Notifications | Système de notifications en temps réel |
| Authentification sécurisée | Login, réinitialisation de mot de passe, Magic Link |
| Chatbot intégré | Assistant virtuel de navigation |
| Mode sombre / clair | Thème adaptatif complet |
| QR Code | Génération de QR codes pour chaque ressource |
| Command Palette | Recherche rapide inspirée de VSCode |

---

## Stack technique

- **Backend** : Laravel (PHP)
- **Frontend** : Blade, CSS Vanilla, JavaScript
- **Base de données** : MySQL
- **Librairies clés** :
  - D3.js et TopoJSON — Cartographie interactive
  - Laravel DomPDF — Génération de rapports PDF
  - Simple QrCode — Génération de QR codes
  - Laravel Sanctum — Authentification par token API

---

## Installation

```bash
# 1. Cloner le projet
git clone https://github.com/s-elbourmaki/datacenter-resource-reservation.git
cd datacenter-resource-reservation

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances Node
npm install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Configurer la base de données dans .env
# DB_DATABASE=datacenter
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 6. Initialiser la base de données
php artisan migrate --seed

# 7. Compiler les assets
npm run build

# 8. Lancer le serveur
php artisan serve
```

> **Windows** : vous pouvez aussi exécuter `setup.bat` pour une installation automatique.
> **Linux / macOS** : utilisez `bash setup.sh`.

---

## Rôles et accès

| Rôle | Accès |
|---|---|
| Utilisateur | Catalogue, réservation, historique, profil |
| Responsable | Gestion des demandes, incidents et ressources |
| Ingénieur | Dashboard technique, Rack Map |
| Administrateur | Gestion complète, utilisateurs, logs, rapports |

---

## Structure du projet

```
datacenter-resource-reservation/
│
├── app/
│   ├── Models/                         <- User, Resource, Reservation, ActivityLog
│   ├── Http/
│   │   ├── Controllers/                <- Auth, Resource, Reservation, Admin
│   │   ├── Requests/                   <- Validation des formulaires
│   │   └── Middleware/                 <- IsAdmin, authentification
│   └── Services/                       <- ReservationConflictService, ActivityLogService
│
├── database/
│   ├── migrations/                     <- Schéma de la base de données
│   └── seeders/                        <- Données de test
│
├── resources/
│   ├── css/                            <- Styles par module (Vanilla CSS)
│   ├── js/                             <- Scripts (D3.js, chatbot, dashboard...)
│   └── views/                          <- Templates Blade
│
├── routes/
│   └── web.php                         <- Toutes les routes de l'application
│
├── public/                             <- Point d'entrée (index.php)
├── storage/                            <- Logs, cache, sessions
├── tests/                              <- Tests unitaires et fonctionnels
├── bootstrap/
├── config/
│
├── artisan
├── composer.json
├── package.json
├── vite.config.js
├── .env.example
├── setup.bat                           <- Installation automatique Windows
├── setup.sh                            <- Installation automatique Linux/macOS
├── BACKEND_DOCUMENTATION.md
├── AUTH_SETUP.md
└── README.md
```

---

## Contribution

Les contributions sont les bienvenues. Pour proposer une amélioration :

1. Forkez le projet
2. Créez votre branche
```bash
git checkout -b feature/MonAmelioration
```
3. Commitez vos changements
```bash
git commit -m "Ajout: MonAmelioration"
```
4. Pushez vers la branche
```bash
git push origin feature/MonAmelioration
```
5. Ouvrez une Pull Request

---

## Auteurs

Projet réalisé par :

- ZIOUANI Doha

Encadré par **Prof. Yasyn EL YUSUFI** et **Prof. M'hamed AIT KBIR**

---

*Université Abdelmalek Essaadi — Faculté des Sciences et Techniques de Tanger — 2025/2026*

