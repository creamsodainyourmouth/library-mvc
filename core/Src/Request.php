<?php

namespace core\Src;
use Error;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;
    public $refer_from;
    public $refer_to;

    public function __construct()
    {
        $this->body = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders() ?? [];
        $this->refer_from = $_SERVER['HTTP_REFERER'];
        $this->refer_to = $_SERVER['REQUEST_URI'];
    }

    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function set($field, $value):void
    {
        $this->body[$field] = $value;
    }

    public function get($field)
    {
        return $this->body[$field] ?? null;
    }

    public function files(): array
    {
        return $_FILES;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->body)) {
            return $this->body[$key];
        }
        throw new Error('Accessing a non-existent property');
    }

}