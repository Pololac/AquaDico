
# AquaDico

A web application made for aquarium lovers where they can find information about tropical fish. One of its goals is to help them find the fish that belong to the same ecosystems in order to give them living conditions similar to those in their natural environment. For example, African cichlids thrive in fairly alkaline water with a basic pH, while South American dwarf cichlids prefer soft water with an acidic pH.







## Tech Stack

    1. Symfony
    2. Main Symfony bundles : 
        - Profiler
        - Maker
        - Security
        - Reset Password
        - Doctrine
        - Faker
        - EasyAdmin
        - VichUploader
        - Tailwind
        - Flowbite (dont thème @TalesFromADev for forms)


## Features

* User can view a list of over 50 fish.
* User can view the maintenance parameters of each fish.
* User can search fish by the specie's name.
* User can filter fish that belong to a given family (e.g. Cichlids), their continent of origin or their maintenance parameters.
* User can add sheets of unreferenced fish if connected.
* User can add/remove fish to/from a favorites list.


## Run Locally

#### Clone the project

```bash
  git clone https://github.com/Pololac/hb-r6-sf-aqua
```

#### Go to the project directory

```bash
  cd my-project
```

#### Install dependencies

```bash
  composer install
```

#### Configuring Database Access
To configure database access, we need to define your own DATABASE_URL as an environment variable in a .env.local file.

#### Creating Your Database
Once access is configured in the environment variables, the next step is to create the database that will hold our structure:

```bash
  php bin/console d:d:c
```
#### Connection
This step also allows us to verify that the credentials provided in the environment variable are correct, ensuring that the application can successfully connect to the MySQL server.

#### Running Migrations
After the database is created, Doctrine needs to set up its structure: the tables and the relationships between them. 

If you have cloned the project, the migrations are most likely already available in the migrations folder. You can directly execute them:

```bash
  php bin/console d:d:c
```

#### Loading Test Data (Fixtures)
Finally, once the database is created and the structure is in place, you have to import test data: the fixtures. They have been generated with the bundle Faker.

Like the migrations, the fixtures are likely already part of the codebase, so you can execute them directly:

```bash
    php bin/console d:f:l
```


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file :

`DATABASE_URL`

`MAILER_DSN`


## Development explanations


#### Slug for FishFamily & Origin
1. Added a "slug" property to my entity.
2. Type-hinted the SluggerInterface in the constructor of my AppFixture entity (Fakear) to generate the slug from the family name.
3. Used the {slug} in routes: added the name of the concerned entity after /fishes/ to avoid issues caused by similarities with the /fishes/{id} route.

Note: The automatic slug function "public function setSlugValue(SluggerInterface $slugger)" should be disabled during development because it is incompatible with Fixture generation using Fakear.


#### Fonctions de recherche



### Ajout d'un formulaire de Registration & Login 
#### Login
* Injection du service de hachage de mot de passe dans la classe AppFixtures en type-hintant l'interface du PasswordHasher directement dans le constructeur.
* Création d'un formulaire de login via la commande `make:security:form-login`

#### Registration
* Ajout de la propriété $isVerified à l'entité User, utilisée pour indiquer que l'utilisateur a bien confirmé son adresse email via un email de confirmation (pass alors en "true"). Propriété non testée dans l'application actuelle.
* Les messages Flash n'étant pas pris en charge par Tailwind, je passe le message de succès d'enregistrement via un paramètre de la fonction redirectToRoute.

#### Reset Password
* Ajout de la fonctionnalité via SymfonyCastsResetPasswordBundle : `composer require symfonycasts/reset-password-bundle`
* Installation de la fonctionnalité via la commande : `php bin/console make:reset-password`


### Ajout d'un formulaire d'inscription à la newsletter 
* Création d'une entité et d'un controleur dédié
* Validation que l'email rentré est bien un email et est unique via des contraintes passées en attributs de la classe de l'entité
* Création d'un service applicatif d'envoi automatique d'email à l'enregistrement de l'email dans la base de données (via une classe NewsletterConfirmation dédiée, dans laquelle on injecte le MailerInterface) : vérification de l'envoi du mail via un serveur SMTP local MailTrap conteneurisé dans Docker.


### Sécurité & Autorisations
#### Formulaire d'ajout d'une fiche poisson
* Autorisé uniquement pour les utilisateurs connectés

* J'ai fait le choix d'ajouter des contraintes de validation directement dans le formulaire et non au niveau de l'entité pour signaler des problèmes de saisie à l'utilisateur le plus tôt possible :
    1. Contrainte "NotBlank" pour obliger l'utilisateur a renseigner tous les champs.
    2. Contraintes "Range" sur pH et Gh car ces valeurs sont forcément comprises respectivement entre 1 et 14 / 1 et 34.
    3. Ajout de contraintes Callback sur maxTemp, maxPh et maxGh pour définir des règles de validation personnalisées qui garantissent que les valeurs max rentrées sont supérieures aux valeurs min. Ces contraintes font appel à des méthodes définies plus loin, qui type-hintent l'interface ExecutionContextInterface qui permet d'ajouter des messages de violations de validation.

* Ajout de la fonction d'upload d'image pour illustrer la fiche

* Les nouveaux poissons ajoutés par les utilisateurs sont non visibles (paramètre booléen $isVisible false par défaut dans l'entité) : la fiche doit être validée par un administrateur avant d'être rendue visible.

* Testé avec succès avec le "Discus de Heckle'.


#### Dashboard de gestion
* Généré avec le bundle EasyAdmin
* Autorisé uniquement pour les utilisateurs ayant le rôle ADMIN.
* Menu accessible via le menu déroulant des comptes admin.
* Interface légèrement améliorée via l'ajout d'une fonction "public function configureCrud(): Crud"
* Les administrateurs peuvent modifier les fiches de poisson : ajout/modification/suppression.
* Ils peuvent aussi modifier les noms de familles de poissons et les continents d'origine.

### Fonctionnalités restant à développer
1. Améliorer la sélection d'affichage des fiches qui ont un paramètre $isVisible = true : le tri mis en place est répétitif et fastidieux à implémenter dans tous mes requêtes.
2. Finaliser la fonction de reset de mot de passe.
3. Envoyer un email automatique aux administrateurs quand une nouvelle fiche est créée.
4. Résoudre le problème du menu dropdown des utilisateurs (nécessite de recharger la page pour fonctionner)
5. Toggle Dark Mode