<?php 
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
include("../include/db_connect.php");
 include("../functions/functions.php");


 $error = array();//создание из перменной массива, для проверок(валидации)

 $login = iconv("UTF-8","UTF-8",strtolower(clear_string($_POST['reg_login'])));//заносим данные в переменные(вводимые данные)
 $pass =  iconv("UTF-8","UTF-8",strtolower(clear_string($_POST['reg_pass'])));
 $name =  iconv("UTF-8","UTF-8",clear_string($_POST['reg_name']));

 $surname =  iconv("UTF-8","UTF-8",clear_string($_POST['reg_surname']));
 $patronymic =  iconv("UTF-8","UTF-8",clear_string($_POST['reg_patronymic']));
 $email =  iconv("UTF-8","UTF-8",clear_string($_POST['reg_email']));
 $phone =  iconv("UTF-8","UTF-8",clear_string($_POST['reg_phone']));

$reg_address_index = iconv("UTF-8","UTF-8",clear_string($_POST['reg_address_index']));
$reg_address_gor_ray = iconv("UTF-8","UTF-8",clear_string($_POST['reg_address_gor_ray']));   
$reg_address_street =iconv("UTF-8","UTF-8",clear_string($_POST['reg_address_street']));
$reg_address_house = iconv("UTF-8","UTF-8",clear_string($_POST['reg_address_house']));
$reg_country = iconv("UTF-8","UTF-8",clear_string($_POST['reg_address_country']));

$reg_address_kv = iconv("UTF-8","UTF-8",clear_string($_POST['reg_address_kv']));
$reg_address_village = iconv("UTF-8","UTF-8",clear_string($_POST['reg_address_village'])); 


 if(strlen($login) < 5 or strlen($login) > 20)
 {
 	$error[]="Логин должен быть от 5 до 15 символов!";
 }
 else
 {
 	$result = mysql_query("SELECT login FROM reg_user WHERE login='$login'",$link);
 	if (mysql_num_rows($result) > 0)
 	{
 		$error[]="Логин занят!";
 	}
 }

 if(strlen($reg_address_index)<=0) $error[]="Укажите Индекс";
 if(strlen($reg_address_gor_ray) <= 0) $error[]="Укажите город/район проживания";
 if(strlen($reg_address_street) <= 0) $error[]="Укажите улицу проживания";
 if(strlen($reg_address_house) <= 0) $error[]="Укажите номер дома проживания";
 if(strlen($reg_country) <= 0) $error[]="Укажите Страну проживания";
 if(strlen($pass) < 7 or strlen($pass) > 15) $error[]="Укажите пароль от 7 до 15 символов!";
 if(strlen($name) < 3 or strlen($name) > 25) $error[]="Укажите Имя от 3 до 25 символов!"; 
 if(strlen($surname) < 3 or strlen($surname) > 40) $error[]="Укажите Фамилию от 3 до 20 символов!";
 if(strlen($patronymic) < 3 or strlen($patronymic) > 40) $error[]="Укажите отчество от 3 до 40 символов!";
 if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email))) $error[] = "Укажите корректный email!";//Рег.выражение на проверку e-mail trim-удалить пробелы вначале и вконце
 if(!$phone) $error[]="Укажите номер телефона!";

 if(count($error))
 {
 	echo implode('<br>',$error);//Вывод ошибка на экран
 }
 else
 {
	$pass = md5($pass);//шифрование пароля (md5 - стары метод шифровки)
 		$pass = strrev($pass);//переворачиваем пароль
 		$pass = "9nm2rv8q".$pass."2yo6z";//и добавим левые цифры и буквы
 $id = mysql_query("SELECT * FROM reg_user",$link);
 	$row = mysql_fetch_array($id);
 	do {
 		$i++;
 	} while ( $row= mysql_fetch_array($id));
$addres_id= $i + 1;
if(strlen($reg_address_village) > 0 || strlen($reg_address_kv) > 0){
	

		 	 	 	mysql_query(" INSERT INTO reg_user(login,password,name,surname,patronymic,email,phone,`datetime`,address_id)
 									VALUES (
 									'".$login."',
 									'".$pass."',
 									'".$name."',
 									'".$surname."',
 									'".$patronymic."',
 									'".$email."',
 									'".$phone."',
 									NOW(),
 									'".$addres_id."'
 									 )",$link);//NOW() текущее время

	mysql_query("INSERT INTO address(country_users,gor_ray,street,house,`index`,village,kvar,address_id)
 							 VALUES(
							'".$reg_country."',
							'".$reg_address_gor_ray."',
							'".$reg_address_street."',
							'".$reg_address_house."',
							'".$reg_address_index."',
							'".$reg_address_village."',
							'".$reg_address_kv."',
							'".$addres_id."'
 							)",$link);
	}else{

 	 	mysql_query(" INSERT INTO reg_user(login,password,name,surname,patronymic,email,phone,`datetime`,address_id)
 									VALUES (
 									'".$login."',
 									'".$pass."',
 									'".$name."',
 									'".$surname."',
 									'".$patronymic."',
 									'".$email."',
 									'".$phone."',
 									NOW(),
 									'".$addres_id."'
 									 )",$link);//NOW() текущее время
 	 	mysql_query("INSERT INTO address(country_users,gor_ray,street,house,`index`,address_id)
 							 VALUES(
							'".$reg_country."',
							'".$reg_address_gor_ray."',
							'".$reg_address_street."',
							'".$reg_address_house."',
							'".$reg_address_index."',
							'".$addres_id."'
 							)",$link);	
 	 				
 	 	 
	}}
 	echo true;
 }

?>