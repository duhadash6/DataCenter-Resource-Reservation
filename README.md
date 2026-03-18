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

Fonctionnalités
FonctionnalitéDescriptionCarte mondiale interactiveVisualisation D3.js des datacenters dans le mondeCatalogue de ressourcesConsultation en temps réel des ressources disponiblesRéservation en ligneSystème de demandes avec workflow de validationMulti-rôlesUtilisateur, Responsable, Ingénieur, AdministrateurDashboard analytiqueStatistiques, graphiques et rapports mensuels PDFRack MapVisualisation interactive des baies serveurNotificationsSystème de notifications en temps réelAuthentification sécuriséeLogin, réinitialisation de mot de passe, Magic LinkChatbot intégréAssistant virtuel de navigationMode sombre / clairThème adaptatif completQR CodeGénération de QR codes pour chaque ressourceCommand PaletteRecherche rapide inspirée de VSCode

Stack technique

Backend : Laravel
Frontend : Blade, CSS, JavaScript
Base de données : MySQL
Librairies clés :

D3.js et TopoJSON — Cartographie interactive
Laravel DomPDF — Génération de rapports PDF
Simple QrCode — Génération de QR codes
Laravel Sanctum — Authentification par token API




Installation
bash# 1. Cloner le projet
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

---

**Rôles et accès**

| Rôle | Accès |
|---|---|
| Utilisateur | Catalogue, réservation, historique, profil |
| Responsable | Gestion des demandes, incidents et ressources |
| Ingénieur | Dashboard technique, Rack Map |
| Administrateur | Gestion complète, utilisateurs, logs, rapports |

---

**Structure du projet**
```
├── app/
│   ├── Http/Controllers/   # Contrôleurs (Auth, Admin, Resource, Reservation...)
│   └── Models/             # Modèles Eloquent
├── database/
│   ├── migrations/         # Schéma de base de données
│   └── seeders/            # Données de test
├── resources/
│   ├── css/                # Styles par module
│   ├── js/                 # Scripts par module (D3, chatbot, dashboard...)
│   └── views/              # Templates Blade
├── routes/
│   └── web.php             # Toutes les routes de l'application
└── public/
    ├── images/             # Assets médias
    └── build/              # Assets compilés (Vite)

Contribution
Les contributions sont les bienvenues. Pour proposer une amélioration :

Forkez le projet
Créez votre branche : git checkout -b feature/MonAmelioration
Commitez vos changements : git commit -m 'Ajout: MonAmelioration'
Pushez vers la branche : git push origin feature/MonAmelioration
Ouvrez une Pull Request
