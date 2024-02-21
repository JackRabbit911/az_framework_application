#!/usr/bin/php
<?php

define('DOCROOT', '../htdocs/www/');
define('ROOTPATH', '../');
define('SYSPATH', ROOTPATH);
define('APPPATH', './');
define('WRITABLE', ROOTPATH . 'writable/');

require_once SYSPATH . 'vendor/autoload.php';
require_once SYSPATH . 'vendor/az/sys/src/autoload.php';
require_once SYSPATH . 'vendor/az/sys/src/library.php';
require_once APPPATH . 'app/config/bootstrap.php';

$container = (new \Sys\ContainerFactory('cli'))
    ->create(new \DI\ContainerBuilder());

$app = $container->get('\Sys\Console\App');
$app->run();
