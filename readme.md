# CSE CU Forum

CSE CU Forum is a blog-post or forum based website where people can post about different affairs of the CSE network of University of Chittagong in order to spread knowledge and ask for any doubt for any particular problem.

## Getting Started

### Prerequisites

You need to have the following instruments installed on your pc in order to run this app. Please check some youtube tutorials on how to install them and use them for laravel projects.

* [XAMPP](https://www.apachefriends.org/index.html)
* [Git for windows](https://git-scm.com/download/win) or [GitHub Desktop](https://desktop.github.com/)
* [Nodejs](https://nodejs.org/en/)
* [Composer](https://getcomposer.org/)

### Installing

Follow the instructions step by step in order to install this web application in your computer:

* Create a database in MySQL.
* Clone this project by typing this command.

```
git clone https://github.com/magenia/cse-cu-forum.git
```

* Copy `.env.example` and paste it in the same directory by renaming `.env`.
* Enter the database name in `DB_DATABASE`, db username and password in `DB_USERNAME` and `DB_PASSWORD` respectively. If you are using XAMPP, then db username is `root` and the password field is left blank as there is no password in the default.
* Edit the following information to setup email in `.env` file.

```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=your_email_account
MAIL_PASSWORD=your_email_app_password
MAIL_ENCRYPTION=ssl
```

*Note: [Click here](https://support.google.com/mail/answer/185833?hl=en) to know about generating a google mail app password.*

* Enter the following API keys and secrets in `.env` file.

```
EDITOR_API_KEY=your_tiny_mce_editor_api_key
MIX_EDITOR_API_KEY="${EDITOR_API_KEY}"
```

and

```
ALGOLIA_APP_ID=your_algolia_app_id
ALGOLIA_SECRET=your_algolia_admin_api_key
```

* Enter the following command in the console (the directory must be in the same directory where the `.env` file is situated in)

```
composer install
```

and

```
npm install
```

* After finishing the installation, enter the following command in the console

```
php artisan migrate
```

* Install passport.

```
php artisan passport:install
```

* After installation, enter the following command.

```
npm run prod
```


## Deployment

Run the following command to display the website.

```
php artisan serve
```

* Most generally the location of the website is `localhost:8000`.

## Built With

* [Laravel](http://www.dropwizard.io/1.0.2/docs/) - The web framework used.
* [Reactjs](https://maven.apache.org/) - Javascript framework used in the frontend section.
* [Vuejs](https://rometools.github.io/rome/) - Javascript framework used in admin panel section.
