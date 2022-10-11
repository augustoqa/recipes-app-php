<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../classes/DatabaseTable.php';
	include __DIR__ . '/../controllers/RecipeController.php';

	$recipesTable = new DatabaseTable($pdo, 'recipes');
	$recipeClassesTable = new DatabaseTable($pdo, 'recipe_classes');

	$recipeController = new RecipeController($recipesTable, $recipeClassesTable);

	$action = $_GET['action'] ?? 'home';
	$page = $recipeController->$action();

	$title = $page['title'];
	$output = $page['output'];
} catch (PDOException $e) {
	$title = "An error has ocurred";
	$output = sprintf("Database error: %s in %s:%s",
		$e->getMessage(),
		$e->getFile(),
		$e->getLine()
	);
}

include __DIR__ . '/../templates/layout.html.php';