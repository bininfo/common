<?php

namespace BinInfo\Dummy;

use BinInfo\Common\Model\Bin;
use BinInfo\Common\Provider\AbstractProvider;

/**
 * Class Provider
 * @package BinInfo\Dummy
 */
class Provider extends AbstractProvider
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Dummy';
    }

    /**
     * @param $binNumber
     * @return Bin
     */
    public function get($binNumber)
    {
        if ($binNumber == '401288') {
            return null;
        }

        return $this->mapToBin(['bin' => $binNumber]);
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'token' => '',
            'filter' => []
        ];
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }

    /**
     * @param $value
     * @return $this
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->getParameter('filter');
    }


    /**
     * @param $value
     * @return $this
     */
    public function setFilter($value)
    {
        return $this->setParameter('filter', $value);
    }

    /**
     * @param array $data
     * @return Bin
     */
    protected function mapToBin(array $data)
    {
        return (new Bin())->setRaw($data)->map([
            'valid' => true,
            'number' => $data['bin'],
            'provider' => $this->getName(),
        ]);
    }
}