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
3. configre a database in the .env file
4. run the migrations
    ```sh
    php artisan migrate
    ```
5. install npm packages and build assets
   ```sh
   npm install && npm run build
   ```
6. run the app
   ```sh
   php artisan serve
   ```
7. you now can access the app from you browser at `http://localhost:8000`


## Features
- you can start the scraper and scrape single book or number of pages of books from the terminal by running the following
```sh
php artisan scrape:books {url} --pages={number of pages to scrape}
```