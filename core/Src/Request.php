<?php

namespace Src;

use Error;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;
    protected $files = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->headers = getallheaders();

        // Обрабатываем тело запроса
        if ($this->method === 'POST') {
            $this->body = $_POST;

            // Обрабатываем файлы
            $this->files = $_FILES;

            // Также добавляем файлы в body для удобства доступа
            foreach ($_FILES as $key => $file) {
                $this->body[$key] = $file;
            }
        } else {
            $this->body = $_GET;
        }
    }

    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function set($key, $value): void
    {
        $this->body[$key] = $value;
    }

    public function get($key)
    {
        return $this->body[$key] ?? null;
    }

    // Добавляем метод для получения файлов
    public function files($key = null)
    {
        if ($key) {
            return $this->files[$key] ?? null;
        }
        return $this->files;
    }

    // Добавляем магический метод для доступа к files
    public function __get($name)
    {
        if ($name === 'files') {
            return $this->files;
        }

        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw new \Error("Accessing a non-existent property");
    }


}