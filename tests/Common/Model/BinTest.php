<?php

namespace BinInfo\Common\Model;

use PHPUnit\Framework\TestCase;

class BinTest extends TestCase
{

    public function testSetRaw()
    {
        $data = [
            'scheme' => 'SCHEME',
            'brand' => 'My Brand'
        ];

        $bin = new Bin();
        $bin->setRaw($data);

        $this->assertSame($data, $bin->getRaw());
    }

    public function testMap()
    {
        $data = [
            'scheme' => 'SCHEME',
            'brand' => 'My Brand',
            'bank' => 'My Bank'
        ];

        $bin = new Bin();
        $bin->map([
            'scheme' => $data['scheme'],
            'brand' => $data['brand'],
            'issuer' => $data['bank']
        ]);

        $this->assertSame($data['bank'], $bin->getIssuer());
    }

    public function testCapsulation()
    {
        $data = [
            'scheme' => 'SCHEME',
            'brand' => 'My Brand',
            'bank' => 'My Bank'
        ];

        $bin = new Bin();
        $bin->setNumber('401288');
        $bin->setProvider('Dummy');
        $bin->setBrand('VISA');
        $bin->setType('DEBIT');
        $bin->setCategory('CLASSIC');
        $bin->setCountry('United Kingdom');
        $bin->setCountryCode('UK');
        $bin->setIssuer('BANK');
        $bin->setIssuerPhone('+44 123 45 67');
        $bin->setIssuerWebsite('https://bank.co.uk');
        $bin->setValid(true);

        $this->assertSame('401288', $bin->getNumber());
        $this->assertSame('Dummy', $bin->getProvider());
        $this->assertSame('VISA', $bin->getBrand());
        $this->assertSame('DEBIT', $bin->getType());
        $this->assertSame('CLASSIC', $bin->getCategory());
        $this->assertSame('United Kingdom', $bin->getCountry());
        $this->assertSame('UK', $bin->getCountryCode());
        $this->assertSame('BANK', $bin->getIssuer());
        $this->assertSame('+44 123 45 67', $bin->getIssuerPhone());
        $this->assertSame('https://bank.co.uk', $bin->getIssuerWebsite());
        $this->assertTrue($bin->getValid());
    }
}