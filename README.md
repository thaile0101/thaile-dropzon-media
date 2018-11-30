<h3 align="center"><img src="https://upload.wikimedia.org/wikipedia/vi/9/91/FC_Barcelona_logo.svg"></h3>

# Media Package for Laravel 5.5+ 



## Installation

1. Add a Composer dependency and install the package.

    ```bash
    composer require thaile/media
    ```
2. Edit config/app.php.
   ##### Add service providers
         
    ```bash
     \ThaiLe\Media\Providers\MediaServiceProvider::class,
     Intervention\Image\ImageServiceProvider::class,
    ```
    
    ##### And add class aliases
             
    ```bash
        'Image' => Intervention\Image\Facades\Image::class,
    ```
    
3. Publish the Media configuration and assets.

    ```bash
    php artisan vendor:publish --tag=media
    ```

    This will publish assets to `public/js`.

## Configuring Authentication

A basic middleware  that is `guest` or the `auth` :

```php
// config/media.php

$config['authentication'] = 'guest'
```

## Usage

Add route to routes/web.php
```php
Route::get('image/show', '\ThaiLe\Media\Controllers\MediaController@show');
```
