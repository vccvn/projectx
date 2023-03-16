<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$dir    = '/var/www/vccvn';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);
echo '<pre>';
print_r($files1);
print_r($files2);