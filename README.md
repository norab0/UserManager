
# Application de Gestion des Utilisateurs

## Description

Cette application permet de gérer les utilisateurs dans une base de données. Elle inclut des opérations basiques telles que l'ajout, la mise à jour, la suppression, et la récupération d'utilisateurs via une API. L'application est conçue pour être utilisée comme base pour la gestion des utilisateurs dans des systèmes plus complexes.

## Fonctionnalités

- **Ajouter un utilisateur** : Permet d'ajouter un utilisateur avec un nom et un email unique.
- **Mettre à jour un utilisateur** : Permet de modifier les informations d'un utilisateur existant.
- **Supprimer un utilisateur** : Permet de supprimer un utilisateur en fonction de son identifiant.
- **Récupérer la liste des utilisateurs** : Récupère tous les utilisateurs stockés dans la base de données.
- **Validation des données** : Validation des données envoyées (notamment pour l'email) afin d'assurer la conformité des informations.
- **Gestion des erreurs** : L'application gère les erreurs liées à des utilisateurs inexistants et des emails invalides.

## Technologies Utilisées

- **PHP** : Langage de programmation principal pour la gestion des requêtes et des réponses.
- **MySQL** : Base de données utilisée pour stocker les informations des utilisateurs.
- **PHPUnit** : Outil de test unitaire pour tester la logique de l'application.
- **Selenium IDE** : Tests End-to-End 
- **k6** : Outil de test de performance utilisé pour simuler une charge d'utilisateurs sur l'API.

## Installation

1. Clonez le repository sur votre machine locale :
   ```bash
   git clone https://github.com/gestion_produit/gestion_produit.git
   ```
2. Accédez au dossier du projet :
   ```bash
   cd gestion_produit
   ```
3. Créez une base de données MySQL et importez le schéma SQL :
   ```sql
   CREATE DATABASE user_management;
   USE user_management;

   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(150) NOT NULL UNIQUE
   );

4. Configurez votre serveur PHP. Si vous utilisez un serveur local comme XAMPP ou WAMP, vous pouvez simplement déplacer ce projet dans le dossier `htdocs` et l'exécuter via `localhost`.

5. Installez les dépendances (si nécessaire) et les outils de tests pour PHP :
   ```bash
   composer install
   ```

6. Pour tester l'API, vous pouvez utiliser des outils comme [Postman](https://www.postman.com/) ou `curl`.

## API Endpoints

L'application expose les routes suivantes pour interagir avec la base de données des utilisateurs :

- **GET /users** : Récupère tous les utilisateurs.
- **POST /users** : Crée un nouvel utilisateur. Les données doivent être envoyées sous forme de paramètres `name` et `email`.
- **PUT /users** : Met à jour un utilisateur. Les données doivent inclure l'id, le nom et l'email.
- **DELETE /users?id={id}** : Supprime un utilisateur avec l'id spécifié.

## Tests

### Tests Unitaires

Les tests unitaires peuvent être exécutés avec PHPUnit pour vérifier que les opérations de gestion des utilisateurs fonctionnent comme prévu. Pour exécuter les tests :

1. Assurez-vous que PHPUnit est installé. Si ce n'est pas le cas, vous pouvez l'installer via Composer :
   ```bash
   composer require --dev phpunit/phpunit
   ```
2. Exécutez les tests :
   ```bash
   vendor/bin/phpunit
   ```

### Tests de Performance

Les tests de performance peuvent être réalisés avec k6 pour simuler une charge sur l'API et évaluer sa réactivité sous une charge d'utilisateurs. Assurez-vous que k6 est installé sur votre machine, puis lancez un test de performance comme suit :

```bash
k6 run test.js
```

Le fichier `test.js` doit contenir le script de test de charge adapté à votre API.

## Conclusion

Cette application permet de gérer facilement un ensemble d'utilisateurs via une API PHP, avec une base de données MySQL. Elle comprend des validations de données, des tests unitaires pour assurer la qualité du code, ainsi que des tests de performance pour évaluer la charge sur l'application.

## Auteurs

- **NORA BOUDARBALA**
## License

Ce projet est sous licence MIT - voir le fichier [LICENSE](LICENSE) pour plus d'informations.
```