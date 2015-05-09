<?php

$db['default']['connection_url'] = 'mysql:host=localhost;dbname=gallery;charset=utf8';
$db['default']['username'] = 'localuser';
$db['default']['password'] = '';
//$db['default']['pdo_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'UTF8'";
$db['default']['pdo_options'][PDO::ATTR_EMULATE_PREPARES] = false;
$db['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$db['default']['pdo_options'][PDO::ATTR_PERSISTENT] = false;
$db['default']['pdo_options'][PDO::ATTR_DEFAULT_FETCH_MODE] = PDO::FETCH_ASSOC;
return $db;