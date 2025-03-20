<?php

namespace Baldcat\OrchidWebp\Storage;

interface WebpStorage
{
    public function save(string $path, string $content): bool;
    public function get(string $path): ?string;
    public function exists(string $path): bool;
}
