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
        $this->app->bind(AppCacheContract::class, function (): AppCache {
            $cacheManager = $this->app->make('cache');
            $appCacheDriver = $this->app->make('config')->get('app_cache.driver');

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

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/app_cache.php',
        ], 'config');
    }

    public function provides(): array
    {
        return [
            AppCacheProvider::class
        ];
    }
}
