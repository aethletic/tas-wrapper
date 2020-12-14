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

    private $mappedMethods = [];

    public function __construct(array $config = null)
    {
        $this->config = array_merge($this->config, $config);
        $this->curl = curl_init();
    }

    public function post(string $method, array $params = []) : Client
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->buildApiUrl($method));
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->buildParams($params));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        return $this;
    }

    public function get(string $method, array $params = []) : Client
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->buildApiUrl($method) . '?' . $this->buildParams($params));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        return $this;
    }

    public function option($name, $value) : Client
    {
        curl_setopt($this->curl, $name, $value);
        return $this;
    }

    public function execute() : ?array
    {
        $response = curl_exec($this->curl);
        return $response ? json_decode($response, true) : null;
    }

    private function buildApiUrl($method) : string
    {
        return "{$this->config['host']}:{$this->config['port']}/api/{$method}";
    }

    private function buildParams($params) : string
    {
        return http_build_query(['data' => $params]);
    }

    public function map(string $method, $func) : void
    {
        if (method_exists($this, $method)) {
            throw new \Exception('Cannot override an existing method.');
        }

        $this->mappedMethods[$method] = $func;
    }

    public function mapOnce(string $method, $func)
    {
        if (method_exists($this, $method)) {
            throw new \Exception('Cannot override an existing method.');
        }
        
        $this->mappedMethods[$method] = call_user_func($func);
    }

    public function __call($method, $args)
    {
        $tmp = $this->mappedMethods[$method];
        return is_callable($tmp) ? call_user_func_array($tmp, $args) : $tmp;
    }
}
