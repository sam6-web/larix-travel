# Création d'un espace membre sur Symfony 4

### 1) installer les dépendances

    composer install

### 2) créer la base de données, mettre à jour le schéma

modifier vos informations de connexion à la BDD en modifiant .env puis, en ligne de commande:
    
    bin/console doctrine:database:create

### 3) Charger les fixtures

    bin/console doctrine:fixtures:load

Il y a 3 utilisateurs initialisés grâce aux fixtures. un user actif, un user inactif et 1 admin.

##### a) user actif
username: user_enabled  
email: user_enabled@test.fr  
password: test   
isActive: true 
roles: ROLE_USER  

##### b) user inactif
username: user_disabled  
email: user_disabled@test.fr  
password: test  
isActive: false  
roles: ROLE_USER  

##### c) admin
username: admin  
email: admin@test.fr  
password: test  
isActive: true  
roles: ROLE_ADMIN, ROLE_USER  

### 4) configurer swiftmailer

Si vous voulez tester la réinitialisation du mot de passe, il vous faut renseigner le paramètre MAILER_URL présent dans le fichier .env à la racine du projet.

### 5) lancer le serveur
    bin/console server:start



