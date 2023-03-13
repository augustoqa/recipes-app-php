<?php 

namespace Recipe;

use Ninja\DatabaseTable;
use Recipe\Controllers\RecipeController;
use Recipe\Controllers\AuthorController;

class RecipeWeb {
	public function defaultRoute()
	{
		return 'recipe/home';
	}

	public function getController($controllerName)
	{
		$pdo = new \PDO('mysql:host=localhost;dbname=recipes;charset=utf8mb4', 'root', '');
		$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

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