<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<!-- ## About Laravel

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

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). -->


# 👁️ RetinoScan - Détection de la Rétinopathie Diabétique Assistée par IA

**RetinoScan** est une plateforme web médicale conçue pour aider les ophtalmologues à gérer leurs patients et à détecter précocement la rétinopathie diabétique.

L'application combine la robustesse de **Laravel** pour la gestion des dossiers médicaux et la puissance de **Python (Deep Learning)** pour l'analyse d'images de fond d'œil.

---

## 🏗️ Architecture du Projet

Le projet fonctionne avec une architecture hybride :

1.  **Frontend & Backend (Laravel)** : Gère l'authentification des médecins, les dossiers patients (CRUD), le stockage des images, generation de rapport (Pdf/image) et l'interface utilisateur.
2.  **Micro-service IA (Python/Flask)** : Une API locale qui reçoit l'image, la traite via un modèle **Hugging Face Transformers**, et renvoie le diagnostic.

| Composant | Technologie | Rôle |
| :--- | :--- | :--- |
| **Web Framework** | Laravel 10+ | Interface, BDD, Logique métier |
| **Base de Données** | MySQL / MariaDB | Stockage Patients & Scans |
| **Frontend** | Blade + TailwindCSS | Interface Utilisateur |
| **API IA** | Python (Flask) | Micro-service de prédiction |
| **Modèle IA** | PyTorch + Transformers | Classification (Sain, Léger, Modéré, Sévère...) |

---

## 📋 Prérequis

### Logiciels requis

Avant de commencer, assurez-vous d'avoir installé :
* PHP >= 8.1 & Composer
* Python >= 3.9 & Pip
* Node.js & NPM (pour le style)
* MySQL (ou un serveur local type XAMPP/Laragon)

---

## 🚀 Installation

### Étape 1 : Installation du Backend (Laravel)

1.  **Cloner le dépôt :**
    ```bash
    git clone [https://github.com/Soihihou05/Diabetic-Detection-Retinopathie.git](https://github.com/modesto77/RetinaScan.git)
    cd projet-ia-retino
    ```

2.  **Installer les dépendances PHP :**
    ```bash
    composer install
    ```

3.  **Configurer l'environnement :**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Ouvrez le fichier `.env` et configurez vos accès à la base de données (`DB_DATABASE`, `DB_USERNAME`, etc.).*

4.  **Préparer la base de données et les fichiers :**
    ```bash
    php artisan migrate
    php artisan storage:link  # CRUCIAL : Pour que les images soient visibles
    ```

5.  **Compiler les assets (CSS/JS) :**
    ```bash
    npm install && npm run build
    ```

---

### Étape 2 : Installation de l'IA (Python)

Le code de l'IA se trouve dans le dossier `python_api/`.

1.  **Aller dans le dossier :**
    ```bash
    cd python_api
    ```

2.  **Créer un environnement virtuel (Recommandé) :**
    * *Windows :* `python -m venv venv`
    * *Mac/Linux :* `python3 -m venv venv`

3.  **Activer l'environnement :**
    * *Windows :* `.\venv\Scripts\activate`
    * *Mac/Linux :* `source venv/bin/activate`

4.  **Installer les dépendances IA :**
    ```bash
    pip install -r requirements.txt
    ```
    *(Cela installera Flask, PyTorch, Transformers et Pillow).*

---

## ▶️ Démarrage de l'Application

Puisque l'application utilise deux serveurs (Web et IA), vous devez ouvrir **deux terminaux** différents.

### Terminal 1 : Lancer le Site Web (Laravel)
À la racine du projet :
```bash
php artisan serve
```
### Terminal 2: Dans le dossier (`python_api/`)
Lancer :
```bash
python app.py
```
---

### Configuration PHP (Indispensable pour les rapports)
Pour générer les rapports , l'extension GD doit être activée :

1. **Ouvrez votre panneau de contrôle (ex: XAMPP)**

2. **Éditez le fichier ``php.ini``**

3. **Cherchez ``;extension=gd`` et retirez le point-virgule au début : ``extension=gd``**

4. **Redémarrez votre serveur Apache**

---
## Pour Tous Problème, n'hesitez pas a me contacter sur ce mail:**``soihihounourddine@gmail.com``**
