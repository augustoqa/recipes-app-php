<?php

require __DIR__ . '/../classes/EntryPoint.php';
require __DIR__ . '/../classes/RecipeWeb.php';

$uri = strtok(ltrim($_SERVER['REQUEST_URI'], '/'), '?');
	
$recipeWeb = new RecipeWeb();
$entryPoint = new EntryPoint($recipeWeb);
$entryPoint->run($uri);