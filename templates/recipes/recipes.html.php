<a href="addrecipe.php">Add a new Recipe</a>
<hr />
<table border="1">
	<thead>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($recipes as $recipe): ?>
		<tr>
			<td><?= $recipe['id'] ?></td>
			<td><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') ?></td>
			<td></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>