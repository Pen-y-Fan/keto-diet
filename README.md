# Keto diet

This project concept is to design and build a small website which will record daily information about a keto diet. Based on
MyFitnessPall, except much simpler and therefore easy to use. Accessible from any web connected device.
[Filament PHP](https://filamentphp.com/) is used for the admin dashboard and authentication.

The main features are:

- calories and carbs (only)
    - breakfast / lunch / dinner / snacks / water
- weight
    - target weight
- graphs
    - daily calories and weight

## Local installation

### Requirements

This is a Laravel 9 project. The requirements are the same as a
new [Laravel 9 project](https://laravel.com/docs/9.x/installation).

- [8.0+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org)

Recommended:

- [Git](https://git-scm.com/downloads)

### Clone

See [Cloning a repository](https://help.github.com/en/articles/cloning-a-repository) for details on how to create a
local copy of this project on your computer.

e.g.

```sh
clone git@github.com:Pen-y-Fan/keto-diet.git
```

### Install

Install all the dependencies using composer

```sh
cd keto-diet
composer install
```

### Create .env

Create an `.env` file from `.env.example`

```shell script
cp .env.example .env
```

### Generate APP_KEY

Generate an APP_KEY using the artisan command

```shell script
php artisan key:generate
```

### Configure Laravel

Laravel is compatible with different database servers, MySQL is given as an example setup here, but there should be no
reason why this app wouldn't work on other Laravel supported SQL servers. I have not tested with other SQL servers.

This app uses migrations to generate the tables for the database. Tests will use factories for data. Configure the
Laravel **.env** file with the **database**, updating **username** and **password** as per you local setup.

```text
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=keto_diet
DB_USERNAME=YourDatabaseUserName
DB_PASSWORD=YourDatabaseUserPassword
```

### Create the database

The database will need to be manually created e.g. using MySQL:

```shell
mysql -u YourDatabaseUserName
CREATE DATABASE keto_diet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit
```

### Migrate

```shell
php artisan migrate
```

## Jetstream

The Laravel Jetstream starter package has been installed which includes Livewire and Tailwind. This provides the
authentication for this package.

### Initial install

The first time the project is cloned the node packages will need to be installed

```shell
npm install
```

### dev watch

To develop the package run the watcher

```shell
npm run watch
```

## Tooling

Development tooling has been provided to keep the package to a high standard, including tests, code standard (PSR-12 + 
other standards), static analysis. Other tools like IDE helper help with auto-completion and debug bar helps identify 
problems like N+1 issues and which route or blade is being using.

### Code standard

Easy Coding Standard (ECS) is used to check for style and code standards, [PSR-12](https://www.php-fig.org/psr/psr-12/)
is used. Regularly run code standard checks to automatically clean up your code. In particular run before committing any
code.

To make it easy to run Easy Coding Standard (ECS) a composer script has been created in **composer.json**. From the root
of the projects, run:

```shell script
composer check-cs
```

You should see the results:

```text
                                                                                                                        
 [OK] No errors found. Great job - your code is shiny in style!                                                         
                                                                                                                        
```

If there are any warning, ECS will advise you to run --fix to fix them, this also has a composer script:

```shell
composer fix-cs
```

Sometimes the fix command needs to be run several times, as one fix will identify more problems, keep running the fix-cs
until you get the OK message.

### Static analysis

PhpStan is used to run static analysis checks. Larastan has been installed, which is PhpStan and Laravel rules.
Regularly run static analysis checks to help identify problems. In particular run before committing any code.

To make it easy to run PhpStan a composer script has been created in **composer.json**. From the root of the projects,
run:

```shell script
composer check-cs
```

You should see the results:

```text
                                                                                                                        
 [OK] No errors                                                                                                         

```

If PhpStan identifies any problems then review and fix them one by one.

### Commit hook

[GrumPHP](https://github.com/phpro/grumphp) has been installed and configured to run a pre-commit hook, when you
`git commit` any code ECS, PhpStan and PHPUnit will be automatically run, if any of these fail the commit will be
rejected. You can always write a rule to bypass the failing code, but it is better to fix the problem.

### Run tests

To make it easy to run all the PHPUnit tests a composer script has been created in **composer.json**. From the root of
the projects, run:

```shell script
composer tests
```

You should see the results in testDoc format:

```text
PHPUnit 9.5.13 by Sebastian Bergmann and contributors.
> phpunit --testdox

Example (Tests\Unit\Example)
 ✔ That true is true

Api Token Permissions (Tests\Feature\ApiTokenPermissions)
 ↩ Api token permissions can be updated

Authentication (Tests\Feature\Authentication)
 ✔ Login screen can be rendered
 ✔ Users can authenticate using the login screen
 ✔ Users can not authenticate with invalid password

....

Registration (Tests\Feature\Registration)
 ↩ Registration screen cannot be rendered if support is disabled
OK, but incomplete, skipped, or risky tests!
Tests: 53, Assertions: 142, Skipped: 7.
```

### Automatic PHPDocs

To help IDE autocompletion automatic PHPDocs for models are created using barryvdh/laravel-ide-helper, which has been 
installed to help with IDE auto-completion, when new models are created run the following to auto generate doc blocks 
for all the models: 

```shell
php artisan ide-helper:models -W
```

Or for one specific model:

```shell
php artisan ide-helper:models -W "App\Models\Post" 
```

## Filament admin

The [Filament admin](https://filamentphp.com/) has been installed to all the data in all the models. To access the 
Filament dashboard you will need to create a filament user:

```shell
php artisan make:filament-user
```

The user is currently hard coded in the **User** model to:

```shell
name: any name
email: admin@example.com
password: your password
```

Once created navigate to: /admin and login. You will see the admin portal.

## Contributing

This is a **personal project**. Contributions are **not** required. Anyone interested in developing this project are
welcome to fork or clone for your own use.

## Credits

- [Michael Pritchard \(AKA Pen-y-Fan\)](https://github.com/pen-y-fan).

## License

MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## TODO

- [x] Install tooling
    - [x] Commit hook (GrumPHP)
    - [x] Linting (Parallel Lint)
    - [x] Static analysis (Larastan)
    - [x] Code standard (ECS)
    - [x] IDE Helper
    - [x] Debugbar
    - [x] .editorconfig
- [x] Install Filament admin
- [x] Install Jetstream and Livewire
- [ ] App outline, a user can: 
    - [x] view a daily diary
    - [x] add food to a meal
    - [x] view their meals (daily diary)
    - [x] view a graph of their calories (dashboard)
    - [x] edit their food
    - [x] delete their food
    - [ ] set their weight goal
    - [ ] set their Keto daily requirements (calories)
    - [ ] enter their weight
    - [ ] view a graph of their weight with goal
    - [ ] view a dashboard with useful information and graphs

## Seeder

To seed 10 foods today for user 1 run:

```shell
php artisan db:seed --class=FoodSeeder
```
