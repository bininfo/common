<?php
namespace BinInfo\Common\Provider;

use BinInfo\Common\Model\Bin;

/**
 * Interface ProviderInterface
 * @package BinInfo\Common\Provider
 */
interface ProviderInterface
{

    public function getName();

    /**
     * @param $binNumber
     * @return Bin
     */
    public function get($binNumber);

    public function getDefaultParameters();

    /**
     * @param array $parameters
     * @return mixed
     */
    public function initialize(array $parameters = []);

    /**
     * Get all provider parameters
     *
     * @return array
     */
    public function getParameters();

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getParameter($key, $default = null);
}
