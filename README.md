# Gestion des familles adhérentes

Application web simple permettant de gérer les familles adhérentes à une association à des activités : inscription et authentification des utilisateurs, ainsi que CRUD sur les fiches familles via une API REST.

## Aperçu

- Authentification par formulaire (connexion et inscription) avec stockage sécurisé du mot de passe (`password_hash`).
- API REST pour gérer les familles (lecture, création, mise à jour, suppression).
- Interface servie par Caddy + PHP-FPM, base de données MySQL, interface d’administration via Adminer.

## Architecture

| Service  | Rôle | Définition |
|----------|------|------------|
| Caddy    | Proxy HTTP/S + serveur de fichiers statiques | `Caddyfile` |
| PHP-FPM  | Exécution du code PHP (`www/`) | `php/Dockerfile` |
| MySQL    | Base de données relationnelle | `compose.yml` |
| Adminer  | Interface web de gestion MySQL | `compose.yml` |

Les routes principales sont définies dans `www/index.php:3` et délèguent aux contrôleurs/API correspondants (`www/src/api/*.php`, `www/src/controllers/*.php`).

## Démarrage rapide

1. **Prérequis** : Docker et Docker Compose.
2. **Cloner** le dépôt puis se placer à la racine.
3. **Lancer** l’environnement :

   ```bash
   docker compose up --build

---

- Caddy : http://localhost
- Adminer : http://localhost:8080 (serveur `mysql`, base `db`, user `user`, mot de passe `password`)

- Créer le schéma de base (à exécuter dans MySQL ou via Adminer) :
  ```sql 
    CREATE TABLE `activity` (
      `id` int NOT NULL AUTO_INCREMENT,
      `name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
      `description` text NOT NULL,
      `capacity` int NOT NULL,
      `is_active` tinyint NOT NULL DEFAULT '1',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


    CREATE TABLE `family` (
      `id` int NOT NULL AUTO_INCREMENT,
      `name` char(255) NOT NULL,
      `email` char(255) NOT NULL,
      `phone` char(255) NOT NULL,
      `adress` char(255) NOT NULL,
      `members` int DEFAULT NULL,
      `is_actif` tinyint NOT NULL DEFAULT '1',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `uptaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


    CREATE TABLE `family_activity` (
      `id` int NOT NULL AUTO_INCREMENT,
      `id_family` int NOT NULL,
      `id_activity` int NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `id_family` (`id_family`),
      KEY `id_activity` (`id_activity`),
      CONSTRAINT `family_activity_ibfk_1` FOREIGN KEY (`id_family`) REFERENCES `family` (`id`),
      CONSTRAINT `family_activity_ibfk_2` FOREIGN KEY (`id_activity`) REFERENCES `activity` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


    CREATE TABLE `user` (
      `id` int NOT NULL AUTO_INCREMENT,
      `username` char(255) NOT NULL,
      `email` char(255) NOT NULL,
      `hashed_password` char(255) NOT NULL,
      `role` char(255) NOT NULL DEFAULT 'USER',
      `is_actif` tinyint NOT NULL DEFAULT '1',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

- Arrêter les services :
    ```bash
    docker composer down

---

## Structure du projet
  ```
  .
  ├── compose.yml              # Stack Docker (MySQL, PHP-FPM, Caddy, Adminer)
  ├── Caddyfile                # Configuration Caddy
  ├── php/Dockerfile           # Image PHP (extensions mysqli/pdo_mysql)
  └── www/
      ├── index.php            # Router basique (front-controller)
      ├── src/
      │   ├── api/             # API REST (login, register, family)
      │   ├── controllers/     # Vues login/register & logout
      │   ├── models/          # Accès BDD via PDO (`Db` dans middleware)
      │   ├── middleware/      # Connexion PDO, helpers de session
      │   ├── layout/          # Layout HTML + Bootstrap/JQuery CDN
      │   └── templates/       # Formulaires login/register
  ```

---

## Projet en cours de développement