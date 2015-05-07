<?php

$app['default_controller'] = 'Index';
$app['default_method'] = 'index';

$app['session']['autostart'] = false;
$app['session']['type'] = 'native';
$app['session']['name'] = '_sess';
$app['session']['livetime'] = 3600;
$app['session']['path'] = '/';
$app['session']['domain'] = '';
$app['session']['secure'] = false;