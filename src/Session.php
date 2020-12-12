<?php

namespace TelegramApiServer;

class Session
{
    private static $config = [
        'host' => '127.0.0.1',
        'port' => '9503',
        'schema' => 'http',
    ];

    private const GET_SESSION_LIST = 'getSessionList';
    private const ADD_SESSION = 'addSession';
    private const REMOVE_SESSION = 'removeSession';
    private const UNLINK_SESSION_FILE = 'unlinkSessionFile';

    public static function setConfig(array $config = []) : void
    {
        self::$config = array_merge($this->config, $config);
    }

    public static function list() : ?array
    {
        $response = file_get_contents(self::buildApiUrl(self::GET_SESSION_LIST));
        return $response ? json_decode($response, true) : null;
    }

    public static function add(string $session) : ?array
    {
        $query = http_build_query(compact('session', $session));
        $response = file_get_contents(self::buildApiUrl(self::ADD_SESSION) . "?{$query}");
        return $response ? json_decode($response, true) : null;
    }

    public static function remove(string $session) : ?array
    {
        $query = http_build_query(compact('session', $session));
        $response = file_get_contents(self::buildApiUrl(self::REMOVE_SESSION) . "?{$query}");
        return $response ? json_decode($response, true) : null;
    }

    public static function unlink(string $session) : ?array
    {
        $query = http_build_query(compact('session', $session));
        $response = file_get_contents(self::buildApiUrl(self::UNLINK_SESSION_FILE) . "?{$query}");
        return $response ? json_decode($response, true) : null;
    }

    private static function buildApiUrl($method) : string
    {
        return self::$config['schema'] . '://' . self::$config['host'] . ':' . self::$config['port'] . "/system/{$method}";
    }
}
