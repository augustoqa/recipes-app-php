<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../includes/DatabaseFunctions.php';

	if (isset($_POST['title'])) {
		editRecipe($pdo, $_POST['recipeId'], $_POST['title'], $_POST['preparation'], $_POST['notes'], 1);

		header('location: recipes.php') ;
	} else {
		$recipe = getRecipe($pdo, $_POST['id']);

		$title = 'Edit Recipe';

		ob_start();

		include __DIR__ . '/../templates/recipes/editrecipe.html.php';

		$output = ob_get_clean();
	}
} catch (PDOException $e) {
	$title = 'An error has ocurred';
	$output = sprintf('Database error: %s in %s:%s',
		$e->getMessage(),
		$e->getFile(),
		$e->getLine()
	);
}

include __DIR__ . '/../templates/layout.html.php';