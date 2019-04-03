<?php
// Формируем переменные для передачи в шаблон загрузки данных из Базы данных
$images_on_page = 9;
$current_page = $_POST['current_page'] + $images_on_page * (int)$_POST['pagination_button'];
if ($current_page < 0) { $current_page = 0;}
// Подключаем базу данных
require_once('assets/inc/pdo.php');
// Формируем переменные для передачи в шаблон page_tamplate.tmpl
$title = 'Новая галерея';
// Подключаем шаблон
require_once('assets/inc/twig_connect.php');
// Функция изменения популярности товаров. После просмотра фотографии происходит обновление страницы.
include_once("assets/inc/change_popularity.php");
//change_popularity();
?>