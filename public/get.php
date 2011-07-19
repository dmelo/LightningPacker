<?php

define('CACHE_DIR', 'tmp/');
define('DEFAULT_EXPIRATION', 30 * 24 * 60 * 60);

$hash = $_GET['hash'];
$type = $_GET['type'];
$filename = CACHE_DIR . $hash . '.' . $type . '.gz';

if(file_exists($filename)) {
    if('js' === $type)
	$header = 'application/javascript';
    else
	$header = 'text/css';

    header("Content-type:  $header");
    header("Cache-Control: max-age=604800, public");
    header("Expires: ".gmdate("D, d M Y H:i:s", time() + DEFAULT_EXPIRATION)."GMT");
    header("Content-Encoding: gzip");

    echo file_get_contents($filename);
}
else
    header('HTTP/1.0 404 Not Found');

