<?php
/**
 * Шаблон выхода из системы
 * ================
 * $text - текст на странице выхода из системы
 */
?>

<form method="post">
    <p><?=$text?></p>
	<input type="submit" name="logout_submit" value="Выйти из системы" />
</form>