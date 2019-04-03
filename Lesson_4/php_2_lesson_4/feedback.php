<!DOCTYPE html>
<head>
    <title>Отзывы</title>
</head>
<?php
require_once("assets/inc/head.inc"); 
require_once("assets/inc/header.inc");
require_once("assets/inc/nav.php");
?>

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
    <li class="breadcrumb-item active" aria-current="page">Отзывы клиентов</li>
  </ol>
</nav>
<h4>Оставьте Ваш отзыв о товаре:</h4>

<form class=feedback method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Ваше имя:</label>
    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Введите Ваше имя">
    <small id="emailHelp" class="form-text text-muted">Спасибо, что Вы представились</small>
  </div>

    <label for="exampleInputEmail1">Напишите отзыв:</label>
    <textarea name="feedback_text" class="form-control" cols="45" aria-label="With textarea"></textarea>


  <button type="submit" class="btn btn-primary">Отправить</button>
</form>
<br/>

<?php 
// Подключаемся к базе данных
$mysql = mysqli_connect('localhost', 'root', 'mysql', 'feedback');
    // Проверяем подключение базы данных
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться к Базе данных: %s\n", mysqli_connect_error());
        exit();
    }
    // Устанавливаем кодировку соединения
    mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");


// Получаем отзыв     
if (!empty($_POST["name"])&&!empty($_POST["feedback_text"])){
$name_valid = htmlentities($_POST["name"]);
$feedback_text_valid = htmlentities($_POST["feedback_text"]);
//echo "<br/> Имя: ".$name_valid;
//echo "<br/> Отзыв: ".$feedback_text_valid;
//echo "<br/>";

    // Записывааем отзыв в базу данных по примеру:
    // INSERT INTO `feedback`.`options` (`id`, `name`, `feedback_text`, `date`, `accept`) 
    // VALUES (NULL, 'Эдуард', 'Это первый отзыв', CURRENT_TIMESTAMP, '');
    $values = "'NULL', '".$name_valid."', '". $feedback_text_valid."', CURRENT_TIMESTAMP, ''";
    $query = "INSERT INTO `options`(`id`, `name`, `feedback_text`, `date`, `accept`) VALUES ($values);";

    mysqli_query($mysql, $query);
    // var_dump ($mysql);
    alert_feedback("success");
  }
  else
  {
  // echo "<br/>Переменные не дошли. Проверьте все еще раз.";
    alert_feedback("empty");
  }

    // Выводим содержимое отзывов на страницу
    $count = 0;
    $mysql_query = mysqli_query($mysql, "SELECT * FROM options ORDER BY options.id DESC ;");
    $br = '<br/>';
    $feedback = [];

?>
    <h4>Отзывы наших клиентов:</h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Имя</th>
          <th scope="col">Отзыв</th>
          <th scope="col">Дата</th>
          <th scope="col">Одобрен</th>
        </tr>
      </thead>
      <tbody>
<?  
    while ($row = mysqli_fetch_assoc($mysql_query)) {
        $feedback[] = $row;
?>
        <tr>
          <th scope="row"><?=$feedback[$count]['id']?></th>
          <td><?=$feedback[$count]['name']?></td>
          <td><?=$feedback[$count]['feedback_text']?></td>
          <td><?=$feedback[$count]['date']?></td>
          <td><?=$feedback[$count]['accept']?></td>
        </tr>
<?  
    $count++;
    }
?>

      </tbody>
          </table>

<?
    // Закрываем базу данных
    mysqli_close($mysql);

function alert_feedback($alert) {
    switch ($alert) {
        case 'success':
            ?>
            <div class="alert alert-success" role="alert">
                Спасибо! Ваш отзыв направлен на размещение! 
            </div>
            <?
            break;
        case 'empty':
            ?>
            <div class="alert alert-danger" role="alert">
                Введите ваш отзыв в форму и отправьте его. 
            </div>
            <?
            break;    
    }        
}
?>



</section>
</main>
<? 
require("assets/inc/footer.inc")
?>