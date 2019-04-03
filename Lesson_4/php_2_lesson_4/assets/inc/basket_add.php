<?
function basket_add_product($id_product) {
    // Проверяем событие "Купить (добавить в корзину)"
    if (!isset($_POST['id_product'])||!isset($_POST['product_quantity'])) {
        // Если пусто, то выходим
        return;
    } 
    // Если получили ID-товара, то записываем товар и его количество в корзину
    $id_product = $_POST['id_product'];
    $product_quantity = $_POST['product_quantity'];

    // Подключаемся к базе или выводим ошибку
    $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images')
        or die ("Ошибка подключения к Базе данных: %s\n".mysqli_error($mysql));   

    // Записываем товар в таблицу корзины
    $record = "INSERT INTO `images`.`basket` (`id_basket`, `id_product`, `quantity`, `date`) VALUES (NULL, '$id_product', '$product_quantity', CURRENT_TIMESTAMP);";
    // echo "Запись в базу basket: ". $record;
    if ($mysql_query = mysqli_query($mysql, $record)) {
        // Если запись прошла успешно:
        // Возвращаем ID последней записи в таблицу заказов для дальнейшей идентификации
        $id_basket = mysqli_insert_id($mysql);
        // echo "<br/>Номер корзины в БД: ". $id_basket;

        // Записываем данные о корзине к идентификатору посетителя
        $id_session = session_id();
        // echo "<br/>Идентификатор пользователя: ". $id_session;
        // Устанавливаем кодировку соединения
        mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");
        // Записываем в базу данных
        $record = "INSERT INTO `images`.`customers_baskets` (`id_basket`, `id_customer`, `date`, `id_session`) VALUES ('$id_basket', NULL, CURRENT_TIMESTAMP, '$id_session');";
        // echo "<br/>Запись в базу customers_basket: ". $record;
        $mysql_query = mysqli_query($mysql, $record);
        // Сообщаем об успешно добавленном товаре в корзину 
        require_once("assets/inc/customers_functions.php"); 
        alert_login("add_to_basket_success",$_POST['product_name'],$_POST['product_quantity']);
    }
    else {
        // Сообщаем о неудачном добавлении товара в корзину 
        require_once("assets/inc/customers_functions.php"); 
        alert_login("add_to_basket_warning",$_POST['product_name'],$_POST['product_quantity']);
    }
    // Закрываем базу данных
    mysqli_close($mysql);
}
?>