<?php

namespace Modules\Guide;

use Parsedown;
use Sys\Controller\WebController;

class GuideController extends WebController
{
    private string $dataPath = APPPATH . 'modules/Guide/data/';
    private string $tplPath = APPPATH . 'modules/Guide/views';

    public function __invoke(Parsedown $parser, $part = null, $file = null)
    {
        $part = ($part) ? $part . '/' : '';
        $file = ($file) ? $file : 'index.md';
        $file = $this->dataPath . $part . $file;

        $content = $parser->text(file_get_contents($file));

        return $this->render('@guide/guide', ['content' => $content]);
    }

    protected function _before()
    {
        $this->tpl->getEngine()->getLoader()
            ->addPath(realpath($this->tplPath), 'guide');
    }
}
