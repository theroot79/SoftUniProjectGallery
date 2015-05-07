<?php

define('SITE_PATH',@realpath(substr(dirname($_SERVER['SCRIPT_FILENAME']), 0,
						strrpos( dirname($_SERVER['SCRIPT_FILENAME']), DIRECTORY_SEPARATOR))));

require '../VTF/App.php';

$app = \VTF\App::getInstance();
$app->setRouter();

$db = new \VTF\Db\Db();

$app->run();





print '<br/>OK';