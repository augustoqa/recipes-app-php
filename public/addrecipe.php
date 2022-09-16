<?php 

if (isset($_POST['title'])) {
	try {
		include __DIR__ . '/../includes/DatabaseConnection.php';
		include __DIR__ . '/../includes/DatabaseFunctions.php';

		addRecipe($pdo, $_POST['title'], $_POST['preparation'], $_POST['notes'], 1);

		header('location: recipes.php');
	} catch (PDOException $e) {
		$title = 'An error has ocurred';
		$output = sprintf('Database error: %s in %s:%s',
			$e->getMessage(),
			$e->getFile(),
			$e->getLine()
		);
	}
} else {
	$title = 'Add a Recipe';

	ob_start();

	include __DIR__ . '/../templates/recipes/addrecipe.html.php';

	$output = ob_get_clean();
}


include __DIR__ . '/../templates/layout.html.php';