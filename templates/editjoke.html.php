<form action="" method="post"> 
	<input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
	<label for="joketext">Type here:</label>
	<textarea name="joke[joketext]" id="joketext" rows="3" cols="40"><?=$joke['joketext'] ?? ''?></textarea>
	<input type="submit" value="Save">
</form>
