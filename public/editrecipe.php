<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../includes/DatabaseFunctions.php';

	if (isset($_POST['title'])) {
		update($pdo, 'recipes', 'id', [
			'id'          => $_POST['recipeId'],
			'title'       => $_POST['title'],
			'preparation' => $_POST['preparation'],
			'notes'       => $_POST['notes'],
		]);

		header('location: recipes.php') ;
	} else {
		$recipe = find($pdo, 'recipes', 'id', $_POST['id'])[0];

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