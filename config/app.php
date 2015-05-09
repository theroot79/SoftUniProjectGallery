<?php
$app['default_controller'] = 'Index';
$app['default_method'] = 'index';
$app['displayExceptions'] = true;

$app['session']['autostart'] = true;
$app['session']['type'] = 'native';
$app['session']['name'] = '_sess';
$app['session']['lifetime'] = 3600;
$app['session']['path'] = '/';
$app['session']['domain'] = '';
$app['session']['secure'] = false;
$app['session']['db'] = 'default';
$app['session']['dbtable'] = 'sessions';

return $app;