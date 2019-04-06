<?php
function text_get()
{
	return file_get_contents('data/text.txt');
}

function text_set($text)
{
	file_put_contents('data/text.txt', $text);
}

// Метод входа в систему, выхода и личный кабинет

function login()
{
	// Вход в систему
	// $login = $_POST['login'];
	// $password = $_POST['password'];
	setcookie ("login", $_POST['login'], time() + 50000); // создаем переменные сессии
	setcookie ("password", $_POST['password'], time() + 50000);
	header('location: index.php');
}

function logout()
{
	// Выход из системы
	if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) { // если пользователь авторизован
		setcookie ("login", $_POST['login'], time() -1); // удаляем переменные куки и выходим из сессии
		setcookie ("password", $_POST['password'], time() -1);
		header('location: index.php');
	}
}

function account()
{
	// Вход в личный кабинет
	if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) { // если пользователь авторизован
		// Действие в личном кабинете
		$alert = 'Вы успешно зашли в личный кабинет';
	}
	else {
		$alert = 'Пожалуйста, сначала Войдите в систему';
	}
	return $alert;
}