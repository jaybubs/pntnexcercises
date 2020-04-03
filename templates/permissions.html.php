<h2>Edit <?=$author->name?>'s Permissions</h2>

<form action="" method="post" accept-charset="utf-8">
<?php foreach ($permissions as $name => $value): ?>
<div>
<input type="checkbox" value="<?=$value?>" name="permissions[]" <?php if ($author->hasPermission($value)): echo 'checked'; endif; ?> />
<label><?=$name?></label>
</div>
<?php endforeach; ?>

<input type="submit" value="submit"/>
</form>
