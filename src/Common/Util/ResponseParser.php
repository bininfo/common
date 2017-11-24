<?php
namespace BinInfo\Common\Util;

use BinInfo\Common\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseParser
 *
 * @package BinInfo\Common\Util
 */
class ResponseParser
{
    /**
     * @param string|ResponseInterface $response
     * @return string
     */
    private static function toString($response)
    {
        if ($response instanceof ResponseInterface) {
            return $response->getBody()->__toString();
        }
        return (string)$response;
    }

    /**
     * Parse the JSON response body and return an array
     *
     * Copied from Response->json() in Guzzle3 (copyright @mtdowling)
     * @link https://github.com/guzzle/guzzle3/blob/v3.9.3/src/Guzzle/Http/Message/Response.php
     *
     * @param  string|ResponseInterface $response
     * @throws RuntimeException if the response body is not in JSON format
     * @return array|string|int|bool|float
     */
    public static function json($response)
    {
        $body = self::toString($response);
        $data = json_decode($body, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }
        return $data === null ? [] : $data;
    }
}
