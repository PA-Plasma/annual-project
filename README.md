# PA Plasma

## ENV x Blackfire

Add .env file in root folder : 
```
### --- BLACKFIRE ----
BLACKFIRE_CLIENT_ID=YOUR_BLACKFIRE_SERVER_ID
BLACKFIRE_CLIENT_TOKEN=YOUR_BLACKFIRE_SERVER_TOKEN
BLACKFIRE_SERVER_ID=YOUR_BLACKFIRE_CLIENT_ID
BLACKFIRE_SERVER_TOKEN=YOUR_BLACKFIRE_CLIENT_TOKEN
```

## Webpack

`$ yarn encore dev`

## Fixtures

`$ php bin/console doctrine:fixtures:load` then "yes"