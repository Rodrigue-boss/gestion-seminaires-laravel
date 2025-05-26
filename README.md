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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# 🎓 Plateforme Web de Gestion des Séminaires — IMSP

Ce projet est une application web réalisée avec **Laravel 10** permettant la gestion complète des séminaires au sein des entités de recherche de l’IMSP. Elle respecte un ensemble de règles de gestion précises basées sur le rôle de chaque utilisateur et le calendrier des présentations.

---

## 🧩 Fonctionnalités principales

- Authentification avec rôles : étudiant, présentateur, secrétaire
- Soumission d’un séminaire par un présentateur
- Validation ou rejet par le secrétaire
- Envoi du résumé par le présentateur à **J–10**
- Publication officielle par le secrétaire à **J–7**
- Notification email aux étudiants à J–7 (via Mailtrap ou log)
- Upload du fichier de présentation
- Téléchargement du fichier par les étudiants
- Filtrage des séminaires par statut
- Export PDF de la liste des séminaires
- Recherche par titre, salle ou nom du présentateur

---

## 🛠️ Technologies utilisées

- Laravel 10
- MySQL
- Laravel Breeze
- Laravel Fortify
- Laravel Vite + TailwindCSS
- Mailtrap (simulation des emails)
- Barryvdh DomPDF (export PDF)
- Blade (moteur de templates Laravel)

---

## 📦 Installation et compilation du projet

### 1. Cloner le projet

```bash
git clone https://github.com/Rodrigue-boss/gestion-seminaires-laravel.git
cd gestion-seminaires

2. Installer les dépendances

composer install
npm install && npm run dev

3. Créer le fichier .env

cp .env.example .env
Configure les accès MySQL dans .env :

DB_DATABASE=seminaires
DB_USERNAME=root
DB_PASSWORD=motdepasse

4. Générer la clé de l'application

php artisan key:generate

5. Lancer les migrations (création de la base de données)

php artisan migrate

6.Créer le lien vers le dossier storage:

php artisan storage:link

7. Démarrer le serveur de développement

php artisan serve

Accéder au projet : http://127.0.0.1:8000


👥 Rôles et navigation

| Rôle         | Page d’accueil                 | Fonctionnalités principales                       |
| ------------ | -----------------------------  | ------------------------------------------------- |
| Présentateur | `/redirect` → `/presentateur` | Soumettre, modifier résumé, uploader fichier      |
| Secrétaire   | `/redirect` → `/secretaire`   | Valider, rejeter, publier à J–7, envoyer emails   |
| Étudiant     | `/redirect` → `/etudiant`     | Voir les séminaires acceptés, télécharger fichier |


🖼️ Captures d’écran
Les principales captures d’écran du projet se trouvent dans le dossier /captures.

📝 Rapport du projet
Le rapport au format PDF et ODT est inclus dans le dépôt :

Rapport_projet_Michael_KLOTOE.pdf

Rapport_projet_Michael_KLOTOE.odt

📄 Licence
Ce projet est à usage académique dans le cadre d’un TP de Conception Web à l’IMSP.
Développé par Michael KLOTOE — Licence 3 TIC, IMSP.
