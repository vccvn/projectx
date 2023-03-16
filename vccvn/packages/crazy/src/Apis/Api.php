<?php

namespace Crazy\Apis;

use Psr\Http\Message\ResponseInterface;

/**
 * doi tuong quan li request toi api
 * @method ResponseInterface|string|array get(string $url, array $data = [], array $headers = [])
 * @method ResponseInterface|string|array post(string $url, array $data = [], array $headers = [])
 * @method ResponseInterface|string|array put(string $url, array $data = [], array $headers = [])
 * @method ResponseInterface|string|array path(string $url, array $data = [], array $headers = [])
 * @method ResponseInterface|string|array delete(string $url, array $data = [], array $headers = [])
 * @method ResponseInterface|string|array options(string $url, array $data = [], array $headers = [])
 * 
 */
class Api extends BaseApi{
    // test
    public function __call($name, $arguments)
    {
        $method = strtoupper($name);
        return $this->makeRequest($method, ...$arguments);
    }
}