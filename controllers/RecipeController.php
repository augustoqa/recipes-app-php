<?php

class RecipeController {
	private DatabaseTable $recipesTable;
	private DatabaseTable $recipeClassesTable;

	public function __construct(DatabaseTable $recipesTable, DatabaseTable $recipeClassesTable)
	{
		$this->recipesTable = $recipesTable;
		$this->recipeClassesTable = $recipeClassesTable;
	}

	public function home()
	{
		ob_start();

		include __DIR__ . '/../templates/index.html.php';

		return [
			'title'  => 'Index',
			'output' => ob_get_clean(),
		];
	}

	public function list()
	{
		$rows = $this->recipesTable->findAll();

	    $recipes = [];
	    foreach ($rows as $row) {
	        $recipe_class = $this->recipeClassesTable->find('id', $row['recipe_classes_id'])[0];

	        $recipes[] = [
				'id'          => $row['id'],
				'title'       => $row['title'],
				'description' => $recipe_class['description'],
	        ];
	    }

		$totalRecipes = $this->recipesTable->total();

		ob_start();

		include __DIR__ . '/../templates/recipes/recipes.html.php';

		return [
			'title'  => 'List of Recipes',
			'output' => ob_get_clean(),
		];
	}

	public function edit()
	{
		if (isset($_POST['recipe'])) {
			$recipe = $_POST['recipe'];
			$recipe['recipe_classes_id'] = 1;
			$this->recipesTable->save($recipe);

			header('location: index.php?action=list') ;
		} else {
			$title = 'Add Recipe';

			if (isset($_POST['id'])) {
				$recipe = $this->recipesTable->find('id', $_POST['id'])[0];
				$title = 'Edit Recipe';
			}

			ob_start();

			include __DIR__ . '/../templates/recipes/editrecipe.html.php';
		}

		return [
			'title'  => $title,
			'output' => ob_get_clean(),
		];
	}

	public function delete()
	{
		$this->recipesTable->delete($_POST['id']);

		header('location: index.php?action=list');
	}
}