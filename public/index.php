<?php

define('SITE_PATH',@realpath(substr(dirname($_SERVER['SCRIPT_FILENAME']), 0,
						strrpos( dirname($_SERVER['SCRIPT_FILENAME']), DIRECTORY_SEPARATOR))));

require '..'.DIRECTORY_SEPARATOR.'VTF/App.php';

$appIns = \VTF\App::getInstance();
$appIns->setUp();
$appIns->setRouter();
$db = new \VTF\Db\Db();
$appIns->run();


$appIns->getSession()->counter += 1;
echo $appIns->getSession()->counter;


print '<br/>OK';