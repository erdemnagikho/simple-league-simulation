<?php

namespace App\Library\SmartCache;

use Redis;

abstract class AbstractSmartCache
{
    protected Redis $connection;

    abstract public static function getInstance(): self;
    abstract protected function setConnection(): void;
    abstract protected function getConnection(): Redis;

    /**
     * @param string $key
     * @param bool $assoc
     *
     * @return mixed
     */
    public function getJson(string $key, bool $assoc = false): mixed
    {
        $result = $this->getConnection()->get($key);

        return json_decode($result, $assoc);
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function del(string $key): void
    {
        $this->getConnection()->del($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     *
     * @return void
     */
    public function setJson(string $key, mixed $value, int $ttl = 0): void
    {
        $value = json_encode($value);
        if ($ttl > 0) {
            $this->getConnection()->setex($key, $ttl, $value);
        } else {
            $this->getConnection()->set($key, $value);
        }
    }
}
