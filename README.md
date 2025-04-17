# Application de Résérvation de salles de réunion

## Introduction

Cette application Laravel est conçue pour gérer les résérvations des salles de réunion. Elle permet aux employés de visualiser et réserver des salles de réunions et aux administrateurs de gérer les salles et d'avoir des statistiques des résérvations.

## Fonctionnalités

- **Gestion des Salles**: Création, modification et suppression des salles par les administrateurs et visualisation par les employés.
- **Gestion des Résérvations**: Les employés peuvent voir leurs résérvations passées et à venir ainsi que leur détail, annuler celles qui ne sont pas passées et vérifier la disponibilité des salles et faire des résérvations de salles sur un créneau donné si elles sont disponibles
- **Visualisation des statistiques**: Visualisation des statistiques des résérvations sur les 6 dernières semaines
- **Notifications par Email**: Envoi de confirmations par email aux employés pour les résérvations et annulations.

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- MySQL ou une autre base de données compatible avec Laravel
- Node.js et npm (pour les assets front-end)

## Installation

### 1. Cloner le Repository

```bash
cd chemin/vers/votre/projet
git clone https://github.com/bastienchevalier5/eval.git .
```


### 2. Configurer l'environnement

Copiez le fichier .env.example en .env

```bash
cp .env.example .env
```
Configurez les paramètres de votre environnement, notamment les informations de connexion à la base de données.

```php
// Changer le nom de l'application
APP_NAME='Gestion des résérvations'

// Changer le Timezone de l'application
APP_TIMEZONE='Europe/Paris'

// Changer l'url de  l'application
APP_URL=http://localhost

// Changer les informations sur la langue
APP_LOCALE=fr
APP_FAKER_LOCALE=fr_FR

// Changer les informations pour que cela corresponde à votre base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1 ou l'adresse de votre base de données
DB_PORT=3306
DB_DATABASE=nom_de_votre_base_de_donnees
DB_USERNAME=votre_nom_d'utilisateur
DB_PASSWORD=votre_mot_de_passe

```

### 3. Installer les dépendances

```bash
composer install
npm install
npm run build
npm run dev
```

### 4. Générer la clé de l'application

```bash
php artisan key:generate
```

### 5. Exécuter les migrations

```bash
php artisan migrate
```

### 6. Remplir la base de données

```bash
php artisan db:seed
```
### 7. Logins et mot de passes

Administrateur : 
Email : admin@admin.fr
Mot de passe : administrateur

Utilisateur :
Email : employe@lambda.fr
Mot de passe : employelambda


### 8. Accéder à l'application

Maintenant, vous devrez pouvoir atteindre l'application en allant sur l'url que vous avez indiqué.
