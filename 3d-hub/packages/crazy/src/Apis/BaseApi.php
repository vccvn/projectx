<?php

namespace Crazy\Apis;

use App\Exceptions\NotReportException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Crazy\Helpers\Arr;

abstract class BaseApi
{
    protected $http_code = 200;

    protected $url;

    protected $responseType = 'text';

    function __construct($config = [])
    {
        $this->url = env('API_URL');
        if(isset($config['response_type'])) $this->responseType = $config['response_type'];
    }

    public function setResponseType($type)
    {
        $this->responseType = strtolower($type);
        return $this;
    }
    /**
     * gửi request đến API server
     * @param string $url               là sub url nghĩ là không cần địa chỉ server chỉ cần /module/abc...
     * @param string $method            [= GET / POST / PUT / PATCH / DELETE / OPTION]
     * @param array  $data              mãng data get cũng dùng dc luôn
     * @param array  $headers           Mãng header. cái này tùy chọn
     * 
     * @return object|Client
     */

    public function sendRequest($url, $method = 'GET', array $data = [], array $headers = [])
    {
        if (!$url) return null;
        // try {
            $client = new Client();
            $headerData = array_merge([
                // 'Authorization' => $this->token,
                // 'content-type'=>'x-www-form-urlencoded',
                // 'content-type' => 'application/json',
    
            ], $headers);
            $api_url = $url;
            $response = $client->request($method, $api_url, [
                'headers' => $headerData,
                //    'form_params' => $data
                'body' => json_encode($data)
            ]);
    
            return $response;
        // } catch (BadResponseException $th) {
        //     return null;
        // }
        
    }

    /**
     * gửi request đến API server lấy kết quả trả về chuyển sang dạng object
     * @param string $url               
     * @param string $method            [= GET / POST / PUT / PATCH / DELETE / OPTION]
     * @param array  $data              mãng data get cũng dùng dc luôn
     * @param array  $headers           Mãng header. cái này tùy chọn
     * 
     * @return Arr std
     * cấu trúc trả về theo tài liệu api
     */

    public function json($url, $method = 'GET', array $data = [], array $headers = [])
    {
        $data = [];
        if ($url) {
            $headerData = array_merge(['content-type' => 'application/json'], $headers);
            // try {
                if ($response = $this->sendRequest($url, $method, $data, $headerData)) {
                    $data = json_decode($response->getBody()->getContents(), true);
                }
            // } catch (NotReportException $th) {
            //     //throw $th;
            // }
            
        }

        return new Arr($data);
    }


    /**
     * gửi request đến API server
     * @param string|array $method      [= GET / POST / PUT / PATCH / DELETE / OPTION]
     * @param string $url               là sub url nghĩ là không cần địa chỉ server chỉ cần /module/abc...
     * @param array  $data              mãng data get cũng dùng dc luôn
     * @param array  $headers           Mãng header. cái này tùy chọn
     * 
     * @return array
     */

    protected function makeRequest($method, $url = null, array $data = [], array $headers = [])
    {
        if (is_array($method)) {
            $m = array_key_exists('method', $method) ? $method['method'] : 'GET';
            $obj = $method;
            extract($obj, EXTR_PREFIX_INVALID, 'crazy_');
            if (!is_string($method)) $method = $m;
        }
        if (!$url) return null;
        $client = new Client();

        $defaultOptions = [];
        if ($this->responseType == 'json') {
            $defaultOptions['content-type'] = 'application/json';
        }
        // try {
            $headerData = array_merge($defaultOptions, (array) $headers);
            $response = $client->request($method, $url, [
                'headers' => $headerData,
                //    'form_params' => $data
                'body' => json_encode((array) $data)
            ]);

            if ($this->responseType == 'json') {
                return json_decode($response->getBody()->getContents(), true);
            }
            return $response;
        // } catch (BadResponseException $th) {
        //     return null;
        // }
    }


    public function getHttpCode()
    {
        return $this->http_code;
    }


    /**
     * gửi request đến API server
     * @param string $url               là sub url nghĩ là không cần địa chỉ server chỉ cần /module/abc...
     * @param string $method            [= GET / POST / PUT / PATCH / DELETE / OPTION]
     * @param array  $data              mãng data get cũng dùng dc luôn
     * @param array  $headers           Mãng header. cái này tùy chọn
     * 
     * @return object Client
     */

    public function send($url, $method = 'GET', $data = [], array $headers = [])
    {
        try {
            $client = new Client();
            $response = $client->request($method, $url, array_merge($headers, [
                'headers' => $headers,
                //    'form_params' => $data
                'body' => json_encode($data)
            ]));
            return $response;
        } catch (BadResponseException $exception) {

            return null;
        }
    }
}
