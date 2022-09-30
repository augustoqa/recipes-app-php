<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../includes/DatabaseFunctions.php';

	$rows = findAll($pdo, 'recipes');

    $recipes = [];
    foreach ($rows as $row) {
        $recipe_class = find($pdo, 'recipe_classes', 'id', $row['recipe_classes_id'])[0];

        $recipes[] = [
			'id'          => $row['id'],
			'title'       => $row['title'],
			'description' => $recipe_class['description'],
        ];
    }

	$totalRecipes = total($pdo, 'recipes');

	$title = 'List of Recipes';

	ob_start();

	include __DIR__ . '/../templates/recipes/recipes.html.php';

	$output = ob_get_clean();
} catch (PDOException $e) {
	$title = 'Error';
	$output = $e->getMessage();
}


include __DIR__ . '/../templates/layout.html.php';