<?php

namespace Crazy\Apis;
use GuzzleHttp\Promise\PromiseInterface;
/**
 * @method PromiseInterface|array get(string $url, array $data = [], array $headers = []) gửi request dạng Get, trả về array hoạc promise
 * @method PromiseInterface|array post(string $url, array $data = [], array $headers = []) gửi request dạng Post, trả về array hoạc promise
 * @method PromiseInterface|array put(string $url, array $data = [], array $headers = []) gửi request dạng Put, trả về array hoạc promise
 * @method PromiseInterface|array patch(string $url, array $data = [], array $headers = []) gửi request dạng Patch, trả về array hoạc promise
 * @method PromiseInterface|array delete(string $url, array $data = [], array $headers = []) gửi request dạng Delete, trả về array hoạc promise
 * @method PromiseInterface|array options(string $url, array $data = [], array $headers = []) gửi request dạng Options, trả về array hoạc promise
 */
class Api extends BaseApi{
    // test
    public function __call($name, $arguments)
    {
        $method = strtoupper($name);
        return $this->makeRequest($method, ...$arguments);
    }
}