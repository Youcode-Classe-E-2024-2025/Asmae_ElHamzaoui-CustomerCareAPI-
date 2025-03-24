# Asmae_ElHamzaoui-CustomerCareAPI-

# API de Gestion du Service Client


## Contexte du projet
Les entreprises modernes doivent offrir un service client réactif et structuré pour assurer la satisfaction des utilisateurs. Ce projet propose de concevoir une API avancée et documentée permettant aux entreprises de centraliser et gérer leurs requêtes clients efficacement.


## Objectif
Ce projet a pour but de :

- Créer une API en Laravel respectant les principes REST.
- Intégrer l'authentification et l’autorisation avec Laravel Sanctum.
- Gérer les opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) avec Eloquent ORM.
- Assurer la validation des données et la gestion des erreurs.
- Implémenter la pagination et la gestion des filtres.
- Fournir une documentation de l'API avec Swagger (Laravel OpenAPI).

## Fonctionnalités
- CRUD pour la gestion des utilisateurs, ticketes et réponses.
- Authentification via Laravel Sanctum pour sécuriser l'accès aux ressources.
- Gestion des erreurs et validation des données.
- Pagination et filtres pour optimiser l'interaction avec les données.
- Documentation complète de l'API via Swagger pour faciliter l'intégration.
- Tests API avec Postman.



## Critères de performance

### Sécurité
- Authentification sécurisée via Laravel Sanctum.
- Validation des données et gestion des erreurs.
- Protection contre les injections SQL et les attaques CSRF.

### Documentation
- Documentation API complète avec Swagger.
- README détaillé (installation, endpoints, exemples de requêtes).


## Installation et Démarrage

### Prérequis
- PHP 8.x+
- Composer
- Laravel 8.x+
- MySQL ou PostgreSQL pour la base de données

### Installation
1. Clonez le projet depuis GitHub :

    ```bash
    git clone https://github.com/Youcode-Classe-E-2024-2025/Asmae_ElHamzaoui-CustomerCareAPI-
    cd Asmae_ElHamzaoui-CustomerCareAPI-
    ```

2. Installez les dépendances avec Composer :

    ```bash
    composer install
    ```
3. Lancez les migrations pour créer les tables nécessaires :

    ```bash
    php artisan migrate
    ```

4. Démarrez le serveur de développement :

    ```bash
    php artisan serve
    ```

L'API sera accessible à l'URL suivante dans votre navigateur :

```bash
http://localhost:8000 
```
## Documentation API avec Swagger

## Accéder à la documentation Swagger

Une fois que vous avez démarré votre serveur, vous pouvez accéder à la documentation interactive générée par Swagger en vous rendant à l'URL suivante :

```bash
http://localhost:8000/api/documentation
```

Dans cette interface, vous trouverez :

- La liste de toutes les routes disponibles pour l'API.
- Des détails sur chaque route, y compris les paramètres à passer et les réponses attendues.
- La possibilité de tester chaque endpoint directement depuis le navigateur (par exemple, pour envoyer une requête GET ou POST).

## Tester l'API avec Postman

### Étape 1 : Installer Postman
Téléchargez et installez Postman depuis leur site officiel.

### Étape 2 : Importer la collection Postman
Une fois le projet configuré, nous avons préparé une collection Postman pour vous aider à tester l'API. Importez cette collection en suivant ces étapes :

- Ouvrez Postman.
- Cliquez sur "Import".
- Sélectionnez le fichier de collection Postman postman_collection.json (fournissez-le à l'utilisateur).
- Cliquez sur "Import".

### Étape 3 : Tester les endpoints
Une fois la collection importée, vous pouvez commencer à tester les différents endpoints de l'API en cliquant sur les requêtes et en appuyant sur "Send" pour envoyer les requêtes.

Voici des exemples de requêtes que vous pouvez tester avec Postman :

- POST http://localhost:8000/api/users pour créer un nouvel utilisateur (avec un corps de requête JSON).
- GET http://localhost:8000/api/tickets/1 pour obtenir les détails d'un ticket.
- POST http://localhost:8000/api/login pour obtenir un token d'authentification avec Laravel Sanctum.



