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
			<td><?= $recipe['title'] ?></td>
			<td></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>