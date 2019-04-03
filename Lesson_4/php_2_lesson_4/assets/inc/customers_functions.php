<?php

// Функция авторизации - входа в личный кабинет
function activate_table_customers($user_email_valid, $user_psw_valid) {
    // Пожключаемся к серверу
    $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images')
        or die ("Ошибка подключения к Базе данных: %s\n".mysqli_error($mysql));    
    // Устанавливаем кодировку соединения
    mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");
// }
// function authorization() {
    // Проверяем e-mail и пароль // echo "<br/>";
    // Поиск e-mail в таблице базы данных
    $query = "SELECT * FROM `customers` WHERE `email` LIKE '$user_email_valid';";
    // mysqli_query($mysql, $query);

    $mysql_query = mysqli_query($mysql, $query);
    // Проверка наличия email в базе данных
    if (!mysqli_num_rows($mysql_query)) {
        // Если email не найден: // echo "E-mail не найден. Повторите ввод...<br/>"; echo "<b/> E-mail в базе: ".$query;
        alert_login('email_wrong',$user_email_valid,'');
        exit();
    }
    // Проверка пароля на соответствие
    $customer = mysqli_fetch_assoc($mysql_query);
    if ($customer['password'] != $user_psw_valid) {
    // Сообщаем о неверном пароле // echo "<br/> Неверный пароль: ". $user_psw_valid; // echo "<br/> Верный пароль: ". $customer['password']. "<br/> ";
        alert_login('password_wrong',$user_psw_valid,'');
        exit();
    }
    // Сообщаем об успешной авторизации // echo "<br/> Неверный пароль: ". $user_psw_valid; echo "<br/> Верный пароль: ". $customer['password']. "<br/> "; echo "Вы успешно авторизовались!<br/>";
    alert_login('success',0,'');
    // Пишем в сессию пометку об авторизации:
    $_SESSION['auth'] = true;
    
    // Получаем id записи и пишем его в сессию:
    $_SESSION['id'] = $customer['id_customer'];

    // Формируем страницу с профилем клиента
?>
    <h4>Ваш профиль:</h4>  
    <form class="account_update" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputName">Имя и Отчество</label>
        <input type="text" class="form-control" name="name" value="<?=$customer['name']?>">
        </div>
        <div class="form-group col-md-6">
        <label for="inputName">Фамилия</label>
        <input type="text" class="form-control" name="surname" value="<?=$customer['surname']?>">
        </div>
    </div>  
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="staticEmail">Email</label>
        <input type="email" readonly class="form-control" id="inputEmail4" name="email" value="<?=$customer['email']?>">
        </div>
        <div class="form-group col-md-6">
        <label for="inputPassword4">Пароль</label>
        <input type="password" class="form-control" id="inputPassword4" name="password" value="<?=$customer['password']?>">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail4">Телефон</label>
        <input type="phone" class="form-control" id="inputPhone" name="phone" value="<?=$customer['phone']?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputAddress">Адрес</label>
        <input type="text" class="form-control" id="inputAddress" name="address" value="<?=$customer['address']?>">
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputCity">Город</label>
        <input type="text" class="form-control" name="city" value="<?=$customer['city']?>">
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck">
        <label class="form-check-label" for="gridCheck">
            Подписаться на рассылки
        </label>
        </div>
    </div>
    <button name="update_form" type="submit" class="btn btn-primary">Обновить</button>
    </form>

    <script>
        
        $('.alert').on('closed.bs.alert', function() {
            console.log ("Функция закрытия окна 'Alert'");
        });
    </script>
      
<?

    // Обновляем поля Профиля
    // UPDATE `images`.`customers` SET `name` = '$customer[''name'']', `surname` = '$customer[''surname'']', `phone` = '$customer[''phone'']', `city` = '$customer[''city'']', `address` = '$customer[''address'']', `password` = '$customer[''password'']' WHERE `customers`.`id_customer` = 2;
    // UPDATE `images`.`customers` SET `surname` = 'Петров' WHERE `customers`.`id_customer` = 2;
    
    if (isset($_POST['update_form'])) {
        $name = $_POST['name'];
        // $name = isset($_POST["name"]) ? $_POST["name"] : $customer['name'];
        $surname = $_POST['surname'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['addresss'];
        $password = $_POST['password'];
    }

    $account_update = "UPDATE `images`.`customers` SET `name` = '".$name."' , `surname` = '".$surname."', `phone` = '".$phone."', `city` = '".$city."', `address` = '".$addresss."', `password` = '".$password."' WHERE `customers`.`email` = '".$user_email_valid."';";
    echo $account_update;
    if (!$mysql_query = mysqli_query($mysql, $account_update)) {
        // Если запись в базу данных не прошла, сообщаем об этом
        alert_login('write_error',$user_email_valid,'');
        mysqli_close($mysql);
        //exit();
    }
    // Сообщаем об удачном завершении регистрации в БД
    alert_login('write_success',$user_email_valid,'');

    // Обновление формы - Редирект на эту же страницу
    //header('Location: '.$_SERVER['PHP_SELF']);

    // Закрываем базу данных
    mysqli_close($mysql);
}

function check_exists_email_in_customers_table($user_email_valid, $user_psw_valid) {
    $mysql = mysqli_connect('localhost', 'root', 'mysql', 'images')
        or die ("Ошибка подключения к Базе данных: %s\n".mysqli_error($mysql));    
    // Устанавливаем кодировку соединения
    mysqli_query($mysql, "SET NAMES utf8 COLLATE utf8_unicode_ci");
    // Проверяем e-mail и пароль // echo "<br/>";
    // Поиск e-mail в таблице базы данных
    $query = "SELECT * FROM `customers` WHERE `email` LIKE '$user_email_valid';";
    // mysqli_query($mysql, $query);

    $mysql_query = mysqli_query($mysql, $query);
    // Проверка наличия email в базе данных
    if (mysqli_num_rows($mysql_query)) {
        // Если email найден: // echo "Такой E-mail уже есть в базе. Перейдите в Личный кабинет и авторизуйтесь<br/>"; echo "<b/> E-mail в базе: ".$query;
        alert_login('email_exists_in_dbase',$user_email_valid,'');
        mysqli_close($mysql);
        exit();
    }
    $record = "INSERT INTO `images`.`customers` (`id_customer`, `email`, `date_registr`, `password`) VALUES (NULL, '$user_email_valid', CURRENT_TIMESTAMP, '$user_psw_valid');";
    // INSERT INTO `images`.`customers` (`id_customer`, `email`, `date_registr`, `password`) VALUES (NULL, '123@123.ru', CURRENT_TIMESTAMP, '123');
    // mysqli_query($mysql, $query);
    if (!$mysql_query = mysqli_query($mysql, $record)) {
        // Если запись в базу данных не прошла, сообщаем об этом
        alert_login('write_error',$user_email_valid,'');
        mysqli_close($mysql);
        exit();
    }
    // Пишем в сессию пометку об авторизации:
    $_SESSION['auth'] = true;
    // Получаем id вставленной записи и пишем его в сессию
    $id = mysqli_insert_id($mysql);
    $_SESSION['id'] = $id;
    // Сообщаем об удачном завершении регистрации в БД
    alert_login('write_success',$user_email_valid,'');
    // Закрываем базу данных
    mysqli_close($mysql);
}

function registr_customer() {
    // Пример добавления строки в БД
    // INSERT INTO `images`.`customers` (`id_customer`, `name`, `surname`, `email`, `phone`, `city`, `address`, `date_registr`) VALUES ('null', 'Эдуард', 'Сергеев', 'ed.sergeev@gmail.com', '+79092472565', 'Иваново', 'ул.Ташкентская, 7-100', CURRENT_TIMESTAMP);
}

// Функция с Alert-уведомлениями 
function alert_login($alert,$argument,$argument2) {
    switch ($alert) {
        case 'email_wrong':
            ?>
            <div class="alert alert-danger" role="alert">
                E-mail <b><?=$argument?></b> не найден. Повторите ввод или <a href="./account_registration.php" class="alert-link">Зарегистрируйтесь</a> на странице регистрации. 
            </div>
            <?
            break;
        case "password_wrong":
            ?>
            <div class="alert alert-danger" role="alert">
                Неверный пароль. Повторите ввод или воспользуйтесь формой <a href="#" class="alert-link">Восстановления пароля</a>.
            </div>
            <?
            break;
        case 'success':
            ?>
            <div class="alert alert-success" role="alert">
                Вы успешно авторизовались!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?
            break;
        case 'passwords_dont_match':
            ?>
            <div class="alert alert-warning" role="alert">
                Пароли не совпадают, введите ещё раз.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?
            break;
        case 'email_exists_in_dbase':
            ?>
            <div class="alert alert-warning" role="alert">
                <b><?=$argument?></b> уже есть в базе. Перейдите в <a href="./account_enter.php" class="alert-link">Личный кабинет и авторизуйтесь</a>.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?
            break;
        case "write_error":
            ?>
            <div class="alert alert-danger" role="alert">
                Ошибка записи в базу данных. Повторите запрос.
            </div>
            <?
            break;
        case 'write_success':
            ?>
            <div class="alert alert-success" role="alert">
                Вы успешно зарегистрировались! Заполните Ваш профиль в Личном кабинете.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?
        break;
        case 'add_to_basket_success':
            ?>
            <div class="alert alert-success" role="alert">
                Товар <?="<b>".$argument."</b> в количестве ".$argument2." шт. "?> добавлен в корзину.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?
        break;
        case 'add_to_basket_warning':
            ?>
            <div class="alert alert-warning" role="alert">
                Товар <?="<b>".$argument."</b> в количестве ".$argument2." шт. "?> не удалось добавить в корзину.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <?
        break;        
    }
}
?>