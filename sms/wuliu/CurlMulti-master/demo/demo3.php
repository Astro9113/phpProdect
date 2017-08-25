<?php
require '../CurlMulti/Core.php';
require '../CurlMulti/My.php';
require '../CurlMulti/My/Clone.php';
require '../phpQuery.php';
$url = 'http://www.laruence.com/manual';
$dir = __DIR__ . '/manual';
$cacheDir = __DIR__ . '/cache';
if (! file_exists ( $dir )) {
	mkdir ( $dir );
}
if (! file_exists ( $cacheDir )) {
	mkdir ( $cacheDir );
}
$clone = new CurlMulti_My_Clone ( $url, $dir );
$clone->overwrite = true;
$clone->getCurl ()->maxThread = 3;
$clone->getCurl ()->cache ['enable'] = true;
$clone->getCurl ()->cache ['enableDownload'] = true;
$clone->getCurl ()->cache ['dir'] = $cacheDir;
$clone->getCurl ()->cache ['compress'] = true;
$clone->start ();