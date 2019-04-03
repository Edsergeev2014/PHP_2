<?// в начале конфиг
define('DB_DRIVER','mysql');
define('DB_HOST','localhost');
define('DB_NAME','images');
define('DB_USER','root');
define('DB_PASS','mysql');
 
try
{
	// соединяемся с базой данных 
	$connect_str = DB_DRIVER . ':host='. DB_HOST . ';dbname=' . DB_NAME;
    $db = new PDO($connect_str,DB_USER,DB_PASS);
    $db->query("SET NAMES utf8 COLLATE utf8_unicode_ci");
	// теперь выберем строки из базы 
	$result = $db->query("SELECT * FROM options ORDER BY popularity DESC LIMIT $images_on_page OFFSET $current_page;"); 
	// в случае ошибки SQL выражения выведем сообщене об ошибке 
	$error_array = $db->errorInfo(); 
	if($db->errorCode() != 0000) 
	echo "SQL ошибка: " . $error_array[2] . '<br /><br />'; 
	// теперь получаем данные из класса PDOStatement 
	$images = $result->fetchAll();
	
    // print_r ($images);
}
catch(PDOException $e)
{
	die("Error: ".$e->getMessage());
}