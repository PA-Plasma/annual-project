# PA Plasma

## Setup

1. Add .env file in root folder for blackfire credentials : 
   ```
   ### --- DATABASE ----
   POSTGRES_USER=plasuser
   POSTGRES_PASSWORD=plassword
   POSTGRES_DB=plasma
   
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
6. Lunch `$ yarn install` to install yarn
7. Lunch `$ yarn encore dev` to compile js and scss
8. Lunch `$ php bin/console doctrine:fixtures:load` then `yen` to lunch fixtures
Bonus : Lunch `$ php bin/console d:d:d --force && php bin/console d:d:c && php bin/console d:s:u --force && yarn install && yarn encore dev && php bin/console d:f:l` to do all the job.
9. Run the application `$ php bin/console server:run` and go on http://127.0.0.1:8000
10. Access to all accounts, for example `admin@plasma.fr with the passord `admin123``