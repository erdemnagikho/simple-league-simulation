<?php

use Illuminate\Support\Facades\Log;
use App\Library\SmartCache\SmartCache;

if (!function_exists('smartCache')) {
    function smartCache(): SmartCache
    {
        try {
            return SmartCache::getInstance();
        } catch (Throwable $e) {
            Log::error("Helpers smartCache error: " . $e->getMessage());

            return new SmartCache();
        }
    }
}
