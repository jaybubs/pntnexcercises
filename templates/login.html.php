<?
if (isset($error)):
	echo '<div class="errors">'.$error.'</div>';
endif;
?>
<form action="" method="post" accept-charset="utf-8">
	<label for="email">Your email address</label><input type="text" name="email" value="" id="email">
<label for="password">Your password</label><input type="password" name="password" value="" id="password">
<input type="submit" value="Log in" name="login" id="login"/>
</form>

<p>Don't have an account? <a href="/author/register" target="_blank">Click here to register an account</a></p>
