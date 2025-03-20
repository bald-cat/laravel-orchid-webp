<?php

namespace Baldcat\OrchidWebp\Traits;

use Baldcat\OrchidWebp\Support\WebpAttachment;
use Illuminate\Support\Collection;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Exception;

/**
 * @property Collection|Attachment[] $attachments
 */
trait WebpAttachable
{
    use Attachable;

    /**
     * @return Collection|null
     */
    public function webpAttachments(): ?Collection
    {
        return $this->attachments->map(function (Attachment $attachment) {
            try {
                $attachment = $this->validateMimeType($attachment)
                    ? new WebpAttachment($attachment)
                    : null;
            } catch (Exception) {
                return null;
            }

            return $attachment;
        })->filter();
    }

    /**
     * @param  Attachment  $attachment
     * @return bool
     */
    private function validateMimeType(Attachment $attachment): bool
    {
        return in_array(
            $attachment->mime,
            config('orchid-webp.supported_mime_types', []),
        );
    }
}
