<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?></title>
</head>
<body>
	<nav>
		<ul>
			<li><a href="index.php?controller=recipe&amp;action=list">Recipes List</a></li>
			<li><a href="index.php?controller=recipe&amp;action=edit">Add a new Recipe</a></li>
		</ul>
	</nav>
	<h1><?= $title ?></h1>

	<?= $output ?>

	<footer>
		Copyright&copy; <?= date('Y') ?>
	</footer>
</body>
</html>