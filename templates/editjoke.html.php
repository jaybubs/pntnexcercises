<?php if (empty($joke->id) || $user->id == $joke->authorId || $user->hasPermission(\Ijdb\Entity\Author::JOKES_EDIT)): ?>
<form action="" method="post"> 
	<input type="hidden" name="joke[id]" value="<?=$joke->id ?? ''?>"/>
	<label for="joketext">Type here:</label>
	<textarea name="joke[joketext]" id="joketext" rows="3" cols="40"><?=$joke->joketext ?? ''?></textarea>

	<p>Select categories for this joke:</p>
	<?php foreach ($categories as $category): ?>

        <?php if ($joke && $joke->hasCategory($category->id)): ?>
            <input type="checkbox" checked value="<?=$category->id?>" name="category[]"/>
        <?php else: ?>
            <input type="checkbox" value="<?=$category->id?>" name="category[]"/>
        <?php endif; ?>

		<label><?=$category->name?></label>
	<?php endforeach; ?>

	<input type="submit" value="Save">
</form>
<?php else: ?>
<p>You may only edit jokes that you posted.</p>
<?php endif; ?>
