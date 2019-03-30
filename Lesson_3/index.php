<!DOCTYPE html>
<head>
    <title>Галерея товаров</title>
</head>
<?php
require_once("assets/inc/head.inc"); 
require_once("assets/inc/header.inc");
require_once("assets/inc/nav.php");
require_once('assets/inc/twig_connect.php');
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
    <!-- <li class="breadcrumb-item"><a href="index.php">Галерея</a></li> -->
    <li class="breadcrumb-item active" aria-current="page">Галерея</li>
  </ol>
</nav>

<?php
// Галерея товаров
$path_thumbnails = "assets/images/thumbnails/";
$path_images = "assets/images/";
// php-script to print the graphic files from the folder
include_once("assets/inc/php_script_load_images.php");

// Функция загрузки файлов и опций в Базу данных.
// !!! ИСПОЛЬЗОВАТЬ, ЕСЛИ ТОЛЬКО НЕОБХОДИМО ЗАЛИТЬ ТОВАРЫ В БД MySQL
//load_image_from_dir_to_DBase($path_thumbnails,$path_images);

// Функция выгрузки из Базы данных файлов с изображениями и их размещение в галерее
print_graphic_from_MySQL_with_id($quantity);


// Функция изменения популярности товаров. После просмотра фотографии происходит обновление страницы.
include_once("assets/inc/change_popularity.php");
//change_popularity();

?>

<script>
<?php include_once("assets/js/event_modal_popup.js"); ?>
</script>

</section>
</main>
<? 
require("assets/inc/modal_popup.php");
require("assets/inc/footer.inc")
?>