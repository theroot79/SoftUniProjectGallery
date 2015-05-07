<?php

$routes = array();
$routes['admin']['namespace'] = 'Controllers\Admin';
$routes['admin']['controller']['Index']['changeto'] = 'NewIndex';
$routes['admin']['controller']['new']['method']['add'] = 'create';


$routes['*']['namespace'] = 'Controllers';

return $routes;