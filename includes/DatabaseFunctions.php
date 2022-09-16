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