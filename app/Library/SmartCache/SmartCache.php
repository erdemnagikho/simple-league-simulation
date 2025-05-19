<?php

namespace App\Library\SmartCache;

use Redis;
use Illuminate\Support\Facades\Log;

final class SmartCache extends AbstractSmartCache
{
    protected static ?SmartCache $instance = null;

    /**
     * @return AbstractSmartCache
     *
     * @throws \Throwable
     */
    public static function getInstance(): AbstractSmartCache
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->setConnection();
        }

        try {
            self::$instance->connection->ping();
        } catch (\Throwable $e) {
            Log::error("SmartCache error: " . $e->getMessage());

            if (isset(self::$instance->connection)) {
                self::$instance->connection->close();
            }

            self::$instance = new self();
            self::$instance->setConnection();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    protected function setConnection(): void
    {
        $this->connection = new Redis();

        $this->connection->pconnect(config('database.redis.default.host'), config('database.redis.default.port'));
    }

    /**
     * @return Redis
     */
    protected function getConnection(): Redis
    {
        return $this->connection;
    }
}
