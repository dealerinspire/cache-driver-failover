## Dealer Inspire - Cache Driver Failover

### Usage

Install the package:
```
composer require dealerinspire/cache-driver-failover
```

Register the service provider in `config/app.php`:
```
...
'providers' => [
    ...
    /*
    * Package Service Providers...
    */
    DealerInspire\AppCache\AppCacheProvider::class,
    ...
],
...
```

Publish the config:
```
php artisan vendor:publish --provider="DealerInspire\AppCache\AppCacheProvider"
```

Add the following .env variables:
```
APP_CACHE_DRIVER=redis
APP_REDIS_HOST=
APP_REDIS_PASSWORD=
APP_REDIS_PORT=6379
APP_REDIS_CACHE_DB=0
```

Use the package in your project:
```
public function __construct(AppCacheContract $cache)
{
    $this->cache = $cache;
}
```
Type-hint the `DealerInspire\AppCache\AppCacheContract` into your class to begin using.