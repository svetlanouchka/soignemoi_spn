# SoigneMoi

**SoigneMoi** est un projet complet qui consiste à développer une suite d’applications (web, mobile, et desktop) pour la gestion des séjours hospitaliers, prescriptions médicales et plannings des médecins. Il vise à faciliter la gestion administrative et médicale des patients dans un hôpital, en assurant la sécurité des données et une interface utilisateur ergonomique.

## Table des matières

1. [Contexte du projet](#contexte-du-projet)
2. [Technologies utilisées](#technologies-utilisées)
3. [Fonctionnalités principales](#fonctionnalités-principales)
4. [Installation et configuration](#installation-et-configuration)
   - [Application Web](#application-web)
   - [Application Mobile](#application-mobile)
   - [Application Desktop](#application-desktop)
5. [Structure des dépôts Git](#structure-des-dépôts-git)
6. [Contributeurs](#contributeurs)


## Contexte du projet

Le projet **SoigneMoi** a été réalisé dans le cadre du programme *Développeur Front-End* chez Studi. Il a permis de mettre en pratique les connaissances acquises dans les technologies front-end et back-end, ainsi que la gestion de base de données, tout en intégrant des mesures de sécurité pour protéger les données médicales sensibles.

Les trois applications (web, mobile, desktop) interagissent avec une base de données centralisée, permettant aux utilisateurs de gérer les séjours des patients, de suivre les prescriptions, de consulter les avis médicaux, et de planifier les rendez-vous des médecins.

## Technologies utilisées

### Web Application
- **HTML5 / CSS3 / Bootstrap** : Pour la mise en page et le style.
- **PHP 8.2.0** : Pour le traitement serveur, les API REST et la gestion de la base de données.
- **MySQL 8.0.34** : Pour la persistance des données.
- **PhpMyAdmin** : Pour l'administration de la base de données.
- **XAMPP** : Environnement de développement local.

### Mobile Application
- **Flutter 3.22.2** : Framework pour le développement cross-platform.
- **Dart 3.4.3** : Langage de programmation utilisé avec Flutter.
- **API REST** : Connexion avec les API PHP pour la gestion des données.

### Desktop Application
- **Python 3.12.4** : Pour le développement de l'application bureau.
- **Tkinter** : Pour la création de l'interface graphique.
- **API REST** : Pour la connexion avec les données de l'hôpital via l'API PHP.

### Outils et Environnements
- **Git** : Pour la gestion des versions.
- **Figma** : Pour la conception des maquettes.
- **Docker** et **Fly.io** : Pour le déploiement.
- **PhpUnit** : Pour les tests unitaires.

## Fonctionnalités principales

- **Gestion des séjours** : Ajout, modification et visualisation des séjours des patients.
- **Prescriptions médicales** : Gestion des prescriptions liées aux séjours.
- **Avis médicaux** : Les médecins peuvent ajouter des avis médicaux pour les séjours en cours.
- **Planning des médecins** : Suivi des disponibilités et planification des rendez-vous des médecins.
- **Sécurisation des données** : Authentification par token JWT, et requêtes SQL préparées.

## Installation et configuration

### Application Web

   Accéder à https://soignemoi-spn.fly.dev/
   Idéntifiants : 
   Email : test@gmail.com
   Mot de passe : test

   ### Docker
Un fichier `Dockerfile` et `docker-compose.yml` permettent de lancer :
- L'application PHP avec Apache
- Un conteneur MySQL
- Un conteneur MongoDB

docker-compose up --build

### Application Mobile
1. **Cloner le dépôt Git** :
git clone https://github.com/svetlanouchka/flutter_app_s.git
2. **Installer les dépendances** :
flutter pub get
3. **Lancer l’application dans un émulateur** :
Lancer un émulateur Android via Android Studio ou utiliser un appareil physique.
Exécuter la commande suivante :
flutter run

### Application Desktop
1. **Cloner le dépôt Git** :
git clone https://github.com/svetlanouchka/soignemoi_appbureatique.git
2. **Installer Python et les dépendances** :
Installer Python 3.12.4.
Utiliser pip pour installer les dépendances nécessaires :
pip install -r requirements.txt
3. **Lancer l'application** :

python main.py

## Structure des dépôts Git

Le projet est réparti sur trois dépôts Git distincts :

- [Dépôt Web Application](https://github.com/svetlanouchka/soignemoi_spn) :
  Ce dépôt contient tout le code source de l'application web **SoigneMoi** développée en PHP. Cette application permet la gestion des séjours des patients, la création de prescriptions, et la gestion des avis médicaux.

- [Dépôt Mobile Application](https://github.com/svetlanouchka/flutter_app_s) :
  Ce dépôt héberge le code source de l'application mobile **SoigneMoi**, développée en Flutter. Cette application mobile est utilisée par les médecins pour gérer les séjours, prescriptions et avis des patients en mobilité.

- [Dépôt Desktop Application](https://github.com/svetlanouchka/soignemoi_appbureatique) :
  Ce dépôt contient le code de l'application desktop **SoigneMoi**, développée en Python avec Tkinter. Elle permet aux utilisateurs administratifs de gérer les données des patients et les dossiers depuis un ordinateur de bureau.

## Contributeurs
Svetlana Nigay : Développeuse principale des applications SoigneMoi. Ce projet a été réalisé en autonomie complète.
