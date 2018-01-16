<?php

namespace BinInfo;

use BinInfo\Common\Exception\BinNotFoundException;
use BinInfo\Common\Exception\ProviderLimitExceedException;
use BinInfo\Common\Exception\ProviderNotFoundException;
use BinInfo\Common\Model\Bin;
use BinInfo\Common\Provider\ProviderFactory;
use BinInfo\Common\Provider\ProviderInterface;
use BinInfo\Common\Util\Helper;
use GuzzleHttp\ClientInterface;

/**
 * Class BinInfo
 * @package BinInfo
 *
 * @method static ProviderInterface add(string $class, array $parameters = [], ClientInterface $httpClient = null)
 */
class BinInfo
{

    /**
     * Internal factory storage
     *
     * @var ProviderFactory
     */
    private static $factory;

    /**
     * Get bin info from providers, it check providers one by one to get bin info unless provider name provided
     * If provide name provided it checks info in given provider
     *
     * @param $bin
     * @return Bin
     * @throws BinNotFoundException
     * @throws ProviderNotFoundException
     * @throws ProviderLimitExceedException
     */
    public static function get($bin)
    {
        $factory = self::getFactory();

        if (count($factory->all()) == 0) {
            throw new ProviderNotFoundException('Provider not found to get data, please provide at least one provider');
        }
        $bin = preg_replace('/[^0-9]/', '', $bin);

        foreach ($factory->all() as $name => $provider) {
            try {
                if ($data = $provider->get($bin)) {
                    return $data;
                }
            } catch (ProviderLimitExceedException $e) {
                if ($provider === end($factory->all())) {
                    throw $e;
                }
            }
        }

        throw new BinNotFoundException("Bin is not found for $bin");
    }

    /**
     * Get bin info from providers, it check providers one by one to get bin info unless provider name provided
     * If provide name provided it checks info in given provider
     *
     * @param $bin
     * @param null $providerName
     * @return Bin
     * @throws BinNotFoundException
     * @throws ProviderNotFoundException
     */
    public static function getBy($bin, $providerName)
    {
        $factory = self::getFactory();

        if ($provider = $factory->get($providerName)) {
            throw new ProviderNotFoundException('Provider not found');
        }
        $bin = preg_replace('/[^0-9]/', '', $bin);

        if ($data = $provider->get($bin)) {
            return $data;
        }

        throw new BinNotFoundException("Bin is not found for $bin");
    }

    /**
     * Get the provider factory
     *
     * Creates a new empty ProviderFactory if none has been set previously.
     *
     * @return ProviderFactory A ProviderFactory instance
     */
    public static function getFactory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new ProviderFactory();
        }
        return self::$factory;
    }

    /**
     * Set the provider factory
     *
     * @param ProviderFactory $factory A ProviderFactory instance
     */
    public static function setFactory(ProviderFactory $factory = null)
    {
        self::$factory = $factory;
    }

    /**
     * Static function call router.
     *
     * @see ProviderFactory
     *
     * @param string
     * @param array
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $factory = self::getFactory();
        return call_user_func_array(array($factory, $method), $parameters);
    }
}
