<?php

namespace Baldcat\OrchidWebp\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;
use Exception;

class WebpConverter
{

    private const SUPPORTED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    private Attachment $attachment;

    private Filesystem $storage;

    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
        $this->storage = Storage::disk($this->attachment->disk);
    }

    /**
     * @throws Exception
     */
    public function url(): string
    {
        $originalPath = $this->getOriginalImagePath();
        $webpPath = $this->generateWebpPath($originalPath);

        if (!file_exists($webpPath)) {
            $this->convertToWebp($originalPath, $webpPath);
        }

        return $this->storage->url($this->generateWebpPath($this->attachment->physicalPath()));
    }

    /**
     * @throws Exception
     */
    private function convertToWebp(string $originalPath, string $webpPath): void
    {
        $image = $this->createImageFromPath($originalPath);
        $this->saveImageAsWebp($image, $webpPath);
        imagedestroy($image);
    }

    private function getOriginalImagePath(): string
    {
        return $this->storage
            ->path($this->attachment->physicalPath());
    }
    
    private function generateWebpPath(string $originalPath): string
    {
        return Str::beforeLast($originalPath, '.') . '.webp';
    }

    /**
     * @throws Exception
     */
    private function createImageFromPath(string $path)
    {
        if (!in_array($this->attachment->mime, self::SUPPORTED_MIME_TYPES)) {
            throw new Exception('Unsupported image type: ' . $this->attachment->mime);
        }

        switch ($this->attachment->mime) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            case 'image/gif':
                return imagecreatefromgif($path);
        }
    }

    private function saveImageAsWebp($image, string $path): void
    {
        imagewebp($image, $path, config('orchid-webp.quality'));
    }
}