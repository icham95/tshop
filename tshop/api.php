<?php 

include_once('classes/autoload.php');

use classes\{ Sapi, Database};

$s = new Sapi();
$s->set_routes('/tracking', 'Controller_api/tracking', 'POST');
$s->set_routes('/merk', 'Controller_api/merk', 'GET');

$s->run();