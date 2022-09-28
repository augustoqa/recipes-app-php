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

function addRecipe($database, array $fields)
{
	$sql = sprintf('INSERT INTO `recipes` SET %s', getSqlPlaceholder($fields));

	query($database, $sql, getParameters($fields));
}

function editRecipe($database, array $fields)
{
	$sql = sprintf('UPDATE `recipes` SET %s WHERE `id` = :id', getSqlPlaceholder($fields));

	query($database, $sql, getParameters($fields));
}

function deleteRecipe($database, $id)
{
	query($database, 'DELETE FROM `recipes` WHERE `id` = :id', [':id' => $id]);
}

function getSqlPlaceholder($fields): string
{
	$sql = '';
	foreach (array_keys($fields) as $field) {
		$sql .= "`${field}` = :${field},";
	}
	return rtrim($sql, ',');
}

function getParameters($fields): array
{
	$parameters = [];
	foreach($fields as $field => $value) {
		$parameters[":{$field}"] = $value;
	}

	return $parameters;
}