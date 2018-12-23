<?php

require 'vendor/autoload.php'; 

use PD\Application;

header('Content-type: text/plain');
$app = new Application();
$app->main();
?>