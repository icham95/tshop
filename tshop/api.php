<?php 

include_once('classes/autoload.php');

use classes\{ Sapi, Database};

$s = new Sapi();
$s->set_routes('/kurirs', 'Controller_api/login', 'POST');
$s->set_routes('/tracking', 'Controller_api/tracking', 'POST');

$s->run();