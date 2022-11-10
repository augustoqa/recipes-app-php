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
		return [
			'title'    => 'Index',
			'template' => 'index.html.php',
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

		return [
			'title'     => 'List of Recipes',
			'template'  => 'recipes/recipes.html.php',
			'variables' => [
				'recipes'      => $recipes,
				'totalRecipes' => $totalRecipes,
			]
		];
	}

	public function edit()
	{
		if (isset($_POST['recipe'])) {
			$recipe = $_POST['recipe'];
			$recipe['recipe_classes_id'] = 1;
			$this->recipesTable->save($recipe);

			header('location: /recipe/list') ;
		} else {
			$title = 'Add Recipe';
			$recipe = null;

			if (isset($_POST['id'])) {
				$recipe = $this->recipesTable->find('id', $_POST['id'])[0];
				$title = 'Edit Recipe';
			}

			return [
				'title'     => $title,
				'template'  => 'recipes/editrecipe.html.php',
				'variables' => [
					'recipe'   => $recipe,
				],
			];
		}
	}

	public function delete()
	{
		$this->recipesTable->delete($_POST['id']);

		header('location: /recipe/list');
	}
}