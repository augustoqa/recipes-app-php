<?php

function query($database, $sql, $parameters = [])
{
	$stmt = $database->prepare($sql);
	$stmt->execute($parameters);

	return $stmt;
}

function totalRecipes($database)
{
	$stmt = query($database, 'SELECT COUNT(*) AS `total` FROM `recipes`');
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	return $row['total'];
}

function getRecipe($database, $id)
{
	$stmt = query(
		$database, 
		'SELECT * FROM `recipes` WHERE id = :id',
		[':id' => $id]
	);

	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllRecipes($database)
{
	$sql = 'SELECT `recipes`.`id`, `recipes`.`title`, `recipe_classes`.`description`
				FROM `recipes` INNER JOIN `recipe_classes`
					ON `recipes`.`recipe_classes_id` = `recipe_classes`.`id`
			ORDER BY `recipes`.`id`';

	$stmt = query($database, $sql);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addRecipe($database, $title, $preparation, $notes, $recipeClassId)
{
	$sql = 'INSERT INTO `recipes` SET 
		`title` = :title, 
		`preparation` = :preparation, 
		`notes` = :notes, 
		`recipe_classes_id` = :recipeClassesId';
		
	$parameters = [
		':title' => $title,
		':preparation' => $preparation,
		':notes' => $notes,
		':recipeClassesId' => $recipeClassId,
	];

	query($database, $sql, $parameters);
}

function editRecipe($database, $recipeId, $title, $preparation, $notes, $recipeClassId)
{
	$sql = 'UPDATE `recipes` SET 
		`title` = :title,
		`preparation` = :preparation,
		`notes` = :notes,
		`recipe_classes_id` = :recipeClassesId 
		WHERE `id` = :recipeId';

	$parameters = [
		':title' => $title,
		':preparation' => $preparation,
		':notes' => $notes,
		':recipeClassesId' => $recipeClassId,
		':recipeId' => $recipeId,
	];

	query($database, $sql, $parameters);
}

function deleteRecipe($database, $id)
{
	query($database, 'DELETE FROM `recipes` WHERE `id` = :id', [':id' => $id]);
}