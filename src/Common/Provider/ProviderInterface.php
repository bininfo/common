<?php
namespace BinInfo\Common\Provider;

use BinInfo\Common\Exception\ProviderLimitExceedException;
use BinInfo\Common\Model\Bin;

/**
 * Interface ProviderInterface
 * @package BinInfo\Common\Provider
 */
interface ProviderInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param $binNumber
     * @return Bin
     * @throws ProviderLimitExceedException
     */
    public function get($binNumber);

    /**
     * @return array
     */
    public function getDefaultParameters();

    /**
     * @param array $parameters
     * @return $this
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
