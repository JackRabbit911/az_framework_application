<?php

namespace Modules\Image;

use ArrayIterator;
use LimitIterator;
use Sys\Helper\Facade\Dir;

class Repo
{
    private array $config;
    private string $uploadPath;
    private string $cachePath;
    private string $mask = '*.{jpg,jpeg,png,gif}';

    private $array;

    public function __construct($upload_path = null, $cache_path = null)
    {
        $this->config = config('images');
        $this->uploadPath = ($upload_path) ? $upload_path : $this->config['upload_path'];
        $this->cachePath = ($cache_path) ? $cache_path : $this->config['cache_path'];
    }

    public function getImageString($file, $func, $size)
    {
        if (!IS_IMG_CACHE) {
            return (new Im($file))->$func($size)->toString();
        }

        $fn = $this->generateFilename($file, $func, $size);
        $cache_file = $this->cachePath . $fn;

        if (!is_file($cache_file)) {
            $dir = dirname($cache_file) . '/';

            if (!is_dir($dir)) {
                mkdir($dir);
                chmod($dir, 0777);
            }

            $im = new Im($file);
            $imge = $im->$func($size)->save($cache_file)->toString();
            chmod($cache_file, 0777);
        } else {
            $imge = (new Im($cache_file))->toString();
        }

        return $imge;
    }

    public function find($file, $func, $size)
    {
        if (!IS_IMG_CACHE) {
            return $file;
        }

        $fn = $this->generateFilename($file, $func, $size);
        $cache_file = $this->cachePath . $fn;

        if (!is_file($cache_file) && is_file($file)) {
            $dir = dirname($cache_file) . '/';

            if (!is_dir($dir)) {
                mkdir($dir);
                chmod($dir, 0777);
            }

            $im = new Im($file);
            $im->$func($size)->save($cache_file);
            chmod($cache_file, 0777);
        }

        return $cache_file;
    }

    public function getAll($dir, $offset = 0, $limit = -1, $sort = false)
    {
        $array = Dir::getByMask($this->uploadPath . $dir, $this->mask, $sort);
        $ai = new ArrayIterator($array);
        $li = new LimitIterator($ai, $offset, $limit);
        return iterator_to_array($li, false);
    }

    public function get($dir, $sort = false)
    {
        $this->array = Dir::getByMask($this->uploadPath . $dir, $this->mask, $sort);
        return $this;
    }

    public function asArray($offset = 0, $limit = -1)
    {
        $ai = new ArrayIterator($this->array);
        $li = new LimitIterator($ai, $offset, $limit);

        foreach ($li as $file) {
            $result[] = new Image($file); 
        }

        return $result ?? [];
    }

    public function asStorage($offset = 0, $limit = -1)
    {
        $storage = new ImageStorage();

        foreach ($this->array as $key => $file) {
            if ($offset <= $key && ($offset + $limit > $key || $limit == -1)) {
                $storage->attach(new Image($file), pathinfo($file, PATHINFO_BASENAME) . ' ' . $key);
            }
        }

        return $storage;
    }

    public function clearCache()
    {
        Dir::clearDir($this->cachePath);
    }

    public function removeCache($dir)
    {
        $dir = $this->cachePath . $dir;
        Dir::removeAll($dir);
    }

    public function remove($file)
    {
        ['dirname' => $dirname, 'filename' => $filename] = pathinfo($file);
        $dir = $this->cachePath . $dirname . '/' . $filename;
        Dir::removeAll($dir);
        unlink($this->uploadPath . $file);
    }

    public function fallback($func, int|string|null $size = null)
    {
        $file = $this->config['fallback'];
        $im = new Im($file);
        return $im->fallback($func, $size)->toString();
    }

    private function generateFilename($file, $func, $size)
    {
        ['dirname' => $dirname, 'filename' => $filename, 'extension' => $ext] = pathinfo($file);
        $dir = $dirname . '/' . $filename . '/';
        $dir = str_replace([$this->uploadPath, './'], '', $dir);

        return $dir . md5($file . $func . $size) . '.' . $ext;
    }
}
