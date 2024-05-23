

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
]
```

### Publish the config

```
php artisan vendor:publish --provider="GohostAuth\Providers\AuthServiceProvider"
```

### Usage