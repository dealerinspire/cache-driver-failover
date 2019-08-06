<?php
declare(strict_types=1);

namespace DealerInspire\AppCache\Tests;

use DealerInspire\AppCache\AppCacheContract;
use DealerInspire\AppCache\AppCacheProvider;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\FileStore;
use Orchestra\Testbench\TestCase;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Psr\Log\LoggerInterface;

class AppCacheProviderTest extends TestCase
{
    public function testProvides()
    {
        $systemUnderTest = new AppCacheProvider($this->app);
        $systemUnderTest->register();

        foreach ($systemUnderTest->provides() as $contract) {
            $this->assertInstanceOf(CacheContract::class, $this->app->make($contract));
        }
    }

    public function testFailover()
    {
        $provider = new AppCacheProvider($this->app);
        $provider->register();

        $log = \Mockery::mock(LoggerInterface::class);
        $this->app->instance(LoggerInterface::class, $log);

        // Set app cache driver to invalid so it must failover
        config(['cache.default' => 'file']);
        config(['cache.app_cache_driver' => 'invalid']);

        $log->shouldReceive('error')
            ->once()
            ->with('Application cache driver invalid unavailable, defaulting to file driver: Cache store [invalid] is not defined.');

        /** @var CacheContract $result */
        $result = $this->app->make(AppCacheContract::class);
        $this->assertInstanceOf(FileStore::class, $result->getStore());

        // Now set app cache driver as a valid driver
        config(['cache.default' => 'file']);
        config(['cache.app_cache_driver' => 'array']);

        /** @var CacheContract $result */
        $result = $this->app->make(AppCacheContract::class);
        $this->assertInstanceOf(ArrayStore::class, $result->getStore());
    }
}
