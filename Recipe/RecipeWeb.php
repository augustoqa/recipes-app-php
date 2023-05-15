<?php 

namespace Recipe;

use Ninja\Website;
use Ninja\DatabaseTable;
use Recipe\Controllers\RecipeController;
use Recipe\Controllers\AuthorController;

class RecipeWeb implements Website {
	public function defaultRoute(): string
	{
		return 'recipe/home';
	}

	public function getController($controllerName): object
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