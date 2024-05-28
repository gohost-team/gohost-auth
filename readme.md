

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
composer require gohost/auth:v0.2
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

### Update database table

```
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();

    $table->string('gh_id')->unique();
    $table->boolean('is_active')->default(false);
    $table->string('type');
    $table->json('permissions')->nullable();    

    $table->string('status', 10)->index();
    $table->string('active_token', 64)->nullable()->index();
});
```

### Updte config/auth.php file

```
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'platform' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],
```

### Update User model

Add buildPermissions method

```
use GohostAuth\Models\User as BaseUser;
use GohostAuth\Models\Contracts\HasPermissions;

class User extends BaseUser implements HasPermissions {

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'is_active',        
        'permissions'
    ];

    ....

    static public function buildPermissions()
    {
        return [];
    }
}
```

### Usage

Add midleware to authenticate logged user

```
GohostAuth\Http\Middleware\UserFromCookie::class
```