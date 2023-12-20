<?php

require('vendor/autoload.php');

$f3 = Base::instance();

$f3->set('CACHE', false);

$f3->config('config/config.ini');
$f3->config('config/routes.cfg');

$f3->run();