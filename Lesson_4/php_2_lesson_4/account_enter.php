<!DOCTYPE html>
<head>
    <title>Личный кабинет</title>
</head>
<?php
session_start();
if(!isset($_SESSION['count']))$_SESSION['count']  =  0;
$_SESSION['count']++;
require_once("assets/inc/head.inc"); 
require_once("assets/inc/header.inc");
require_once("assets/inc/nav.php");
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
    <li class="breadcrumb-item active" aria-current="page">Вход в личный кабинет</li>
  </ol>
</nav>

<h4>Страница доступа в Личный кабинет</h4>

<form class="account_enter" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Электронный адрес:</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Введите Ваш email">
    <small id="emailHelp" class="form-text text-muted">Данные используются только для вашей идентификации на сайте.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Пароль:</label>
    <input type="password" name="psw" class="form-control" id="exampleInputPassword1" placeholder="Введите пароль">
  </div>
  <button type="submit" class="btn btn-primary">Отправить</button>
</form>


<?php 
if (!empty($_POST["email"])&&!empty($_POST["psw"])){

$user_email_valid = htmlentities($_POST["email"]);
$user_psw_valid = htmlentities($_POST["psw"]);
  
echo "<br/> e-mail: ".$user_email_valid;
echo "<br/> password: ".$user_psw_valid;

//echo "<br/>";
//print_r($_POST);

// Проводим проверку авторизации
// Подключаем файл с функциями авторизации пользователя
require_once("assets/inc/customers_functions.php"); 
// Подлючаем базу клиентов
activate_table_customers($user_email_valid, $user_psw_valid);
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

