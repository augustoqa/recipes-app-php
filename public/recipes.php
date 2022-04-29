<?php

try {
	$pdo = new PDO('mysql:host=localhost;dbname=recipes;utf-8', 'root', 'admin');

	$stmt = $pdo->prepare("SELECT * FROM `recipes`");
	$stmt->execute();
	$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$title = 'List of Recipes';

	ob_start();

	include __DIR__ . '/../templates/recipes/recipes.html.php';

	$output = ob_get_clean();
} catch (PDOException $e) {
	$title = 'Error';
	$output = $e->getMessage();
}


include __DIR__ . '/../templates/layout.html.php';