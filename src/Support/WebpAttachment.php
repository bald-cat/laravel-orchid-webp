<?php

namespace Baldcat\OrchidWebp\Support;

use Baldcat\OrchidWebp\Services\WebpConverter;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;

class WebpAttachment
{
    private string $name;
    private string $path;
    private string $extension;

    private Filesystem $storage;

    private WebpConverter $webpConverter;

    public function __construct(Attachment $attachment)
    {
        $this->name = $attachment->name;
        $this->path = $attachment->path;
        $this->extension = 'webp';
        $this->storage = Storage::disk($attachment->disk);

        $this->webpConverter = app(WebpConverter::class, [
            'attachment' => $attachment,
        ]);

        $this->webpConverter->convert();
    }

    public function url(): ?string
    {
        $path = $this->physicalPath();

        if ($path !== null && $this->storage->exists($path)) {
            return $this->storage->url($path);
        }

        return null;
    }

    private function physicalPath(): ?string
    {
        return $this->path.$this->name.".".$this->extension;
    }


}