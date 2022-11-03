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
	include __DIR__ . '/../controllers/AuthorController.php';

	$authorTable = new DatabaseTable($pdo, 'authors');
	$recipesTable = new DatabaseTable($pdo, 'recipes');
	$recipeClassesTable = new DatabaseTable($pdo, 'recipe_classes');


	$controllerName = $_GET['controller'] ?? 'recipe';
	$action = $_GET['action'] ?? 'home';

	if ($controllerName === 'recipe') {
		$controller = new RecipeController($recipesTable, $recipeClassesTable);
	} else if ($controllerName === 'author') {
		$controller = new AuthorController($authorTable);
	}

	if ($controllerName == strtolower($controllerName) && $action == strtolower($action)) {
		$page = $controller->$action();
	} else {
		http_response_code(301);
		header('"location: index.php?controller=' . strtolower($controllerName) . '&action=' . strtolower($action));
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