<form action="" method="post" accept-charset="utf-8">
	<input type="hidden" value="<?=$category->id ?? ''?>" name="category[id]">
    <label for="categoryname">Enter category name:</label>
    <input type="text" name="category[name]" value="<?=$catgeory->name ?? ''?>" id="categoryname"/>
	<input type="submit" value="Save" name="submit">
</form>
