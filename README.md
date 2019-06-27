# PA Plasma

## Setup

1. Add .env file in root folder for blackfire credentials : 
   ```
   ### --- BLACKFIRE ----
   BLACKFIRE_CLIENT_ID=YOUR_BLACKFIRE_SERVER_ID
   BLACKFIRE_CLIENT_TOKEN=YOUR_BLACKFIRE_SERVER_TOKEN
   BLACKFIRE_SERVER_ID=YOUR_BLACKFIRE_CLIENT_ID
   BLACKFIRE_SERVER_TOKEN=YOUR_BLACKFIRE_CLIENT_TOKEN
   ```
2. run `$ docker-compose up -d` to lunch docker containers
3. Then go into the `/public/` folder
4. Lunch `$ composer install` to install depedencies
5. Lunch `$ php bin/console d:d:c` then `$ php bin/console d:s:u --force` to create the database and populate it
6. Lunch `$ php bin/console doctrine:fixtures:load` then `yen` to lunch fixtures
7. Lunch `$ yarn encore dev` to compile js and scss
7. Run the application `$ php bin/console server:run` and go on http://127.0.0.1:8000
8. Access to all accounts, for example `admin@plasma.fr with the passord `admin123``