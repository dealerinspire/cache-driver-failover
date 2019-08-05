<?php
declare(strict_types=1);

namespace DealerInspire\AppCache\Tests;

use DealerInspire\AppCache\AppCache;
use Illuminate\Cache\ArrayStore;
use Illuminate\Contracts\Cache\Repository;
use Mockery\MockInterface;
use Orchestra\Testbench\TestCase;

class AppCacheTest extends TestCase
{
    /**
     * @var AppCache
     */
    protected $systemUnderTest;

    /**
     * @var MockInterface
     */
    protected $cacheMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cacheMock = \Mockery::mock(Repository::class);
        $this->systemUnderTest = new AppCache($this->cacheMock);
    }

    public function testPut()
    {
        $key = 'key';
        $value = 'value';
        $minutes = 60;

        $this->cacheMock
            ->shouldReceive('put')
            ->once()
            ->with($key, $value, $minutes)
            ->andReturn();

        $this->systemUnderTest->put($key, $value, $minutes);
    }

    public function testClear()
    {
        $this->cacheMock
            ->shouldReceive('clear')
            ->once()
            ->withNoArgs()
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->clear());
    }

    public function testSet()
    {
        $key = 'key';
        $value = 'value';
        $ttl = null;

        $this->cacheMock
            ->shouldReceive('set')
            ->once()
            ->with($key, $value, $ttl)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->set($key, $value, $ttl));
    }

    public function testHas()
    {
        $key = 'key';

        $this->cacheMock
            ->shouldReceive('has')
            ->once()
            ->with($key)
            ->andReturnFalse();

        $this->assertFalse($this->systemUnderTest->has($key));
    }

    public function testGetMultiple()
    {
        $keys = ['key1', 'key2'];
        $default = null;
        $values = ['val1', 'val2'];

        $this->cacheMock
            ->shouldReceive('getMultiple')
            ->once()
            ->with($keys, $default)
            ->andReturn($values);

        $this->assertSame($values, $this->systemUnderTest->getMultiple($keys));
    }

    public function testPull()
    {
        $key = 'key';
        $default = null;
        $value = 'value';

        $this->cacheMock
            ->shouldReceive('pull')
            ->once()
            ->with($key, $default)
            ->andReturn($value);

        $this->assertSame($value, $this->systemUnderTest->pull($key));
    }

    public function testRemember()
    {
        $key = 'key';
        $minutes = 60;
        $closure = function () {
            return true;
        };

        $this->cacheMock
            ->shouldReceive('remember')
            ->once()
            ->with($key, $minutes, $closure)
            ->andReturn($closure());

        $this->assertTrue($this->systemUnderTest->remember($key, $minutes, $closure));
    }

    public function testForget()
    {
        $key = 'key';

        $this->cacheMock
            ->shouldReceive('forget')
            ->once()
            ->with($key)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->forget($key));
    }

    public function testAdd()
    {
        $key = 'key';
        $value = 'value';
        $minutes = 60;

        $this->cacheMock
            ->shouldReceive('add')
            ->once()
            ->with($key, $value, $minutes)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->add($key, $value, $minutes));
    }

    public function testSetMultiple()
    {
        $values = [
            'key1' => 'val1',
            'key2' => 'val2',
        ];
        $ttl = null;

        $this->cacheMock
            ->shouldReceive('setMultiple')
            ->once()
            ->with($values, $ttl)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->setMultiple($values));
    }

    public function testRememberForever()
    {
        $key = 'key';
        $closure = function () {
            return true;
        };

        $this->cacheMock
            ->shouldReceive('rememberForever')
            ->once()
            ->with($key, $closure)
            ->andReturn($closure());

        $this->assertTrue($this->systemUnderTest->rememberForever($key, $closure));
    }

    public function testDeleteMultiple()
    {
        $keys = ['key1', 'key2'];

        $this->cacheMock
            ->shouldReceive('deleteMultiple')
            ->once()
            ->with($keys)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->deleteMultiple($keys));
    }

    public function testGetStore()
    {
        $store = new ArrayStore();

        $this->cacheMock
            ->shouldReceive('getStore')
            ->once()
            ->withNoArgs()
            ->andReturn($store);

        $this->assertSame($store, $this->systemUnderTest->getStore());
    }

    public function testIncrement()
    {
        $key = 'key';

        $this->cacheMock
            ->shouldReceive('increment')
            ->once()
            ->with($key, 1)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->increment($key));
    }

    public function testSear()
    {
        $key = 'key';
        $closure = function () {
            return true;
        };

        $this->cacheMock
            ->shouldReceive('sear')
            ->once()
            ->with($key, $closure)
            ->andReturn($closure());

        $this->assertTrue($this->systemUnderTest->sear($key, $closure));
    }

    public function testForever()
    {
        $key = 'key';
        $value = 'value';

        $this->cacheMock
            ->shouldReceive('forever')
            ->once()
            ->with($key, $value)
            ->andReturn();

        $this->systemUnderTest->forever($key, $value);
    }

    public function testDecrement()
    {
        $key = 'key';

        $this->cacheMock
            ->shouldReceive('decrement')
            ->once()
            ->with($key, 1)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->decrement($key));
    }

    public function testDelete()
    {
        $key = 'key';

        $this->cacheMock
            ->shouldReceive('delete')
            ->once()
            ->with($key)
            ->andReturnTrue();

        $this->assertTrue($this->systemUnderTest->delete($key));
    }

    public function testGet()
    {
        $key = 'key';
        $value = 'value';

        $this->cacheMock
            ->shouldReceive('get')
            ->once()
            ->with($key, null)
            ->andReturn($value);

        $this->assertSame($value, $this->systemUnderTest->get($key));
    }
}