<?php

define('PRODUCTION', 10);
define('STAGE', 20);
define('TESTING', 30);
define('DEVELOPMENT', 40);

define('ENV', env('env'));

// define('IS_DEBUG', (ENV >= TESTING) ? true : false);
// define('IS_CACHE', (ENV >= TESTING) ? false : true);
define('DISPLAY_ERRORS', (ENV >= TESTING) ? true : false);

define('IS_DEBUG', false);
define('IS_CACHE', false);

/** for Image module */
define('IS_FOREIGN', false);
define('IS_WATERMARK', true);
define('IS_IMG_CACHE', false);
