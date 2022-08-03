<?php

try {
	include __DIR__ . '/../includes/DatabaseConnection.php';
	$stmt = $pdo->prepare("DELETE FROM `recipes` WHERE `id` = :id");
	$stmt->bindValue(':id', $_POST['id']);
	$stmt->execute();

	header('location: recipes.php');
} catch (PDOException $e) {
	$title = "An error has ocurred";
	$output = sprintf("Database error: %s in %s:%s",
		$e->getMessage(),
		$e->getFile(),
		$e->getLine()
	);
}

include __DIR__ . '/../templates/layout.html.php';