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
    CREATE TABLE user (
      id INT AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(255) NOT NULL UNIQUE,
      hashed_password VARCHAR(255) NOT NULL,
      username VARCHAR(100) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE family (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      adress VARCHAR(255) NOT NULL,
      phone VARCHAR(30),
      email VARCHAR(255),
      members INT,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

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