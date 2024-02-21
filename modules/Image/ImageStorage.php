<?php

namespace Modules\Image;

use Sys\Collection\AbstractObjectStorage;

class ImageStorage extends AbstractObjectStorage
{
    protected $type = Image::class;
}
