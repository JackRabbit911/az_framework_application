<?php

namespace Modules\Image;

use Nette\Utils\Image;
use Nette\Utils\ImageColor;
use Nette\Utils\ImageType;

class Im
{
    private Image $im;
    private string $filepath;
    private int $format;

    public function __construct(string $filepath)
    {
        $this->im = Image::fromFile($filepath, $format);
        $this->filepath = $filepath;
        $this->format = $format;
    }

    public function original()
    {
        if (IS_WATERMARK && ($wm = config('images', 'watermark'))) {
            $this->watermark($wm, '40%', '97%', '95%', 50);
        }

        return $this;
    }

    public function foreign(?int $size = null)
    {
        if (!$size) {
            $size = ceil(getimagesize($this->filepath)[1] / 3);
        }

        $wm = config('images', 'watermark');

        if ($wm) {
            $this->watermark($wm, '90%', '95%', '60%', 50);
        }

        $this->im->resize(null, (int) $size);
        return $this;
    }

    public function fallback(string $func, int|string|null $size)
    {
        list($width, $height) = $this->size($size, $this->filepath);

        $stretch = function ($width, $height) {
            return $this->im->resize($width, $height, Image::Stretch);
        };

        $resize = function ($width, $height) {
            return $this->im->resize($width, $height);
        };

        $im = ($size) ? match ($func) {
            'crop', 'thumb' => $stretch($width, $height),
            'width' => $this->width($size),
            'height', 'foreign' => $this->height($size),
            default => $resize($width, $height),
        } : $this->im;

        return $this;
    }

    public function crop($size)
    {
        list($width, $height) = $this->size($size, $this->filepath);
        $this->im->crop('50%', '50%', $width, $height);
        return $this;
    }

    public function thumb(int|string $size)
    {
        list($width, $height) = $this->size($size, $this->filepath);
        $this->im->resize($width, $height, Image::Cover);
        return $this;
    }

    public function height($size)
    {
        $this->im->resize(null, $size);
        return $this;
    }

    public function width($size)
    {
        $this->im->resize($size, null);
        return $this;
    }

    public function watermark($wm_file, $height, $left, $top, $opacity)
    {
        if (is_string($height)) {
            $height = (int) rtrim($height, '%') / 100;
            $height = ceil((int) $this->im->getHeight() * $height);
        }

        $watermark = Image::fromFile($wm_file)->resize(null, $height);
        $this->im->place($watermark, $left, $top, $opacity);
        return $this;
    }

    public function toString(?int $format = null)
    {
        $format = (($format)) ?: $this->format;
        return $this->im->toString($this->format);
    }

    public function save(string $file, ?int $quality = null, ?int $format = null)
    {
        $format = (($format)) ?: $this->format;
        $this->im->save($file, $quality, $format);
        return $this;
    }

    public function size($size = null)
    {
        if ($size) {
            $arr = explode('x', $size);
            $width = $arr[0];
            $height = $arr[1] ?? $width;
        } else {
            list($width, $height) = getimagesize($this->filepath);
        }


        return [$width, $height];
    }
}
