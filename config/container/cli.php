<?php

use Sys\Template\Template;
use Sys\Template\TemplateFactory;

return [
    Template::class => fn() => (new TemplateFactory())->create(config('template')),
    
];
