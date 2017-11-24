<?php

namespace BinInfo\Common\Provider;

use BinInfo\Common\Exception\ProviderNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProviderFactoryTest extends TestCase
{
    /** @var  ProviderFactory */
    private $factory;

    public static function setUpBeforeClass()
    {
        Mockery::mock('alias:BinInfo\\Dummy\\TestProvider');
    }

    public function setUp()
    {
        $this->factory = new ProviderFactory();
    }


    public function testAdd()
    {
        $provider = $this->factory->add('Dummy');

        $this->assertInstanceOf('\\BinInfo\\Dummy\\Provider', $provider);
    }

    public function testGet()
    {
        $this->factory->add('Dummy');
        $provider = $this->factory->get('Dummy');

        $this->assertInstanceOf('\\BinInfo\\Dummy\\Provider', $provider);
    }


    public function testAll()
    {
        $fooProvider = Mockery::mock('overload:BinInfo\\Foo\\Provider');
        $fooProvider->shouldReceive('initialize')->once();

        $providers = [];
        $providers[] = $this->factory->add('Dummy');
        $providers[] = $this->factory->add('Foo');

        $factorProviders = $this->factory->all();

        $this->assertEquals(count($providers), count($factorProviders));

        for ($i = 0; $i < count($providers); $i++) {
            $this->assertSame(get_class($providers[$i]), get_class(array_values($factorProviders)[$i]));
        }
    }

    public function testCreateShortName()
    {
        $provider = $this->factory->create('Dummy_Test');
        $this->assertInstanceOf('\\BinInfo\\Dummy\\TestProvider', $provider);
    }

    public function testCreateFullyQualified()
    {
        $provider = $this->factory->create('\\BinInfo\\Dummy\\TestProvider');
        $this->assertInstanceOf('\\BinInfo\\Dummy\\TestProvider', $provider);
    }

    public function testCreateInvalid()
    {
        $this->expectException(ProviderNotFoundException::class);
        $this->expectExceptionMessage('Class \'\BinInfo\Invalid\Provider\' not found');

        $this->factory->create('Invalid');
    }
}