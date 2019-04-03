<?php
// подгружаем и активируем авто-загрузчик Twig-а
require_once 'assets/Twig/Autoloader.php';
Twig_Autoloader::register();
try {
  // указывае где хранятся шаблоны
  $loader = new Twig_Loader_Filesystem('assets/templates');
  
  // инициализируем Twig
  $twig = new Twig_Environment($loader);
  

  // подгружаем шаблон
  $template = $twig->loadTemplate('page_template.tmpl');
  
  // передаём в шаблон переменные и значения
  // выводим сформированное содержание
  $content = $template->render(array (
    'title' =>  $title,
    'images' => $images,
    'current_page' => $current_page
  ));
  // echo $images[1]['image_name'];
  echo $content;
  
} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
?>