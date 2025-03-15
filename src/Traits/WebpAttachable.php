<?php

namespace Baldcat\OrchidWebp\Traits;

use Baldcat\OrchidWebp\Services\WebpConverter;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;

trait WebpAttachable {

    use Attachable;

    public function webpAttachments()
    {
        return $this->attachments->map(function (Attachment $attachment) {
            $attachment->webp = (new WebpConverter($attachment))->url();
            return $attachment;
        });
    }

}


