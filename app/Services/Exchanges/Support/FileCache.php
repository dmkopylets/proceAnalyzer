<?php

namespace App\Services\Exchanges\Support;

class FileCache
{
    public function __construct(
        private string $path,
        private int $ttlSeconds
    ) {}

    public function get(): ?array
    {
        if (!file_exists($this->path)) {
            return null;
        }

        if ((time() - filemtime($this->path)) > $this->ttlSeconds) {
            return null;
        }

        return json_decode(
            file_get_contents($this->path),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    public function put(array $data): void
    {
        $dir = dirname($this->path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(
            $this->path,
            json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT)
        );
    }
}

