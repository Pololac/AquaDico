
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

### Slug for FishFamily & Origin
1. Added a "slug" property to my entity.
2. Type-hint the SluggerInterface in the constructor of my AppFixture entity (Fakear) to generate the slug from the family name.
3. Used the {slug} in routes: added the name of the concerned entity after fishes/ to avoid issues caused by similarities with the fishes/{id} route.

Note: The automatic slug function "setSlugValue(SluggerInterface $slugger)" should be disabled during development because it is incompatible with Fixture generation using Fakear.


### Search Functions
The site only displays entries with the parameter `$isVisible = true` (generally, all entries validated by the administrators).

#### By Name
* Function available only on the main page.

#### By Families or Origins
* Option to directly view all entries of fish belonging to a given family or originating from a given continent.
* Addition of a feature that displays the number of entries in each category in the sorting menu.

#### By Maintenance Criteria
* Ability to select fish based on temperature, pH or hardness ranges, as well as their adult size.
* Option to select a range for each parameter: the selected fish have minimum and maximum parameters within this range.
* Addition of a button to easily reset parameters.

### Addition of Registration & Login Form 
#### Login
* Injection of the password hashing service into the `AppFixtures` class by type-hinting the `PasswordHasher` interface directly in the constructor.
* Creation of a login form using the command `make:security:form-login`.

#### Registration
* Addition of the `$isVerified` property to the `User` entity, used to indicate that the user has confirmed their email address via a confirmation email (then set to "true"). Property not tested in the current application.
* Since Flash messages are not supported by Tailwind, the registration success message is passed via a parameter of the `redirectToRoute` function.

#### Reset Password
* Addition of the feature via SymfonyCastsResetPasswordBundle: `composer require symfonycasts/reset-password-bundle`.
* Installation of the feature using the command: `php bin/console make:reset-password`.

### Addition of a Newsletter Subscription Form 
* Creation of a dedicated entity and controller.
* Validation that the entered email is indeed an email and is unique via constraints set as attributes of the entity class.
* Creation of an application service for automatically sending an email upon saving the email in the database (via a dedicated `NewsletterConfirmation` class, where the `MailerInterface` is injected): verification of email sending through a local MailTrap SMTP server containerized in Docker.

### Security & Authorizations
#### Fish Entry Submission Form
* Allowed only for logged-in users.
* I chose to add validation constraints directly in the form rather than at the entity level to notify the user of input issues as early as possible:
    1. `NotBlank` constraint to require the user to fill in all fields.
    2. `Range` constraints on pH and Gh since these values must necessarily be between 1 and 14 / 1 and 34, respectively.
    3. Addition of Callback constraints on `maxTemp`, `maxPh`, and `maxGh` to define custom validation rules that ensure the entered max values are greater than the min values. These constraints call methods defined later, which type-hint the `ExecutionContextInterface` that allows adding validation violation messages.
* Addition of an image upload function to illustrate the entry.

* New fish added by users are not visible (boolean parameter `$isVisible` false by default in the entity): the entry must be validated by an administrator before being made visible.

* Successfully tested with the "Heckel Discus."

#### Management Dashboard
* Generated with the EasyAdmin bundle.
* Allowed only for users with the `ADMIN` role.
* Accessible via the admin account dropdown menu.
* Interface slightly improved by adding a public function `configureCrud(): Crud`.
* Administrators can modify fish entries: add/modify/delete.
* They can also edit fish family names and origin continents.

### Features Remaining to be Developed
1. Improve the selection of entries with the `$isVisible = true` parameter: the sorting currently in place is repetitive and tedious to implement in all my queries. It may be necessary to use an "EventListener" that activates when the data to be displayed loads on the page.
2. Finalize the password reset function.
3. Send an automatic email to administrators when a new entry is created.
4. Find a sustainable solution to the problem of displaying Flash messages with Tailwind.
5. Resolve the issue with the user dropdown menu: apparently related to poor JS handling in the current project.
