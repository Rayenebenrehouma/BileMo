# BileMo
Projet numéro 7 de la formation PHP/Symfony d'Openclassrooms.

## Description du projet

Principales fonctionnalités disponibles demandées par le client:

  * consulter la liste des produits BileMo ;
  * consulter les détails d’un produit BileMo ;
  * consulter la liste des utilisateurs inscrits liés à un client sur le site web ;
  * consulter les détails d’un utilisateur inscrit lié à un client ;
  * ajouter un nouvel utilisateur lié à un client ;
  * supprimer un utilisateur ajouté par un client.
  
## Environnement utilisé durant le développement
* Symfony 6
* Composer 2.5.4
* WampServer 3.3.0
* PHP 8.2.0

## Informations sur l'API
* L'obtention du token afin de s'authentifier à l'API se fait via l'envoie des identifiants sur l'URI /api/login_check
* Toutes les routes indiquées dans la documentation nécéssite un token pour pouvoir y accéder

## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```
    git clone https://github.com/Rayenebenrehouma/BileMo.git
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier `.env.local` qui devra être crée à la racine du projet en réalisant une copie du fichier `.env`.

3. Téléchargez et installez les dépendances du projet avec composer:
```
    composer install
```
4. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```
    php bin/console doctrine:database:create
```
5. Créez les différentes tables de la base de données en appliquant les migrations :
```
    php bin/console doctrine:migrations:migrate
```

6. Générez une clef secrête et publique pour l'authentification JWT
...
    mkdir config\jwt
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa _keygen_bits:4096
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem  -pubout
...
7. Installez les fixtures pour avoir une démo de données fictives :
```
    php bin/console doctrine:fixtures:load
```
8. Le projet est maintenant installé, en lancant le projet avec "symfony serve" vous pouvez consultez la doc avec la route "/api/doc" .  
