<?php

namespace Baldcat\OrchidWebp\Storage;

use Illuminate\Support\Facades\Storage;

class FilesystemWebpStorage implements WebpStorage
{
    private $storage;

    public function __construct($storage = null)
    {
        $this->storage = $storage ?? Storage::disk('public');
    }

    public function save(string $path, string $content): bool
    {
        return $this->storage->put($path, $content);
    }

    public function get(string $path): ?string
    {
        return $this->storage->get($path);
    }

    public function exists(string $path): bool
    {
        return $this->storage->exists($path);
    }
}
