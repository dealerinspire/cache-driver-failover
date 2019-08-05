<?php
declare(strict_types=1);

namespace DealerInspire\AppCache;

use Illuminate\Contracts\Cache\Repository as CacheContract;

interface AppCacheContract extends CacheContract
{
    public const CACHE_DURATION_1_HOUR = 3600;
    public const CACHE_DURATION_4_HOURS = 14400;
    public const CACHE_DURATION_12_HOURS = 43200;
    public const CACHE_DURATION_24_HOURS = 86400;

    public function tags(array $tags);
}