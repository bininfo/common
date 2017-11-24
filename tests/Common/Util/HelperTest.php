<?php

namespace BinInfo\Common\Util;

use Mockery;
use PHPUnit\Framework\TestCase;


class HelperTest extends TestCase
{

    public function testCamelCase()
    {
        $this->assertSame('username', Helper::camelCase('username'));
        $this->assertSame('firstName', Helper::camelCase('first_name'));
        $this->assertSame('myString', Helper::camelCase('my-string'));
    }

    public function testGetProviderClassName()
    {
        $classNames = [
            '\Dummy' => '\Dummy',
            '\Dummy\Provider' => '\Dummy\Provider',
            'Dummy' => '\BinInfo\Dummy\Provider',
            'Dummy\Bin' => '\BinInfo\Dummy\BinProvider'
        ];

        foreach ($classNames as $shortName => $expected) {
            $this->assertSame($expected, Helper::getProviderClassName($shortName));
        }
    }
}