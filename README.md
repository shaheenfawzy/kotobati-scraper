# Kotobati Scraper

## Installing and configuring the app.  

Please make sure that you have at least php version 8.1  and nodejs installed.

1. clone this repo
    ```sh
    git clone https://github.com/shaheenfawzy/kotobati-scraper
    ```
2. run the following to install the dependencies 
    ```sh
    composer install
    ```
3. copy .env.example to .env and the configure the database credentials
   ```sh
   cp .env.example .env
   ```
4. generate application encryption key
   ```sh
   php artisan key:generate
   ```
5. run the migrations
    ```sh
    php artisan migrate
    ```
6. install npm packages and build assets
   ```sh
   npm install && npm run build
   ```
7. run the app
   ```sh
   php artisan serve
   ```
8. you now can access the app from you browser at `http://localhost:8000`


## Features
- you can start the scraper and scrape single book or number of pages of books from the terminal by running the following
```sh
php artisan scrape:books {url} --pages={number of pages to scrape}
```
