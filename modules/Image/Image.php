<?php

namespace Modules\Image;

use Sys\Entity\Entity;

class Image extends Entity
{
    private Repo $repo;
    protected string $file;
    protected ?string $alt = null;

    public function __construct(string $file, ?string $alt = null)
    {
        $this->repo = container()->get(Repo::class);
        $this->file = $file;
        $this->alt = (($alt)) ?: pathinfo($this->file, PATHINFO_FILENAME);
    }

    public function path()
    {
        return realpath(config('images', 'upload_path') . $this->file);
    }

    public function alt(?string $text = null)
    {
        return (($text)) ?: $this->alt;
    }

    public function src(?string $func = null, int|string|null $size = null)
    {
        if ($func) {
            $params['func'] = $func;
        }

        if ($size) {
            $params['size'] = $size;
        }

        $params['file'] = $this->file;

        return path('image', $params);
    }

    public function inline(?string $func = null, int|string|null $size = null): string
    {
        $file = config('images', 'upload_path') . $this->file;
        
        if (!is_file($file)) {
            return "";
        }

        $content = $this->repo->getImageString($file, $func, $size);
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($content);
        $content = base64_encode($content);

        return "data:$mime;base64,$content";
    }

    public function tag(?string $func = null, int|string|null $size = null, array $attributies = [])
    {
        $tag = '<img src="' . $this->src($func, $size) . '" alt="' . $this->alt() . '" ';

        foreach ($attributies as $key => $value) {
            $tag .= $key . '="' . $value . '" ';
        }

        return $tag . '/>';
    }
}
