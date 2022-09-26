<?php
declare(strict_types=1);

namespace DealerInspire\AppCache;

use Closure;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Contracts\Cache\Store;
use Psr\SimpleCache\InvalidArgumentException;

class AppCache implements AppCacheContract
{

    public function __construct(protected CacheContract $cache) {}

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     *
     * @param string $key The key of the item to store.
     * @param mixed $value The value of the item to store, must be serializable.
     * @param null|int|\DateInterval $ttl Optional. The TTL value of this item. If no value is sent and
     *                                      the driver supports TTL then the library may set a default value
     *                                      for it or let the driver take care of that.
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @throws InvalidArgumentException
     */
    public function set($key, $value, $ttl = null): bool
    {
        return $this->cache->set($key, $value, $ttl);
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string $key The unique cache key of the item to delete.
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @throws InvalidArgumentException
     */
    public function delete($key): bool
    {
        return $this->cache->delete($key);
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function clear(): bool
    {
        return $this->cache->clear();
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys A list of keys that can obtained in a single operation.
     * @param mixed $default Default value to return for keys that do not exist.
     * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @throws InvalidArgumentException
     */
    public function getMultiple($keys, $default = null): iterable
    {
        return $this->cache->getMultiple($keys, $default);
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable $values A list of key => value pairs for a multiple-set operation.
     * @param null|int|\DateInterval $ttl Optional. The TTL value of this item. If no value is sent and
     *                                       the driver supports TTL then the library may set a default value
     *                                       for it or let the driver take care of that.
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @throws InvalidArgumentException
     */
    public function setMultiple($values, $ttl = null): bool
    {
        return $this->cache->setMultiple($values, $ttl);
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys A list of string-based keys to be deleted.
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @throws InvalidArgumentException
     */
    public function deleteMultiple($keys): bool
    {
        return $this->cache->deleteMultiple($keys);
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param string $key
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @throws InvalidArgumentException
     */
    public function has($key): bool
    {
        return $this->cache->has($key);
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @throws InvalidArgumentException
     */
    public function get($key, $default = null): mixed
    {
        return $this->cache->get($key, $default);
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function pull($key, $default = null): mixed
    {
        return $this->cache->pull($key, $default);
    }

    /**
     * Store an item in the cache.
     *
     * @param string $key
     * @param mixed $value
     * @param \DateTimeInterface|\DateInterval|float|int $ttl
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function put($key, $value, $ttl = null): void
    {
        $this->cache->put($key, $value, $ttl);
    }

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param string $key
     * @param mixed $value
     * @param \DateTimeInterface|\DateInterval|float|int $ttl
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function add($key, $value, $ttl = null): bool
    {
        return $this->cache->add($key, $value, $ttl);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param string $key
     * @param mixed $value
     * @return int|bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function increment($key, $value = 1): int|bool
    {
        return $this->cache->increment($key, $value);
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param string $key
     * @param mixed $value
     * @return int|bool
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function decrement($key, $value = 1): bool|int
    {
        return $this->cache->decrement($key, $value);
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param string $key
     * @param mixed $value
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function forever($key, mixed $value): void
    {
        $this->cache->forever($key, $value);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param string $key
     * @param \DateTimeInterface|\DateInterval|float|int $ttl
     * @param Closure $callback
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function remember($key, $ttl, Closure $callback): mixed
    {
        return $this->cache->remember($key, $ttl, $callback);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param string $key
     * @param Closure $callback
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function sear($key, Closure $callback): mixed
    {
        return $this->cache->sear($key, $callback);
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param string $key
     * @param Closure $callback
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function rememberForever($key, Closure $callback): mixed
    {
        return $this->cache->rememberForever($key, $callback);
    }

    /**
     * Remove an item from the cache.
     *
     * @param string $key
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     */
    public function forget($key): bool
    {
        return $this->cache->forget($key);
    }

    /**
     * @param array $tags
     * @return mixed
     */
    public function tags(array $tags): mixed
    {
        return $this->cache->tags($tags);
    }

    /**
     * @return Store
     */
    public function getStore(): Store
    {
        return $this->cache->getStore();
    }
}