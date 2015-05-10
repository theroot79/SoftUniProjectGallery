<?php

if(!isset($_GET['f']))exit('?');
$f = trim($_GET['f']);
if(!preg_match('/.jpg$/',$f))exit('??');

$file = @file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/photos/'.$f);

@header('Content-Type: image/jpeg');
@header('Content-Disposition: attachment; filename="' . str_replace("/","_",$f) . '"');
@header('Cache-Control: private');
@header('Pragma: private');
print($file);