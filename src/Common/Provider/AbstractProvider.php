<?php

namespace BinInfo\Common\Provider;

use BinInfo\Common\Model\Bin;
use BinInfo\Common\Util\Client;
use BinInfo\Common\Util\Helper;

/**
 * Base Provider Class
 *
 * This class should be extended by all BinInfo providers,
 * it has implementations of ProviderInterface and various common methods
 *
 * @see ProviderInterface
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * Create a new provider instance
     *
     * @param Client $httpClient A HTTP client to make API calls with
     */
    public function __construct(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: $this->getDefaultHttpClient();
        $this->parameters = [];
    }

    /**
     * Get the global default HTTP client.
     *
     * @return Client
     */
    protected function getDefaultHttpClient()
    {
        return new Client();
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function initialize(array $parameters = [])
    {
        $this->parameters = [];
        // set default parameters
        foreach ($this->getDefaultParameters() as $key => $value) {
            if (is_array($value)) {
                $this->parameters[$key] = reset($value);
            } else {
                $this->parameters[$key] = $value;
            }
        }
        Helper::initialize($this, $parameters);
        return $this;
    }

    /**
     * Get all provider parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getParameter($key, $default = null)
    {
        return (array_key_exists($key, $this->parameters)) ? $this->parameters[$key] : $default;
    }

    /**
     * @param  string $key
     * @param  mixed $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * @param array $data
     * @return Bin
     */
    abstract protected function mapToBin(array $data);
}
