<?php

function loadTemplate($template, $variables = [])
{
	extract($variables);

	ob_start();

	include __DIR__ . "/../templates/{$template}";

	return ob_get_clean();
}

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../classes/DatabaseTable.php';
	include __DIR__ . '/../controllers/RecipeController.php';

	$recipesTable = new DatabaseTable($pdo, 'recipes');
	$recipeClassesTable = new DatabaseTable($pdo, 'recipe_classes');

	$recipeController = new RecipeController($recipesTable, $recipeClassesTable);

	$action = $_GET['action'] ?? 'home';
	if ($action == strtolower($action)) {
		$page = $recipeController->$action();
	} else {
		http_response_code(301);
		header('location: index.php?action=' . strtolower($action));
		exit;
	}

	$title = $page['title'];
	$variables = $page['variables'] ?? [];
	$output = loadTemplate($page['template'], $variables);
} catch (PDOException $e) {
	$title = "An error has ocurred";
	$output = sprintf("Database error: %s in %s:%s",
		$e->getMessage(),
		$e->getFile(),
		$e->getLine()
	);
}

include __DIR__ . '/../templates/layout.html.php';