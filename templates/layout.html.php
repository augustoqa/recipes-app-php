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
			<li><a href="/recipe/list">Recipes List</a></li>
			<li><a href="/recipe/edit">Add a new Recipe</a></li>
		</ul>
	</nav>
	<h1><?= $title ?></h1>

	<?= $output ?>

	<footer>
		Copyright&copy; <?= date('Y') ?>
	</footer>
</body>
</html>