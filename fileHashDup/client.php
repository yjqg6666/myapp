<?php

$gmclient= new GearmanClient();
$gmclient->addServer();

echo 'Sending job' . PHP_EOL;
$path = realpath('/'); 
$count = 0;
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename) { 
	$filename = '/' . ltrim($filename, '/');
	if (substr($filename, -1) == '.') continue;
	if (strstr($filename, '/.svn/') || strstr($filename, '/.git/')) continue;
	if (is_link($filename)) continue;
	if (substr($filename, 0, 6) == '/proc/') continue;
	$count ++;
	echo $count . ' ' . $filename . PHP_EOL;
    $result = $gmclient->doBackground("hashFile", $filename);
} 

