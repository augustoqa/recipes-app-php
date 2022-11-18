<?php

require __DIR__ . '/../classes/EntryPoint.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
	
$entryPoint = new EntryPoint();
$entryPoint->run($uri);