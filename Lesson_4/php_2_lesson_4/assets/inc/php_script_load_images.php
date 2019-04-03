<?php
// print the graphic files from the MySQL with ID
function print_graphic_from_MySQL_with_id($quantity) {
    $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images');
    // Проверяем подключение базы данных
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться к Базе данных: %s\n", mysqli_connect_error());
        exit();
    }
    // Устанавливаем кодировку соединения
    mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");

    // Запрашиваем данные из базы данных
    $mysql_query = mysqli_query($mysql, "SELECT * FROM options ORDER BY popularity DESC ;");
    $images = [];

    // Помещаем данные в массив и выводим на экран
    $count = 0;
?>
    <div class="card-deck">
<?php
    while ($row = mysqli_fetch_assoc($mysql_query)) {
        $images[] = $row;
        // Просмотр значений в массиве
        //var_dump ($images);
        //echo $images[$count]['image_file_path'].$images[$count]['image_file_name'];
        //echo "<br/><br/>";
        $id_product = $images[$count]['id'];

?>
        <form class="card" action="cart-product-page.php" method="post" name="<?=$images[$count]['id']?>">
            <img src="<?=$images[$count]['thumbnail_path'].$images[$count]['image_file_name']?>" alt="<?=$images[$count]['image_name']?>" action="cart-product-page.php" class="card-img-top" method="post" name="<?$images[$count]['id']?>">
            
            <div class="card-body">
                <h5 class="card-title"><?=$images[$count]['image_name']?></h5>
                <p class="card-text"><?=$images[$count]['price']." руб."?></p>
                <p class="card-text"><small class="text-muted">Популярность: <?=$images[$count]['popularity']?></small></p>  
            </div>
            <div class="card-footer">
                <button name="id_product" value="<?=$id_product?>" class="btn btn-outline-secondary">Просмотр</a>
            </div>    
        </form>
<?php
        // all graphic files from the folder
        // echo "<div>";
        // echo "<form action='cart-product-page.php' class='product-gallery' method='post' name='".$images[$count]['id']."'>";
        // echo "<a id='myModal' href='".$images[$count]['image_file_path'].$images[$count]['image_file_name']. "'><img src='". $images[$count]['thumbnail_path'].$images[$count]['thumbnail_name']. "'alt='". $images[$count]['image_name']. "'name='". $images[$count]['popularity']. "' width=200px;></a>";
        // echo "<p>". $images[$count]['image_name']. "</p>";
        // echo "<button name='id_product' value='$id_product' class='button_view'>Просмотр</a>";
        // echo "</form>";
        // echo "</div>";
        //echo "<a id='myModal' href='".$images[$count]['thumbnail_path'].$images[$count]['thumbnail_name']. "'><img src='". $images[$count]['image_file_path'].$images[$count]['image_file_name']. "' width=200px;'></a>";
        $count++;
    }
    //var_dump ($images);
    //print_on_screen($images);
?>
    </div> 
<?php
    // $dir = opendir ("$path_thumbnails"); // open the folder
    // while (false !== ($file = readdir($dir))) {
    //     // graphic files from the folder
    //     if(!is_dir($file) && (strpos($file, '.jpg')>0 || strpos($file, '.gif')>0 || strpos($file, '.png')>0) ) {
    //         echo "<a id='myModal' href='". $path_images. $file. "'><img src='". $path_thumbnails. $file. "' width=150px;'></a>";  
    //     }
    // }
    // closedir($dir); // close the folder

    mysqli_close($mysql);
    return;
}


