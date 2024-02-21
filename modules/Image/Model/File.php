<?php

namespace Modules\Image\Model;

final class File
{
    public function set($dir, $data)
    {
        $info = ($this->get($dir)) ?: [];
        $data = array_replace($info, $data);
        file_put_contents($dir . '/info.json', json_encode($data));
    }

    public function get($dir, $key = null, $default = null)
    {
        $fileinfo = $dir . '/info.json';

        if (!is_file($fileinfo)) {
            return $default;
        }

        $str = file_get_contents($fileinfo);
        $arr = json_decode($str, true);

        return ($key) ? $arr[$key] ?? $default : $arr;
    }

    public function setRef($dir, $ref)
    {
        $str_refs = $this->get($dir, 'refs', '');
        $arr_refs = explode(',', $str_refs);
        array_push($arr_refs, $ref);
        $arr_refs = array_unique($arr_refs);
        $str_refs = trim(implode(',', $arr_refs), ',');
        $data = ['refs' => $str_refs];
        $this->set($dir, $data);
    }
}
