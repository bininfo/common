<?php

namespace BinInfo\Common\Util;

/**
 * Class Helper
 * @package BinInfo\Common\Util
 */
class Helper
{
    /**
     * Convert a string to camelCase. Strings already in camelCase will not be harmed.
     * It replaces dashes with underscores.
     *
     * @param  string  $string The input string
     * @return string camelCased output string
     */
    public static function camelCase($string)
    {
        $string = str_replace('-', '_', $string);
        $string = self::convertToLowercase($string);
        return preg_replace_callback(
            '/_([a-z])/',
            function ($match) {
                return strtoupper($match[1]);
            },
            $string
        );
    }

    /**
     * Convert strings with underscores to be all lowercase before camelCase is preformed.
     *
     * @param  string $string The input string
     * @return string The output string
     */
    protected static function convertToLowercase($string)
    {
        $explodedString = explode('_', $string);
        $lowerCasedString = [];
        if (count($explodedString) > 1) {
            foreach ($explodedString as $value) {
                $lowerCasedString[] = strtolower($value);
            }
            $string = implode('_', $lowerCasedString);
        }
        return $string;
    }

    /**
     * Initialize an object with a given array of parameters
     *
     * Parameters are automatically converted to camelCase. Any parameters which do
     * not match a setter on the target object are ignored.
     *
     * @param mixed $target     The object to set parameters on
     * @param array $parameters An array of parameters to set
     */
    public static function initialize($target, array $parameters = null)
    {
        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $method = 'set'.ucwords(static::camelCase($key));
                if (method_exists($target, $method)) {
                    $target->$method($value);
                }
            }
        }
    }


    /**
     * Resolve a short provider name to a full namespaced provider class.
     *
     * Class names beginning with a namespace marker (\) are left intact.
     * Non-namespaced classes are expected to be in the \BinInfo namespace, e.g.:
     *
     *      \Custom\Provider    => \Custom\Provider
     *      \Custom_Provider    => \Custom_Provider
     *      Dummy               => \BinInfo\Dummy\Provider
     *      Foo\Bar             => \BinInfo\Foo\BarProvider
     *
     * @param  string $shortName The short provider name
     * @return string  The fully namespaced provider class name
     */
    public static function getProviderClassName($shortName)
    {
        if (0 === strpos($shortName, '\\')) {
            return $shortName;
        }
        // replace underscores with namespace marker, PSR-0 style
        $shortName = str_replace('_', '\\', $shortName);
        if (false === strpos($shortName, '\\')) {
            $shortName .= '\\';
        }
        return '\\BinInfo\\' . $shortName . 'Provider';
    }
}
