<?php

namespace Baldcat\OrchidWebp\Storage;

use Illuminate\Support\Facades\Cache;

class CacheWebpStorage implements WebpStorage
{
    public function save(string $path, string $content): bool
    {
        Cache::put($this->getKey($path), config('orchid-webp.cache.ttl'));
        return true;
    }

    public function get(string $path): ?string
    {
        return Cache::get($this->getKey($path));
    }

    public function exists(string $path): bool
    {
        return Cache::has($this->getKey($path));
    }

    private function getKey(string $path): string
    {
        return config('orchid-webp.cache.key') . md5($path);
    }

}
