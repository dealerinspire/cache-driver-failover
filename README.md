## Dealer Inspire - Cache Driver Failover

### Usage

Install the package:
```
composer require dealerinspire/cache-driver-failover
```

Register the service provider in `config/app.php`:
```php
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
```php
...
'app_cache_driver' => 'value',
...
```

Add the following .env variables:
```bash
APP_CACHE_DRIVER=redis
APP_REDIS_HOST=
APP_REDIS_PASSWORD=
APP_REDIS_PORT=6379
APP_REDIS_CACHE_DB=0
```

Use the package in your project:
```php
public function __construct(AppCacheContract $cache)
{
    $this->cache = $cache;
}
```
Type-hint the `DealerInspire\AppCache\AppCacheContract` into your class to begin using.

### Laravel Notes

If you are on a version of Laravel lower than 5.8 the cache duration constants in `AppCacheContract`
will not be accurate. Larave versions less than 5.8 use cache duration values of minutes. In Laravel 5.8,
cache duration was changed to use seconds, which is the format that this package follows. Please keep
this in mind as you're implementing this package and be wary of the constants on Laravel <5.8.
