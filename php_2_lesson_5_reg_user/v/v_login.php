<?php
/**
 * Шаблон входа в систему
 * ================
 * $text - текст на странице входа в систему
 */
?>

<form method="post">
    <p><?=$text?></p>
	<input type="text" name="login">
    <input type="password" name="password">
	<input type="submit" name="login_submit" value="Войти в систему" />
</form>