<?php

namespace Modules\Image;

use Sys\Controller\BaseController;
use Sys\MimeResponse;
use HttpSoft\Response\ResponseStatusCodeInterface;


class ImageController extends BaseController
{
    private Repo $repo;
    private array $config;

    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
        $this->config = config('images');
    }

    public function __invoke($id = null, $func = 'original', $size = null, $file = null)
    {
        $ref = $this->request->getServerParams()['HTTP_REFERER'] ?? null;

        if ($ref) {
            $arr_ref = parse_url($ref);
        }

        $host = $this->request->getServerParams()['HTTP_HOST'];

        if (IS_FOREIGN && (!$ref || $arr_ref['host'] !== $host)) {
            $func = 'foreign';
        }

        $file = $this->config['upload_path'] . $file;

        if (is_file($file)) {
            $image = $this->repo->getImageString($file, $func, $size);
            $status_code = ResponseStatusCodeInterface::STATUS_OK;
        } else {
            $image = $this->repo->fallback($func, $size);
            $status_code = ResponseStatusCodeInterface::STATUS_NOT_FOUND;
        }

        return new MimeResponse($image, $this->config['lifetime'] ?? 0, $status_code);
    }
}
