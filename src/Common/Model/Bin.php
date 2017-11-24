<?php

namespace BinInfo\Common\Model;

/**
 * Class Bin
 * @package BinInfo\Common\Model
 */
class Bin
{
    /** @var  string */
    public $number;

    /** @var  string */
    public $provider;

    /** @var  string */
    public $brand;

    /** @var  string */
    public $category;

    /** @var  string */
    public $type;

    /** @var  string */
    public $country;

    /** @var  string */
    public $countryCode;

    /** @var  string */
    public $issuer;

    /** @var  string */
    public $issuerPhone;

    /** @var  string */
    public $issuerWebsite;

    /** @var  boolean */
    public $valid;

    /** @var  string */
    public $raw;

    /**
     * Bin constructor.
     */
    public function __construct()
    {
        $this->valid = false;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param $number
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param $provider
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param $brand
     * @return $this
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param $country
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param $countryCode
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param $issuer
     * @return $this
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssuerPhone()
    {
        return $this->issuerPhone;
    }

    /**
     * @param $issuerPhone
     * @return $this
     */
    public function setIssuerPhone($issuerPhone)
    {
        $this->issuerPhone = $issuerPhone;
        return $this;
    }

    /**
     * @return string
     */
    public function getIssuerWebsite()
    {
        return $this->issuerWebsite;
    }

    /**
     * @param $issuerWebsite
     * @return $this
     */
    public function setIssuerWebsite($issuerWebsite)
    {
        $this->issuerWebsite = $issuerWebsite;
        return $this;
    }

    /**
     * @return bool
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param $valid
     * @return $this
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
        return $this;
    }

    /**
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param $raw
     * @return $this
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
        return $this;
    }


    /**
     * Map the given array onto the bin's properties.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function map(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }
}
