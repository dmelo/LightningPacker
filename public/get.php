<?php

/**
 * Interpret hash and type parameters to fetch the right script.
 *
 * @author Diogo Oliveira de Melo
 *
 * Copyright (C) 2011  Diogo Oliveira de Melo
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *  
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 */


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

