<?php

namespace BinInfo;

use BinInfo\Common\Exception\BinNotFoundException;
use BinInfo\Common\Exception\ProviderNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function tearDown()
    {
        BinInfo::setFactory(null);
    }

    public function testGetFactory()
    {
        $factory = BinInfo::getFactory();
        $this->assertInstanceOf('BinInfo\Common\Provider\ProviderFactory', $factory);
    }

    public function testCallStatic()
    {
        $factory = Mockery::mock('BinInfo\Common\Provider\ProviderFactory');
        $factory->shouldReceive('testMethod')->with('bin')->once()->andReturn('bin-result');
        BinInfo::setFactory($factory);
        $result = BinInfo::testMethod('bin');
        $this->assertSame('bin-result', $result);
    }


    public function testProviderNotFoundExceptionWhenCreating()
    {
        $this->expectException(ProviderNotFoundException::class);

        BinInfo::create('TestProvider');
    }

    public function testProviderNotFoundExceptionWhenGetBin()
    {
        $this->expectException(ProviderNotFoundException::class);
        BinInfo::get('401288');
    }

    public function testFactoryProviderNotFoundException()
    {
        $this->expectException(ProviderNotFoundException::class);

        $factory = BinInfo::getFactory();
        $factory->get('Dummy');
    }

    public function testThrowBinNotFoundException()
    {
        $this->expectException(BinNotFoundException::class);

        $factory = BinInfo::getFactory();
        $factory->add('Dummy');

        BinInfo::get('401288');
    }

    public function testGetBin()
    {
        $factory = BinInfo::getFactory();
        $factory->add('Dummy');

        $bin = BinInfo::get('411111');

        $this->assertSame('Dummy' , $bin->provider);
        $this->assertTrue($bin->valid);
    }


    public function testBinNumberTrim()
    {
        $factory = BinInfo::getFactory();
        $factory->add('Dummy');

        $bin = BinInfo::get('4111 11');

        $this->assertSame('411111' , $bin->number);
    }

    public function testGetBinWithParameters()
    {
        $parameters = [
            'token' => 123456,
            'filter' => [
                'foo' => 'bar'
            ]
        ];

        $factory = BinInfo::getFactory();
        $factory->add('Dummy', $parameters);

        $provider = $factory->get('Dummy');

        $this->assertSame($parameters, $provider->getParameters());
        $this->assertSame($parameters['token'], $provider->getParameter('token'));
    }
}