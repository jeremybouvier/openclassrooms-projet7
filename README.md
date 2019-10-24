# API Bilemo

Réalisation d'un web service sous forme d'une API permettant de fournir un accés au catalogue de téléphone mobile de 
l'entreprise Bilemo. l'API gère aussi la liste des utilisateurs liée aux clients de l'API.
Le projet est basé sur Api plateform et inclu les différéents tests effectués sur l'API. Les données et la 
structure de la base de donnée du projet sont initialisées grâce à un script Composer.

### Prérequis

Pour pouvoir utiliser le projet vous aurez besoin de :

* [Mysql 14.14]
* [PHP >7.1]
* [Composer 1.8.5]

### Installation

Pour commencer placez vous dans le répertoire ou vous souhaiter installer le projet.


Télécharger le dossier du projet en faisant un :
```
$ git clone https://github.com/jeremybouvier/openclassrooms-projet7 Api_Bilemo
```
placez vous à la racine du projet  :
```
$ cd Api_Bilemo
```

Mettez a jour les dépendances composer en faisant un :
```
$ composer update

saisir ce token 101b13270da1e71fe325e55dfaf9bad879ede73f
```

Modifiez les paramètres d'accès à la base de donnée en remplaçant cette ligne dans le fichier .env présent à la racine du projet :
```
--> DATABASE_URL=mysql://root:root@127.0.0.1:3306/Bilemo
-----------------------------------------------------------------
--> DATABASE_URL=mysql://user:password@adress:port/Bilemo

```

Créer un nouveau dossier :
```
$ mkdir config/jwt
```

Créer une clé privé SLL pour l'API :
```
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
```
> Entrez un mot de passe pour l'encryption de la clé

Créer une clé public SLL pour l'API :
```
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
> Saisir a nouveau le mot de passe pour l'encryption de la clé

Modifiez le mot de passe d'authentification JWT dans le fichier .env présent à la racine du projet:
```
    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
--> JWT_PASSPHRASE=bilemo
-----------------------------------------------------------------
    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
--> JWT_PASSPHRASE= mot_de_passe_SSL

```

Placez vous dans le dossier Api_Bilemo et initialisez la base de donnée en faisant un :
```
$ composer initBD
```

## Documentation

 Veuillez consulter la [documentation](/swagger_docs.json) afin de connaitre les différentes requètes utilisables dans ce projet
 
## Lancement du projet

Placez vous dans le dossier public :
```
$ cd public
```

Puis lancer votre serveur php par la commande :
```
$ php -S localhost:8000 -ddisplay_errors=1
```
*Vous pouvez maintenant effectuer toutes les requètes que vous souhaitez vers l'API*
## Développé avec

* **Symfony 4.3** 
* **PHP 7.1.3**
* **Mysql 14.14**
* **Composer 1.8.5** 

## Versioning

Le versioning du projet a été effectué avec git version 2.7.4 , pour chaque étape du développement une branche a 
été créé et finalisé par un Pullrequest.

## Auteur

**Bouvier Jérémy** - Étudiant à Openclassrooms 
 Parcours suivi *Développeur d'application PHP/Symfony*
 
## Code Reviewer

**Boileau Thomas** - Mentor à Openclassrooms 

## Licence

Pas de licence enregistrée.
