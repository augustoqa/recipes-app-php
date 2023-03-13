<?php

require __DIR__ . '/../vendor/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
	
$recipeWeb = new \Recipe\RecipeWeb();
$entryPoint = new \Ninja\EntryPoint($recipeWeb);
$entryPoint->run($uri);