// Функция загрузки файлов и их опций в Базу данных
function load_image_from_dir_to_DBase($path_thumbnails,$path_images) {
    // Открываем базу данных
    $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images');
    // Проверяем подключение базы данных
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться к Базе данных: %s\n", mysqli_connect_error());
        exit();
    }
    // Устанавливаем кодировку соединения
    mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");

    // Формируем массив картинок загрузкой граф.файлов из категории
    $Images_from_dir = [];
    $count = 0; // Счетчик для названия товаров
    $dir = opendir ("$path_thumbnails"); // open the folder
    while (false !== ($file = readdir($dir))) {
        // graphic files from the folder
        if(!is_dir($file) && (strpos($file, '.jpg')>0 || strpos($file, '.gif')>0 || strpos($file, '.png')>0) ) {
            //print "Файл: ".$path_images.$file."<br/>";
            $Images_from_dir = [
                'id'                => null,
                'image_file_name'   => $file,
                'image_file_size'   => filesize($path_images.$file),
                'image_file_path'   => $path_images, //'assets/images/', 
                'thumbnail_name'    => $file, 
                'thumbnail_path'    => $path_thumbnails,  //'assets/images/thumbnails/'
                'popularity'        => '3', 
                'image_name'        => "Товар ".$count,
            ];
        // Отправляем массив на загрузку в БД
        mysqli_insert($mysql, 'options', $Images_from_dir);  
        $count++;  
        //echo "<br/><br/>";
        }
        // Проверяем содержимое массива в его отддельных ячейках
        //print $Images_from_dir[$count];
        //echo "<br/><b>Товар ".$count.": </b>".$Images_from_dir["image_file_name"];
        
        //var_dump ($Images_from_dir);
    }
    // Закрываем доступ к директории к исходными картинками
    closedir($dir); // close the folder

    // Тестовый массив для заливки в базу
    // $Images_from_dir_2 = [
    //     'id'                => '1',
    //     'image_file_name'   => 'bryuki-marta-1424-1-3.jpg',
    //     'image_file_size'   => filesize($path_images.$file),
    //     'image_file_path'   => $path_images, //'assets/images/', 
    //     'thumbnail_name'    => 'bryuki-marta-1424-1-3.jpg', 
    //     'thumbnail_path'    => $path_thumbnails,  //'assets/images/thumbnails/'
    //     'popularity'        => '1', 
    //     'image_name'        => "Товар ".$count++,
    // ];
    // Проверяем массив на соответствие
    // var_dump ($Images_from_dir_2);
    // Отправляем массив на загрузку в БД
    //mysqli_insert($mysql, 'options', $Images_from_dir);

    // Печатаем на экране содержимое БД
    $mysql_query = mysqli_query($mysql, "SELECT * FROM options ORDER BY options.image_file_name DESC ;");
    $br = '<br/>';
    $images = [];
    while ($row = mysqli_fetch_assoc($mysql_query)) {
        $images[] = $row;
    }
    print_on_screen($images);
}

// Функция по добавлению данных о файле в MySQL
function mysqli_insert($mysql, $table, $inserts) {
    // $values = array_map("mysqli_real_escape_string", array_values($inserts));
    $values = array_values($inserts);
    $keys = array_keys($inserts);
    
    // Приводим массивы к форме и содержанию для добавления в MySQL
    // print "INSERT INTO ".$table." (".implode(",", $keys).") VALUES (".implode(",", $values)";
    $table = "`".$table."`";
    $keys = "`".implode("`, `", $keys)."`";
    $values = "'".implode("', '", $values)."'";

    // Проверяем соответствие формы и содержания массива для заливки в базу MySQL
    echo "<br/><br/>"; var_dump ($mysql);
    echo "<br/><br/>"; var_dump ($table);
    echo "<br/><b>Keys: </b><br/>"; var_dump ($keys);
    echo "<br/><b>Values: </b><br/>"; var_dump ($values);

    // Подготавливаем массив по синтаксису MySQL: $query = "INSERT INTO $table($keys) VALUES ($values);";

    // Готовый Код для заливки:
    // INSERT INTO `options`(`id`, `image_file_name`, `image_file_size`, `image_file_path`, `thumbnail_name`, `thumbnail_path`, `popularity`, `image_name`) 
    // VALUES ('', 'halat-zhenskij-venera-mart-ru-cvetok-persika.jpg', '64505', 'assets/images/', 'halat-zhenskij-venera-mart-ru-cvetok-persika.jpg', 'assets/images/thumbnails/', '3', 'Товар 1')
    $query = "INSERT INTO $table($keys) VALUES ($values);";
    echo "<br/><b>Query</b><br/>";
    var_dump ($query);
    echo "<br/><br/>";

    // Заливаем исполняющий код в MySQL
    // mysqli_query($mysql, $query);
    var_dump (mysqli_query($mysql, $query)); 
    return; //mysqli_query($table, "INSERT INTO '".$table."'' ('".implode("','", $keys)."') ) VALUES (\'".implode("\',\'", $values)."\')");
}
?>

<?
function print_on_screen($images) {
    ?>
    <!-- Выводим данные о файлах из БД (сейчас находятся в массиве $images) на экран -->
    <ul style="width: 60%">
        <? foreach ($images as $image) : ?>
            <li style="display: flex; justify-content: space-between">
            <?
            foreach ($image as $key => $value):
                echo $br;
                ?>
                <string style="text-align:left"><?= ($key == 'id') ? '<strong>' . $value . '</strong>' : $value; ?></string>
            <? endforeach;
            echo $br; ?>
            </li><?
        endforeach; ?>
    </ul>
    <?
}   ?>