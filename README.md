
# AquaDico

A web application made for aquarium lovers where they can find information about tropical fish. One of its goals is to help them find the fish that belong to the same ecosystems in order to give them living conditions similar to those in their natural environment. For example, African cichlids thrive in fairly alkaline water with a basic pH, while South American dwarf cichlids prefer soft water with an acidic pH.







## Tech Stack

    1. Symfony
    2. Main Symfony bundles : 
        - Profiler
        - Maker
        - Security
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
Finally, once the database is created and the structure is in place, you have to import test data: the fixtures.

Like the migrations, the fixtures are likely already part of the codebase, so you can execute them directly:

```bash
    php bin/console d:f:l
```


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`API_KEY`

`ANOTHER_API_KEY`


## Development explanations

#### Formulaire d'ajout d'une fiche poisson

J'ai fait le choix d'ajouter des contraintes de validation directement dans le formulaire et non au niveau de l'entité pour signaler des problèmes de saisie à l'utilisateur le plus tôt possible :

    1. Contrainte "NotBlank" pour obliger l'utilisateur a renseigner tous les champs.
    2. Contraintes "Range" sur pH et Gh car ces valeurs sont forcément comprises respectivement entre 1 et 14 / 1 et 34.
    3. Ajout de contraintes Callback sur maxTemp, maxPh et maxGh pour définir des règles de validation personnalisées qui garantissent que les valeurs max rentrées sont supérieures aux valeurs min. Ces contraintes font appel à des méthodes définies plus loin, qui type-hintent l'interface ExecutionContextInterface qui permet d'ajouter des messages de violations de validation.