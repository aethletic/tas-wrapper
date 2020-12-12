<?php

namespace TelegramApiServer;

class Client
{
    private $config = [
        'host' => '127.0.0.1',
        'port' => '9503',
        'session' => 'session',
    ];

    private $curl;

    public function __construct(array $config = null)
    {
        $this->config = array_merge($this->config, $config);
        $this->curl = curl_init();
    }

    public function post(string $method, array $params = []) : array
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->buildApiUrl($method));
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($this->curl);

        return json_decode($response, true);
    }

    public function get(string $method, array $params = []) : array
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->buildApiUrl($method) . '?' . http_build_query($params));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($this->curl);

        return json_decode($response, true);
    }

    private function buildApiUrl($method) : string
    {
        return "{$this->config['host']}:{$this->config['port']}/api/{$method}";
    }
}
