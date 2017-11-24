<?php

namespace BinInfo\Common\Provider;

use BinInfo\Common\Exception\ProviderNotFoundException;
use BinInfo\Common\Util\Client;
use BinInfo\Common\Util\Helper;

/**
 * Class ProviderFactory
 * @package BinInfo\Common\Provider
 */
class ProviderFactory
{
    /**
     * @var ProviderInterface[]
     */
    private $providers = [];

    /**
     * Return all created providers
     *
     * @return ProviderInterface[]
     */
    public function all()
    {
        return $this->providers;
    }

    /**
     * Get provider by name if it is created before
     *
     * @param $class
     * @return ProviderInterface
     * @throws ProviderNotFoundException
     */
    public function get($class)
    {
        $class = Helper::getProviderClassName($class);
        if (array_key_exists($class, $this->providers)) {
            return $this->providers[$class];
        }
        throw new ProviderNotFoundException("$class Dummy not found");
    }

    /**
     * Add a new provider instance
     *
     * @param $class
     * @param array $parameters
     * @param null $httpClient
     * @return ProviderInterface
     */
    public function add($class, $parameters = [], $httpClient = null)
    {
        $provider = self::create($class, $httpClient);
        $provider->initialize($parameters);

        $class = Helper::getProviderClassName($class);
        $this->providers[$class] = $provider;
        return $provider;
    }

    /**
     * Create a new provider instance
     *
     * @param string $class Provider name
     * @param Client|null $httpClient A HTTP Client implementation
     * @throws ProviderNotFoundException If no such provider is found
     * @return ProviderInterface An object of class $class is created and returned
     */
    public function create($class, Client $httpClient = null)
    {
        $class = Helper::getProviderClassName($class);
        if (!class_exists($class)) {
            throw new ProviderNotFoundException("Class '$class' not found");
        }
        return new $class($httpClient);
    }
}
