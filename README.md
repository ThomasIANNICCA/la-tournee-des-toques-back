# Mise en place du repo Back

## Etapes à suivre

- Après avoir cloner le repo utiliser cette commande pour installer les différentes dépendances :

```bash
composer install
```

- Créer ensuite un fichier d'environnement local et y ajouter les informations concernant la BDD (nom utilisateur, mot de passe, nom de la BDD ainsi que sa version)

```bash
touch .env.local
echo "DATABASE_URL=mysql://{{nom_utilisateur}}:{{mdp_utilisateur}}@127.0.0.1:3306/{{nom_BDD}}?serverVersion={{version_BDD}}&charset=utf8mb4" > .env.local
```

- Créer la BDD et la remplir

```bash
bin/console doctrine:database:create
bin/console doctrine:migration:migrate
```

- Charger des fausses données

```bash
bin/console doctrine:fixture:load
```

- Générer la paire de clés des tokens JWT (securité)

```bash
 bin/console lexik:jwt:generate-keypair
```

- Lancer le serveur en local sur le port 8000

```bash
php -S localhost:8000 -t public
```

- Enjoy !!!
