<!DOCTYPE html>
<?php
    // Очищаем данные из формы, перезагружаем страницу
    if (!empty($_POST['del_product_from_basket'])){
        // echo $_POST['del_product_from_basket'];
        del_row_from_basket($_POST['del_product_from_basket']);
        //header("Location:".$_SERVER['PHP_SELF']);
    }
?>
<head>
    <title>Карточка товара</title>
</head>

<?php
// Страница карточки товара
session_start();
require_once("assets/inc/head.inc"); 
require_once("assets/inc/header.inc");
require_once("assets/inc/nav.php");
?>

<main>

<?php
// require_once("assets/inc/aside.inc"); 
?>

<section>
<!-- <p>Main block</p> -->

<!-- Навигация: хлебные крошки: -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Галерея</a></li>
    <li class="breadcrumb-item active" aria-current="page">Корзина</li>
  </ol>
</nav>

<!-- Блок списка корзины -->
<!-- Выводим шапку таблицы корзины -->
<table class="table table-hover">
  <thead>
    <tr>
      <th colspan="2" scope="col" style='text-align:center;'>Товар</th>
      <th scope="col">Цена</th>
      <th scope="col">Кол-во</th>
      <th scope="col">Стоимость</th>
      <th scope="col">Удалить</th>
    </tr>
  </thead>
  <tbody>
    <form method="post">

<!-- Подготавливаем и выводим содержимое корзины -->
<?php
    // Подключаемся к базе или выводим ошибку
    $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images')
    or die ("Ошибка подключения к Базе данных: %s\n".mysqli_error($mysql));   

    // Устанавливаем кодировку соединения
    mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");

    // Подготавливаем 1-ю часть запроса о данных о всех корзинах из базы данных 
    $query = "SELECT  customers_baskets.id_customer, customers_baskets.id_session, basket.id_basket, basket.id_product, basket.quantity, options.thumbnail_path, options.thumbnail_name, options.image_name, options.price 
            FROM images.customers_baskets 
            inner join images.basket on customers_baskets.id_basket = basket.id_basket
            inner join images.options on options.id = basket.id_product";
    
    // Запрашиваем код текущей сессии пользователя 
    $session_id = session_id();
    // Добавляем строку запроса 
    $query .= " WHERE customers_baskets.id_session='".$session_id."';";
    // echo $query;
    // Направляем итоговый запрос в базу данных 
    $mysql_query = mysqli_query($mysql,$query);
    // var_dump (mysql_query);
    $basket = [];

    // Помещаем данные в массив и выводим таблицу корзины на экран
    $count = 0;
    while ($row = mysqli_fetch_assoc($mysql_query)) {
        $basket[] = $row;
        // Просмотр значений в массиве
        //var_dump ($basket);
        $product_image = $basket[$count]['thumbnail_path'].$basket[$count]['thumbnail_name'];
        $product_name = $basket[$count]['image_name'];
        $product_price = $basket[$count]['price'];
        $product_quantity = $basket[$count]['quantity'];
        $product_sum = $product_price * $product_quantity;
        $id_basket = $basket[$count]['id_basket'];
        // echo $id_basket." ";
        row_basket($product_image,$product_name,$product_price,$product_quantity,$product_sum,$id_basket);
        $count++;
        $basket_summ += $product_sum;
    }    
    function row_basket($product_image,$product_name,$product_price,$product_quantity,$product_sum,$id_basket) {
        echo "<tr>
            <td><img src=".$product_image." style='height:4rem;'></td>
            <th scope='row'>'".$product_name."</th>
            <td>".$product_price."</td>
            <td style='text-align:center;'>".$product_quantity."</td>
            <td>".$product_sum."</td>
            <td>
              <button type='hidden' style='cursor:pointer; color:brown;' name='del_product_from_basket' value='$id_basket'>&times;</button></td>
            </tr>";
    }    
    function del_row_from_basket($id_basket) {
      // Подключаемся к базе или выводим ошибку
      $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images')
      or die ("Ошибка подключения к Базе данных: %s\n".mysqli_error($mysql));   

      // Устанавливаем кодировку соединения
      mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");
      // Удаляем отмеченные товары из корзины

      if (!empty($_POST['del_product_from_basket'])){
        $query_del_1 = "DELETE FROM `basket` WHERE `basket`.`id_basket`=$id_basket";
        $query_del_2 = "DELETE FROM `customers_baskets` WHERE `customers_baskets`.`id_basket`=$id_basket";
        mysqli_query($mysql,$query_del_1);
        mysqli_query($mysql,$query_del_2);
      }  
    }

    // Закрываем базу данных
    mysqli_close($mysql);
?>

    <tr>
        <th colspan="4" scope="col" style='text-align:center;'>Товаров в корзине: </th>
        <th scope="col"><?=$basket_summ?></th>
        <th scope="col">руб.</th>
    </tr>
<!-- Закрываем таблицу корзины товаров -->
    </form>
  </tbody>
</table>

</section>
</main>
<? 
require("assets/inc/modal_popup.php");
require("assets/inc/footer.inc");
?>