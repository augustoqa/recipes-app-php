<?php 

class RecipeWeb {
	public function defaultRoute()
	{
		return 'recipe/home';
	}

	public function getController($controllerName)
	{
		include __DIR__ . '/../includes/DatabaseConnection.php';
		include __DIR__ . '/../controllers/RecipeController.php';
		include __DIR__ . '/../controllers/AuthorController.php';

		$authorTable = new DatabaseTable($pdo, 'authors');
		$recipesTable = new DatabaseTable($pdo, 'recipes');
		$recipeClassesTable = new DatabaseTable($pdo, 'recipe_classes');

		if ($controllerName === 'recipe') {
			$controller = new RecipeController($recipesTable, $recipeClassesTable);
		} else if ($controllerName === 'author') {
			$controller = new AuthorController($authorTable);
		}

		return $controller;
	}
}