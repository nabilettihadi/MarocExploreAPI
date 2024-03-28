# MarocExplore API

## Contexte du projet

Dans le cadre de la promotion du tourisme au Maroc, la plateforme "MarocExplore" souhaite concevoir une API dédiée à la gestion d'itinéraires, mettant en avant la diversité et la richesse des destinations marocaines.

## Objectif du Projet

L'objectif principal de ce projet est de développer une API robuste pour la gestion d'itinéraires, permettant aux utilisateurs authentifiés de créer des itinéraires personnalisés composés d'un titre, d'une catégorie (plage, montagne, rivière, monument, etc.), d'une durée, d'une image et de 2 ou plusieurs destinations. Chaque destination sera caractérisée par son nom, un lieu de logement et une liste des endroits à visiter/activités/plats à essayer.

## User Stories

    En tant qu'utilisateur, je veux pouvoir créer un compte et m'authentifier sur l'API.
    En tant qu'utilisateur authentifié, je veux pouvoir créer un nouvel itinéraire.
    En tant qu'utilisateur authentifié, je veux pouvoir ajouter plusieurs destinations à un itinéraire.
    En tant qu'utilisateur authentifié, je veux que seuls mes propres itinéraires soient modifiables.
    En tant qu'utilisateur authentifié, je veux pouvoir ajouter un itinéraire à ma liste à visiter.
    En tant qu'internaute, je veux pouvoir visualiser les différents itinéraires sur la plateforme.
    En tant qu'internaute, je veux pouvoir rechercher des itinéraires et les filtrer par catégorie ou par durée.
    En tant que développeur, je veux avoir des tests unitaires complets pour chaque fonctionnalité de l'API.
    En tant que développeur, je veux effectuer des tests sur Postman pour valider le bon fonctionnement de l'API dans différents scénarios.
    En tant que développeur, je veux fournir une documentation détaillée de l'API pour faciliter son utilisation par d'autres développeurs. Cette documentation sera créée à l'aide d'outils tels que Postman, Swagger, API Blueprint ou d'autres outils similaires ayant le même objectif.

## Bonus

    Utilisation de JWT pour l'authentification des utilisateurs, offrant une méthode sécurisée et standardisée d'authentification.

## Installation

    Clonez le dépôt GitHub.
    Assurez-vous d'avoir PHP et Composer installés localement.
    Installez les dépendances avec composer install.
    Créez un fichier .env en vous basant sur le fichier .env.example et configurez votre base de données et d'autres paramètres si nécessaire.
    Générez une clé d'application avec php artisan key:generate.
    Exécutez les migrations avec php artisan migrate pour mettre en place la base de données.
    Démarrez le serveur de développement avec php artisan serve.

## Documentation de l'API

La documentation détaillée de l'API est disponible dans le fichier API_Documentation.md. Elle a été générée à l'aide de Postman et fournit des exemples d'utilisation de chaque endpoint de l'API.

## Tests

L'API est livrée avec des tests unitaires complets pour chaque fonctionnalité. Exécutez les tests avec php artisan test.

## Contribuer

Les contributions sont les bienvenues ! Pour toute suggestion, rapport de bug ou demande de fonctionnalité, veuillez ouvrir une issue pour en discuter.