<?php

function totalRecipes($database)
{
	$stmt = $database->prepare('SELECT COUNT(*) AS `total` FROM `recipes`');
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	return $row['total'];
}