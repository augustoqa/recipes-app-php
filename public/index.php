<?php

require __DIR__ . '/../includes/autoload.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
	
$recipeWeb = new RecipeWeb();
$entryPoint = new EntryPoint($recipeWeb);
$entryPoint->run($uri);