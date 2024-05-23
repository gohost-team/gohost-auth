

### Install package

Update composer.json file

```
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:gohost-team/gohost-auth.git"
        }
    ]
```

Install

```
composer require gohost/auth:dev-v1.0
```

### Add service provider

Add the service provider to the providers array in the config/app.php config file as follows:

```
'providers' => [

    ...

    GohostAuth\Providers\AuthServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
]
```

### Publish the config

```
php artisan vendor:publish --provider="GohostAuth\Providers\AuthServiceProvider"

php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

### Update User model

Add buildPermissions method

```
static public function buildPermissions()
{
    return [];
}
```

