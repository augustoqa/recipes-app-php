<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../classes/DatabaseTable.php';

	$recipesTable = new DatabaseTable($pdo, 'recipes');
	$recipeClassesTable = new DatabaseTable($pdo, 'recipe_classes');

	$rows = $recipesTable->findAll();

    $recipes = [];
    foreach ($rows as $row) {
        $recipe_class = $recipeClassesTable->find('id', $row['recipe_classes_id'])[0];

        $recipes[] = [
			'id'          => $row['id'],
			'title'       => $row['title'],
			'description' => $recipe_class['description'],
        ];
    }

	$totalRecipes = $recipesTable->total();

	$title = 'List of Recipes';

	ob_start();

	include __DIR__ . '/../templates/recipes/recipes.html.php';

	$output = ob_get_clean();
} catch (PDOException $e) {
	$title = 'Error';
	$output = $e->getMessage();
}


include __DIR__ . '/../templates/layout.html.php';