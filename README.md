# User Stories

- [Installation](#installation)
- [Setting up 3rd-part Services](#setting-up-3rd-part-services)
  -[Mailtrap](#mailtrap)
- [Workflows](#workflows)
  -[Compiling assests](#compiling-assets)
- [Making Pull Requests](#making-pull-requests)

## Installation

Follow these steps to setup the development environment.

1. Clone the repo: `git clone git@github.com:Light-it-labs/user-stories.git user-stories`
1. Initialize git flow repository with default configs: `git flow init`
1. Create your environment config: `cp .env.example .env`
1. Install the Composer dependencies: `composer install`
1. Create a random application key: `php artisan key:generate`
1. Setup the storage: `php artisan storage:link`
1. [Setup required 3rd-party services](#setting-up-3rd-party-services)
1. Seed the database: `php artisan migrate:fresh --seed`
1. Create a personal access client: `php artisan passport:client --personal`
1. Setup laravel passport: `php artisan passport:install`
1. Install the NPM dependencies: `npm install`
1. Compile all assets: `npm run dev`

You’re done, checkout the app at <http://localhost:8000>.
## Setting up 3rd-party Services
### Mailtrap
Mailtrap is a fake SMTP server to test and view emails sent from the development environment.

-   Signup for a free account on [mailtrap.io](https://mailtrap.io)
-   Set your `MAIL_USERNAME` and `MAIL_PASSWORD` in your `.env` file

## Workflows

### Compiling assets

To continuously watch for file changes:

```
npm run watch
```

## Making Pull Requests

-   The development branch is `develop`
-   Use `git flow feature start name-of-feature` to create new branch