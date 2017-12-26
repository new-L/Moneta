<?php 
//подключение к бд
$db_host = 'localhost';//Данные
$db_user = 'admin';
$db_pass = '123456';
$db_database = 'db_shop';

$link = mysql_connect($db_host, $db_user, $db_pass);//переменнная, в который заносится результат  подключения к базе
//выбор базы данных(название БД и статус БД), если что-то произошло, то появится это сообщение
mysql_select_db($db_database, $link) or die("Нет соединения с БД ".mysql_error());
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET 'utf8'");
 ?>