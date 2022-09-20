<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../includes/DatabaseFunctions.php';

	$recipes = getAllRecipes($pdo);

	$totalRecipes = totalRecipes($pdo);

	$title = 'List of Recipes';

	ob_start();

	include __DIR__ . '/../templates/recipes/recipes.html.php';

	$output = ob_get_clean();
} catch (PDOException $e) {
	$title = 'Error';
	$output = $e->getMessage();
}


include __DIR__ . '/../templates/layout.html.php';