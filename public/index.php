<?php

define('SITE_PATH',@realpath(substr(dirname($_SERVER['SCRIPT_FILENAME']), 0,
						strrpos( dirname($_SERVER['SCRIPT_FILENAME']), DIRECTORY_SEPARATOR))));

require '..'.DIRECTORY_SEPARATOR.'VTF/App.php';

$app = \VTF\App::getInstance();
$app->run();

//$app->getSession()->counter += 1;
//echo $app->getSession()->counter;