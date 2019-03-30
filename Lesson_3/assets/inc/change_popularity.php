<?
function change_popularity($id_product) {
    $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images');
    // Проверяем подключение базы данных
    if (mysqli_connect_errno()) {
        printf("Не удалось подключиться к Базе данных: %s\n", mysqli_connect_error());
        exit();
    }
    // Устанавливаем кодировку соединения
    mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");

    // Запрашиваем данные из базы данных
    // $mysql_query = mysqli_query($mysql, "SELECT `popularity` FROM `options` WHERE `id`='220';");
    $mysql_query = mysqli_query($mysql, "SELECT `popularity` FROM `options` WHERE `id`=$id_product;");

    while ($row = mysqli_fetch_assoc($mysql_query)) {
        $images[] = $row;
    }
    // Повышаем популярность просмотренного товара
    $count = $images[0]['popularity'];
    $count++;
    // Обновляем популярность в базе данных
    $mysql_query = mysqli_query($mysql, "UPDATE `options` SET `popularity`=$count WHERE `id`=$id_product;");

    mysqli_close($mysql);
}
?>