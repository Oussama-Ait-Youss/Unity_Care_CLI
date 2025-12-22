## Unity Care CLI

    Système de gestion hospitalière en ligne de commande (CLI).

    Unity Care CLI est une refonte complète de la logique métier de gestion clinique, passant d'une approche procédurale à une Architecture Orientée Objet (OOP) stricte sous PHP 8. Ce projet sert d'outil interne pour administrer rapidement les départements, les médecins et les patients via une interface console interactive.
     



## Table des Matières

    - Fonctionnalités

    - Architecture Technique

    - Prérequis

    - Installation

    - Configuration

    - Utilisation

    - Structure du Projet

    - Auteur

## Fonctionnalités
    Gestion des Ressources (CRUD)

    Patients : Création, modification, suppression et listage avec calcul automatique de l'âge.

    Médecins : Gestion du staff médical, affectation aux départements et suivi de l'ancienneté.

    Départements : Organisation des services hospitaliers.



## Statistiques & Reporting

    Calcul de l'âge moyen des patients.

    Ancienneté moyenne des médecins.

    Département le plus fréquenté.

    Affichage des données sous forme de tableaux ASCII formatés.

## Sécurité & Validation

    Validateur de données centralisé (Email, Téléphone, Dates).

    Protection contre les injections SQL (Requêtes préparées via MySQLi).

    Encapsulation stricte des données.

## Architecture Technique

Le projet respecte les principes SOLID et les standards modernes de PHP :

    Langage : PHP 8.2+ (Typage fort).

    Base de données : MySQL avec extension MySQLi (Orienté Objet).

    Design Patterns :

        Singleton : Pour la connexion unique à la base de données (Database).

        Active Record (Lite) : Via la classe abstraite BaseModel pour les opérations CRUD génériques.

    Interfaces : Displayable pour standardiser l'affichage console.

    Héritage : Personne -> Doctor / Patient.

## Prérequis

    PHP : Version 8.0 ou supérieure.

    MySQL : Serveur de base de données.

    Composer (Optionnel, si utilisé pour l'autoloading).

    Terminal : Git Bash, PowerShell ou Terminal Linux/Mac.

## Installation

    Cloner le dépôt
    - git clone https://github.com/votre-username/unity-care-cli.git
    - cd unity-care-cli

## Mise en place de la Base de Données

    Connectez-vous à votre serveur MySQL.

    Créez une base de données nommée unity_care.

    Importez le script SQL fourni :

    - mysql -u root -p unity_care < sql/schema.sql

## Installation des dépendances (si applicable)

    - composer install


## Configuration

    Naviguez vers le dossier config.

    Copiez le fichier d'exemple (si présent) ou créez db.php :

    - <?php
        // config/db.php
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASS', ''); // Votre mot de passe
        define('DB_NAME', 'unity_care');

 ## Utilisation

    Pour lancer l'application, ouvrez votre terminal à la racine du projet et exécutez :
    - php main.php

    Vous verrez apparaître le menu principal interactif :
    `
            === Unity Care CLI ===
        1. Gérer les patients
        2. Gérer les médecins
        3. Gérer les départements
        4. Statistiques
        5. Quitter
        > Choisissez une option :
    `

 ## Structure du Projet

    ` unity-care-cli/
    ├── config/             # Configuration BDD
    ├── src/
    │   ├── Config/         # Gestion de la connexion (Database.php)
    │   ├── Entities/       # Classes Métiers (Doctor, Patient, Department)
    │   ├── Utils/          # Helpers (Validator, ConsoleTable)
    │   └── Interfaces/     # Contrats (Displayable)
    ├── sql/                # Scripts de création de tables
    ├── main.php            # Point d'entrée de l'application
    └── README.md           # Documentation
    `


 ## Auteur

    Oussama Ait Youss

       Role : Full Stack Developer Student @ YouCode

       Stack : PHP, MySQL, Linux, Docker

       --------------------------------------------------------------

       <?php echo "Ce projet a été réalisé dans le cadre d'un brief pédagogique visant à maîtriser la POO en PHP sans framework.";
