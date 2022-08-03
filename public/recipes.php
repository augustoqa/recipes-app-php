<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	include __DIR__ . '/../includes/DatabaseFunctions.php';

	$sql = 'SELECT `recipes`.`id`, `recipes`.`title`, `recipe_classes`.`description`
				FROM `recipes` INNER JOIN `recipe_classes`
					ON `recipes`.`recipe_classes_id` = `recipe_classes`.`id`
			ORDER BY `recipes`.`id`';
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$totalRecipes = totalRecipes($pdo);

	$title = 'List of Recipes';

	ob_start();

	include __DIR__ . '/../templates/recipes/recipes.html.php';

	$output = ob_get_clean();
} catch (PDOException $e) {
	$title = 'Error';
	$output = $e->getMessage();
}


include __DIR__ . '/../templates/layout.html.php';