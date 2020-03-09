<?php
if (!empty($errors)):
?>
<div id="errors" class="errors">
	<p>Your account could not be created, please check the following:</p>
<ul>
<?php
foreach ($errors as $error):
?>
<li><?= $error ?></li>
<?php
	endforeach; ?>
</ul>
</div>
<?php
endif;
?>

<form action="" method="post" accept-charset="utf-8">

<label for="email">Your email addresss</label><input type="text" name="author[email]" value="<?=$author['email'] ?? ''?>" id="email">

<label for="name">Your name</label><input type="text" name="author[name]" value="<?=$author['name'] ?? ''?>" id="name">

<label for="password">Your password</label><input type="password" name="author[password]" value="<?=$author['password'] ?? ''?>" id="password">

<input type="submit" value="Register account" name="submit" id="submit"/>

</form>
