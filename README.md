# pokeApp Wordpress Backend

This project use Wordpress Version 5.3

## plugin/pokePlugin
Developed to expose the PokeApi.co through the WP-REST-API
```
/wp-json/pokeapi/v1/pokemon
/wp-json/pokeapi/v1/pokemon/1
```

## theme/pokeTheme
Developed to include `my_pokemon_ids` as new user metadata field


## Requirements 
Add the following lines into the `wp-config.php` file of wordpress
```php
define('JWT_AUTH_SECRET_KEY', 'secret_key');
define('JWT_AUTH_CORS_ENABLE', true);
```

Add the following lines into the `.htaccess` file of root folder
```
RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
```
