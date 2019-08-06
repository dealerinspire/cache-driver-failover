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

Configuration:

You do not need to publish a configuration for this package. The app_cache configuration
automatically merged into your `config/cache.php` configuration. If you wish to change the
`app_cache_driver` configuration, simply add the following to your `config/cache.php`:
```
...
'app_cache_driver' => 'value',
...
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

### Laravel Notes

If you are using Laravel <5.8 as your framework, you will NOT be able to use the cache duration
constants in `AppCacheContract`. These cache durations are in **minutes**. Versions <5.8 will use
cache duration in **seconds**. Please keep this in mind as you're implementing this package.