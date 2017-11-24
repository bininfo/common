<?php

namespace BinInfo\Common\Util;

use BinInfo\Common\Exception\RuntimeException;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class ResponseParserTest extends TestCase
{

    public function testJsonRunTimeException()
    {
        $this->expectException(RuntimeException::class);

        $response = new Response(200, [], 'NOT JSON');

        ResponseParser::json($response);
    }

    public function testJsonWithResponseInterfaceEmptyData()
    {
        $response = new Response(200, [], '{}');

        $data = ResponseParser::json($response);

        $this->assertEmpty($data);
    }

    public function testJsonWithResponseInterfaceData()
    {
        $response = new Response(200, [], '{"success":true}');
        $data = ResponseParser::json($response);

        $this->arrayHasKey('success');
        $this->assertTrue($data['success']);
    }

    public function testJsonWithString()
    {
        $data = ResponseParser::json('{"success":true}');

        $this->arrayHasKey('success');
        $this->assertTrue($data['success']);
    }
}