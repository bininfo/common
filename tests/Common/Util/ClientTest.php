<?php

namespace BinInfo\Common\Util;

use Mockery;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Http\Mock\Client as MockClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 * @package BinInfo\Common\Util
 *
 * @link https://github.com/thephpleague/omnipay-common/blob/master/tests/Omnipay/Common/Http/ClientTest.php
 */
class ClientTest extends TestCase
{

    /** @var  MockClient */
    private $mockClient;
    private $httpClient;
    private $httpRequest;

    public function testEmptyConstruct()
    {
        $client = new Client();
        $this->assertAttributeInstanceOf(HttpClient::class, 'httpClient', $client);
        $this->assertAttributeInstanceOf(RequestFactory::class, 'requestFactory', $client);
    }

    public function testCreateRequest()
    {
        $client = $this->getHttpClient();
        $request = $client->createRequest('GET', '/path', ['foo' => 'bar']);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('/path', $request->getUri());
        $this->assertEquals(['bar'], $request->getHeader('foo'));
    }

    public function testSend()
    {
        $mockClient = Mockery::mock(HttpClient::class);
        $mockFactory = Mockery::mock(RequestFactory::class);
        $client = new Client($mockClient, $mockFactory);
        $request = new Request('GET', '/path');
        $mockFactory->shouldReceive('createRequest')->withArgs([
            'GET',
            '/path',
            [],
            null,
            '1.1',
        ])->andReturn($request);
        $mockClient->shouldReceive('sendRequest')->with($request)->once()->andReturn(new Response());
        $response = $client->send('GET', '/path');

        $this->assertInstanceOf('GuzzleHttp\Psr7\Response', $response);
    }

    public function testSendParsesArrayBody()
    {
        $mockClient = Mockery::mock(HttpClient::class);
        $mockFactory = Mockery::mock(RequestFactory::class);
        $client = new Client($mockClient, $mockFactory);
        $request = new Request('POST', '/path', [], 'a=1&b=2');
        $mockFactory->shouldReceive('createRequest')->withArgs([
            'POST',
            '/path',
            [],
            'a=1&b=2',
            '1.1',
        ])->andReturn($request);
        $mockClient->shouldReceive('sendRequest')->with($request)->once()->andReturn(new Response());
        $response = $client->send('POST', '/path', [], ['a' => '1', 'b' => 2]);

        $this->assertInstanceOf('GuzzleHttp\Psr7\Response', $response);
    }

    public function testGet()
    {
        $mockClient = Mockery::mock(HttpClient::class);
        $mockFactory = Mockery::mock(RequestFactory::class);
        $client = new Client($mockClient, $mockFactory);
        $request = new Request('GET', '/path');
        $mockFactory->shouldReceive('createRequest')->withArgs([
            'GET',
            '/path',
            [],
            null,
            '1.1',
        ])->andReturn($request);
        $mockClient->shouldReceive('sendRequest')->with($request)->once()->andReturn(new Response());
        $response = $client->get('/path');

        $this->assertInstanceOf('GuzzleHttp\Psr7\Response', $response);
    }

    public function testPost()
    {
        $mockClient = Mockery::mock(HttpClient::class);
        $mockFactory = Mockery::mock(RequestFactory::class);
        $client = new Client($mockClient, $mockFactory);
        $request = new Request('POST', '/path', [], 'a=b');
        $mockFactory->shouldReceive('createRequest')->withArgs([
            'POST',
            '/path',
            [],
            'a=b',
            '1.1',
        ])->andReturn($request);
        $mockClient->shouldReceive('sendRequest')->with($request)->once()->andReturn(new Response());
        $response = $client->post('/path', [], ['a' => 'b']);

        $this->assertInstanceOf('GuzzleHttp\Psr7\Response', $response);
    }

    public function getMockClient()
    {
        if (null === $this->mockClient) {
            $this->mockClient = new MockClient();
        }
        return $this->mockClient;
    }

    public function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new Client(
                $this->getMockClient()
            );
        }
        return $this->httpClient;
    }

    public function getHttpRequest()
    {
        if (null === $this->httpRequest) {
            $this->httpRequest = new HttpRequest;
        }
        return $this->httpRequest;
    }
}