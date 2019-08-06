<?php
declare(strict_types=1);

namespace DealerInspire\AppCache;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class AppCacheProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/cache.php', 'cache'
        );

        $this->app->bind(AppCacheContract::class, function (): AppCache {
            $cacheManager = $this->app->make('cache');
            $appCacheDriver = $this->app->make('config')->get('cache.app_cache_driver');

            try {
                $appCache = $cacheManager->driver($appCacheDriver);
                $appCache->has('test');
                return new AppCache($appCache);
            } catch (\Exception $e) {
                $log = $this->app->make(LoggerInterface::class);

                $defaultDriver = $cacheManager->getDefaultDriver();
                $default = $cacheManager->driver($defaultDriver);

                $log->error(sprintf('Application cache driver %s unavailable, defaulting to %s driver: %s', $appCacheDriver, $defaultDriver, $e->getMessage()));

                return new AppCache($default);
            }
        });
    }

    public function provides(): array
    {
        return [
            AppCacheContract::class
        ];
    }
}
