<?php

namespace Baldcat\OrchidWebp\Services;

use Baldcat\OrchidWebp\Storage\WebpStorage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;
use Exception;
use InvalidArgumentException;

class WebpConverter
{
    private const SUPPORTED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    private Attachment $attachment;
    private $storage;
    private WebpStorage $webpStorage;

    public function __construct(
        Attachment $attachment,
        WebpStorage $webpStorage,
    ) {
        $this->attachment = $attachment;
        $this->storage = Storage::disk($this->attachment->disk);
        $this->webpStorage = $webpStorage;
    }

    /**
     * @throws Exception
     */
    private function validateMimeType(): bool
    {
        return in_array($this->attachment->mime, self::SUPPORTED_MIME_TYPES);
    }

    /**
     * @throws Exception
     */
    public function convert(): ?bool
    {
        if (! $this->validateMimeType()) {
            return null;
        }

        $originalPath = $this->getOriginalImagePath();

        $webpPath = $this->generateWebpPath($this->attachment->physicalPath());

        if (! $this->webpStorage->exists($webpPath)) {
            $webpContent = $this->convertToWebp($originalPath);
            return $this->webpStorage->save($webpPath, $webpContent);
        }

        return null;
    }

    private function convertToWebp(string $originalPath): string
    {
        $image = $this->createImageFromPath($originalPath);
        ob_start();
        imagewebp($image, null, config('orchid-webp.quality', 80));
        $webpContent = ob_get_clean();
        imagedestroy($image);

        return $webpContent;
    }

    private function getOriginalImagePath(): string
    {
        return $this->storage->path($this->attachment->physicalPath());
    }

    private function generateWebpPath(string $originalPath): string
    {
        return Str::beforeLast($originalPath, '.') . '.webp';
    }

    private function createImageFromPath(string $path)
    {
        return match ($this->attachment->mime) {
            'image/jpeg' => imagecreatefromjpeg($path),
            'image/png' => imagecreatefrompng($path),
            'image/gif' => imagecreatefromgif($path),
            default => throw new InvalidArgumentException('Unsupported image type: ' . $this->attachment->mime),
        };
    }
}
