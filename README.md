## INSTALLATION SYMFONY

```
cd chemin_vers_le_dossier_htdocs/www
```
```
 nom_du_projet
```

## GIT / GITHUB

### Initialiser le projet (au dépôt)

Initialiser un dépôt :
```
git init
```
Relier au dépôt distant (GitHub) :
```
git remote add origin https://lien_vers_le_dépôt_GitHub
```

### Ajouter des nouveaux fichiers

Ajouter les fichiers :
```
git add *
```
Nommer le commit :
```
git commit -m "le_nom_du_commit_ici"
```
Envoyer les fichiers :
```
git push origin master
```

## APACHE-PACK

- barre de débug / routing :
```
composer require symfony/apache-pack
```

## CRÉER UN CONTRÔLEUR

```
php bin/console make:controller
```

## VIDER LE CACHE

```
php bin/console cache:clear
```

## AFFICHER LES ROUTES

```
php bin/console debug:router
```

## VARIABLES GLOBALES

- fichier config/packages/twig.yaml :
```
twig:
    ...
    globals:
        copyright: '%app.copyright%'
```

- fichier config/services.yaml :
```
parameters:
    app.copyright: 'Copyright &copy; 2020 | BNB'
```

- utilisation (dans les templates) :
```
{{ copyright|raw }}
```

## BASE DE DONNÉES

- dans le fichier .env :
DATABASE_URL=mysql://identifiant:mot_de_passe@127.0.0.1:3306/nom_de_la_base?serverVersion=5.7

- créer la base :
```
php bin/console doctrine:database:create
```

- créer une table (entité) :
```
php bin/console make:entity
```

- on vérifie le(s) fichier(s) créé(s)

- migration :
```
php bin/console make:migration
```
```
php bin/console doctrine:migrations:migrate
```

- ajouter une colonne à une table :
```
php bin/console make:entity
```
(puis mettre le nom d'une table exitante)

## FIXTURES

- installer le package :
```
composer require --dev orm-fixtures
```

- remplir le fichier src/DataFixtures/AppFixtures.php

- charger les données en bdd en purgeant la base :
```
php bin/console doctrine:fixtures:load
```

- charger les données en bdd à la suite :
```
php bin/console doctrine:fixtures:load --append
```

- quand on en a terminé avec les fixtures, renommer le fichier utilisé (en ajoutant ~devant)

## FORMULAIRES

```
composer require symfony/form
```
```
php bin/console make:form
```

- entrer le nom du formulaire
- entrer le nom de la classe associée

- thème Bootstrap pour les formulaires : dans config/packages/twig.yaml, ajouter :
```
form_themes: ['bootstrap_4_layout.html.twig']
```

## LOGIN

- créer une entité user :
```
php bin/console make:user
```
- puis migration

- créer la connexion
```
php bin/console make:auth
```

- créer la page d'inscription :
```
php bin/console make:registration-form
```

## REGISTER

- installer Rollerworks :
```
composer require rollerworks/password-strength-bundle
```

- dans RegistrationFormType.php, modifier les contraintes en utilisant minLength et minStrength pour le mot de passe

## SÉCURITÉ

- bloquer l'accès aux pages admin, dans config/packages/security.yaml, décommenter :
```
- { path: ^/admin, roles: ROLE_ADMIN }
```

- ajouter un rôle, gérer la hiérarchie, dans security.yaml :
```
role_hierarchy:
        ROLE_ADMIN: ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN
```

- bloquer un accès dans un template :
```
{% if is_granted('ROLE_SUPER_ADMIN') %}
```

## RÉCUPÉRER UN PROJET EXISTANT

- dans htdocs (ou www) : créer un nouveau dossier pour accueillir le projet, puis :
```
git init
```
```
git remote add origin https://l'url_du_projet_a_recuperer
```
```
git pull origin master (il existe d'autres possibilités telles que clone etc...)
```

- bien vérifier la présence du fichier .env, puis :
```
composer update
```
(il se peut qu'il y ait des erreurs indiquant qu'il manque web-profiler, dans ce cas, l'ajouter dans le fichier composer.json)

- recréer la base de données :
```
php bin/console doctrine:database:create
```

- recréer les tables :
```
php bin/console doctrine:migrations:migrate
```

- recréer des données (si présence d'un fichier fixtures) :
```
php bin/console doctrine:fixtures:load
```

## EASYADMIN

- installation :
```
composer require easycorp/easyadmin-bundle
```

- créer le dashboard (panel admin) :
```
php bin/console make:admin:dashboard
```

- créer les CRUD's :
```
php bin/console make:admin:crud
```
- puis choisir une entité (chiffre), le dossier où le créer

- ajouter les "crud" au panel admin dans DashboardController (linkToCrud)

## PAGES D'ERREUR

- erreurs communes :
    - 1xx : informations
    - 2xx : succès
        - 200 : ok
        - 202 : requête traitée
    - 3xx : redirection
        - 307 : redirection temporaire
        - 308 : redirection permanente
        - 310 : trop de redirections
    - 4xx : erreurs client web
        - 400 : mauvaise syntaxe
        - 403 : accès interdit
        - 404 : non trouvé
        - 408 : temps d'attente trop long
    - 5xx : erreurs serveur
        - 500 : erreur interne
        - 503 : service indosponible ou en maitnenance

- installation synfony/twig-pack :
```
composer require symfony/twig-pack
```

- créer l'arborescence templates/bundles/TwigBundle/Exception

- c'est dans ce dossier qu'iront les fichiers :
    - error403.html.twig
    - error404.html.twig
    - error.html.twig (erreur générique)

## EMAILS

- installer SwiftMailer :
```
composer require symfony/swiftmailer-bundle
```

- dans .env, ligne 39 (poutr Gmail) :
```
MAILER_URL=gmail://david.hurtrel@gmail.com:password@localhost
```

- créer la page contact et le formulaire :
```
php bin/console make:controller
php bin/console make:form
```

- créer le template de mail (email.html.twig)

- intercepter le message avant redirection : config/packages/dev/web_profiler.yaml, ligne 3 :
```
intercept_redirects: true
```

- autres options :
    - config/packages/dev/swiftmailer.yaml (pour autoriser certaines adresses mail) :
    ```
    delivery_addresses: ['david@hurtrel.com']
    ```
    - congig/packages/test/swiftmailer.yaml (bloquer les envois de mail en test) :
    ```
    disable_delivery: true
    ```