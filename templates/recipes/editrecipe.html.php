<form action="" method="POST">
	<input type="hidden" name="recipeId" value="<?= $recipe['id'] ?>">
	<div>
		<label for="title">Title</label>
		<input type="text" name="title" id="title" value="<?= $recipe['title'] ?>">
	</div>
	<div>
		<label for="preparation">Preparation</label>
		<textarea name="preparation" id="preparation" cols="30" rows="5"><?= $recipe['preparation'] ?></textarea>
	</div>
	<div>
		<label for="notes">Notes</label>
		<textarea name="notes" id="notes" cols="30" rows="5"><?= $recipe['notes'] ?></textarea>
	</div>
	<div>
		<button type="submit">Save</button>
	</div>
</form>