<a href="editrecipe.php">Add a new Recipe</a>
<p><?= $totalRecipes ?> total recipes in the database.</p>
<hr />
<table border="1">
	<thead>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Class Recipe</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recipes as $recipe): ?>
		<tr>
			<td><?= $recipe['id'] ?></td>
			<td><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') ?></td>
			<td><?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8') ?></td>
			<td>
				<form method="post" action="deleterecipe.php">
					<input type="hidden" name="id" value="<?= $recipe['id'] ?>">
					<button type="submit">Delete</button>
				</form>
				<form action="editrecipe.php" method="post">
					<input type="hidden" name="id" value="<?= $recipe['id'] ?>">
					<button type="submit">Edit</button>
				</form>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>