<!DOCTYPE html>
<head>
    <title>Регистрация на сайте</title>
</head>
<?php
session_start();
  if(!isset($_SESSION['count']))$_SESSION['count']  =  0;
  $_SESSION['count']++;
require_once("assets/inc/head.inc"); 
require_once("assets/inc/header.inc");
require_once("assets/inc/nav.php");
echo "Имя сессии: ".session_name()."  ID: ".session_id();
?>
<p>В текущей сессии вы открыли страницу <?=$_SESSION['name']."  ".$_SESSION['count']?> раз.</p>
<p>Открыть пример в <a href="<?=$_SERVER['SCRIPT_NAME']?>">этой вкладке</a>.</p>

<main>

<?php
require_once("assets/inc/aside.inc"); 
?>

<section>
<!-- <p>Main block</p> -->
<!-- Навигация: хлебные крошки: -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Главная</a></li>
    <li class="breadcrumb-item active" aria-current="page">Регистрация на сайте</li>
  </ol>
</nav>

<h4>Регистрация на сайте</h4>

<form class="account_registration" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Электронный адрес:</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Введите Ваш email">
    <small id="emailHelp" class="form-text text-muted">Данные используются только для вашей идентификации на сайте.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Пароль:</label>
    <input type="password" name="psw" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
    <small id="emailHelp" class="form-text text-muted">Введите пароль ещё раз для проверки ввода:</small>
    <input type="password" name="psw_check" class="form-control" id="exampleInputPassword2" placeholder="Введите пароль повторно">
  </div>
  <button type="submit" class="btn btn-primary">Отправить</button>
</form>


<?php 
// Проводим проверку регистрации
// Подключаем файл с функциями авторизации пользователя и уведомлениями
require_once("assets/inc/customers_functions.php"); 
// Проверяем данные из формы:
if (!empty($_POST["email"])&&!empty($_POST["psw"])){
    if (($_POST["psw"]) == ($_POST["psw_check"])){
    $user_email_valid = htmlentities($_POST["email"]);
    $user_psw_valid = htmlentities($_POST["psw"]);
    }
    else {
        alert_login('passwords_dont_match',0,'');
        exit();
    }
// Проверяем введенные данные   
echo "<br/> e-mail: ".$user_email_valid;
echo "<br/> password: ".$user_psw_valid;

//echo "<br/>";
//print_r($_POST);

// Проводим проверку авторизации на наличие e-mail в базе данных
// Подлючаем базу клиентов
echo check_exists_email_in_customers_table($user_email_valid, $user_psw_valid);

// Проводим авторизацию клиента
// authorization()

}
else
{
//echo "<br/>Переменные не дошли. Проверьте все еще раз.";
}

?>



</section>
</main>
<? 
require("assets/inc/footer.inc")
?>