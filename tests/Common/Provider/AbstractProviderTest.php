<?php

namespace BinInfo\Common\Provider;

use Mockery;
use BinInfo\Common\Model\Bin;
use BinInfo\Common\Util\Client;
use PHPUnit\Framework\TestCase;

class AbstractProviderTest extends TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = Mockery::mock('\BinInfo\Common\Provider\AbstractProvider')->makePartial();
    }

    public function testConstruct()
    {
        $this->provider = new AbstractProviderTest_Mock;
        $this->assertInstanceOf(Client::class, $this->provider->getProtectedHttpClient());
        $this->assertSame([], $this->provider->getParameters());
    }

    public function testInitializeDefaults()
    {
        $defaults = array(
            'token' => 123456,
            'config' => [
                'foo' => 'bar'
            ]
        );
        $this->provider->shouldReceive('getDefaultParameters')->once()
            ->andReturn($defaults);
        $this->provider->initialize();
        $expected = array(
            'token' => 123456,
            'config' => 'bar',
        );

        $this->assertSame($expected, $this->provider->getParameters());
    }

    public function testInitializeParameters()
    {
        $this->provider->shouldReceive('getDefaultParameters')->once()
            ->andReturn(['token' => 'my-super-token']);

        $this->provider->initialize([
            'token' => 'my-super-token',
            'foo' => 'bar'
        ]);

        $this->assertSame(['token' => 'my-super-token'], $this->provider->getParameters());
    }
}


class AbstractProviderTest_Mock extends AbstractProvider
{
    public function getName()
    {
        return 'Mock Provider Implementation';
    }

    public function getProtectedHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param array $data
     * @return Bin
     */
    protected function mapToBin(array $data)
    {
        return (new Bin)->map($data);
    }

    /**
     * @param $binNumber
     * @return Bin
     */
    public function get($binNumber)
    {
        return $this->mapToBin([]);
    }

    public function getDefaultParameters()
    {
        return [];
    }
}