<?php 
session_start();
if($_SESSION['auth'] == 'yes_auth')
{

//подключение к файлу с БД
include("include/db_connect.php");
include("functions/functions.php");
//СОРИТРОВКА

//unset($_SESSION['auth']);



//Проверки всех изменяемых полей
if($_POST["save_submit"])//Массив post кнопки Если пользоватлеь нажао на кнопку
{
	$_POST["info_name"] = clear_string($_POST["info_name"]);//ОЧИСТКА ВСЕХ ДАННЫХ
	$_POST["info_surname"] = clear_string($_POST["info_surname"]);
	$_POST["info_patronymic"] = clear_string($_POST["info_patronymic"]);
	$_POST["info_email"] = clear_string($_POST["info_email"]);
	$_POST["info_phone"] = clear_string($_POST["info_phone"]);
	$_POST["info_address_country"] = clear_string($_POST["info_address_country"]);
	$_POST["info_address_gor_ray"] = clear_string($_POST["info_address_gor_ray"]);
	$_POST["info_address_village"] = clear_string($_POST["info_address_village"]);
	$_POST["info_address_street"] = clear_string($_POST["info_address_street"]);
	$_POST["info_address_house"] = clear_string($_POST["info_address_house"]);
	$_POST["info_address_kv"] = clear_string($_POST["info_address_kv"]);
	$_POST["info_address_index"] = clear_string($_POST["info_address_index"]);

	$error = array();//массив для ошибок
	$pass = md5(strtolower($_POST["info_pass"]));//шифрование пароля (md5 - стары метод шифровки)
 	$pass = strrev($pass);//переворачиваем пароль
 	$pass = "9nm2rv8q".$pass."2yo6z";//и добавим левые цифры и буквы

 	if($_SESSION['auth_pass'] != $pass)//сравниваем пароль с зашифрованным паролем
 	{
 		$error[] = 'Неверный текущий пароль!';
 	}
 	else 
 	{
 		if($_POST["info_new_pass"] != "")
 		{
 			if(strlen($_POST["info_new_pass"]) < 7 || strlen($_POST["info_new_pass"])>15)//если пароль меньше 7 символо или больше 15
 			{
 				$error[]='Укажите новый пароль от 7 до 15 символов!';//то ошибка
 			}
 			else
 			{
 				$newpass = md5($_POST["info_new_pass"]);
 				$newpass = strrev($newpass);
 				$newpass = "9nm2rv8q".$newpass."2yo6z";
 				$newpassquery = "a.password='".$newpass."',";
 			}
 		}


 		if(strlen($_POST["info_name"]) < 3 || strlen($_POST["info_name"])>40 )
 		{
 			$error[]='Укажите Фамилию от 3 до 40 символов!';
 		}
 		if(strlen($_POST["info_surname"]) < 3 || strlen($_POST["info_surname"])>40)
 		{
 			$error[]='Укажите Имя от 3 до 40 символов!';
 		}
 		if(strlen($_POST["info_patronymic"]) < 3 || strlen($_POST["info_patronymic"]) > 40)
 		{
 			$error[]='Укажите Отчество от 3 до 40 символов!';
 		}
 		if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($_POST["info_email"]))) 
 		{
 				$error[] = "Укажите корректный email!";
 		}
 		if(strlen($_POST["info_phone"]) == "")
 		{
 			$error[]='Укажите номер телефона!';
 		}
 	}

 	if(count($error))
 	{
 		$_SESSION['msg'] = "<p align='left' id='form-error'>".implode('<br>', $error)."</p>";
 	}
 	else
 	{
 		$_SESSION['msg'] = "<p align='left' id='form-success'>Данные успешно сохранены!</p>";
 	
 		//ФОРМИРОВКА ЗАПРОСА НА ОБНОВЛенИе

$dataquery = $newpassquery."a.name='".$_POST["info_name"]."',a.surname='".$_POST["info_surname"]."',a.patronymic='".$_POST["info_patronymic"]."',a.email='".$_POST["info_email"]."',a.phone='".$_POST["info_phone"]."',b.country_users = '".$_POST["info_address_country"]."',b.gor_ray = '".$_POST["info_address_gor_ray"]."',b.village='".$_POST["info_address_village"]."',b.street = '".$_POST["info_address_street"]."',b.house ='".$_POST["info_address_house"]."',b.kvar ='".$_POST["info_address_kv"]."',b.index = '".$_POST["info_address_index"]."'";
$update = mysql_query("UPDATE reg_user a, address b SET $dataquery WHERE a.login = '{$_SESSION['auth_login']}' AND a.address_id = b.address_id",$link);

if($newpass){$_SESSION['auth_pass'] = $newpass;}

$_SESSION['auth_name'] = $_POST["info_name"];
 	$_SESSION['auth_surname'] = $_POST["info_surname"];
 	$_SESSION['auth_patronymic'] = $_POST["info_patronymic"];
 	$_SESSION['auth_phone'] = $_POST["info_phone"];
 	$_SESSION['auth_email'] = $_POST["info_email"];
 	$_SESSION["auth_country_users"]= $_POST["info_address_country"];
	$_SESSION["auth_gor_ray"]=$_POST["info_address_gor_ray"];
	$_SESSION["auth_village"]=$_POST["info_address_village"];
	$_SESSION["auth_street"]=$_POST["info_address_street"];
	$_SESSION["auth_house"]=$_POST["info_address_house"];
	$_SESSION["auth_kvar"]=$_POST["info_address_kv"];
	$_SESSION["auth_index"]=$_POST["info_address_index"];	
 	}
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script><!--подключаение jquery для смены вида товара-->
	<script type="text/javascript" src="/js/jquery-3.2.1.js"></script> 
	<script type="text/javascript" src="trackbar/jQuery/jquery.trackbar.js"></script>
  <script type="text/javascript" src="trackbar/jQuery/jquery-1.2.3.min.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script><!--подключение куки для запоминания страниц-->
	<script type="text/javascript" src="/js/TextChange.js"></script>
	<script type="text/javascript" src="js/shop.js"></script>
	<title>Moneta</title>
</head>
<body>
<div id="block-body">
<?php 
	include("include/block-heade.php");//подключаем шапку сайта
?>
<div id="block-right">
	<?php 
	include("include/block-category.php");//подключаем шапку категории для подключения для всех страниц легче-_-
?>

</div>
<div id="block-content">
	<h3 class="title-h3" >Изменение профиля</h3>
 <?php 

 if($_SESSION['msg'])
 {
 	echo $_SESSION['msg'];
 	unset($_SESSION['msg']);
 }
  ?>
<form method="post">
 
<ul id="info-profile">
<li>
<label for="info_pass">Текущий пароль</label>
<span class="star">*</span>
<input type="text" name="info_pass" id="info_pass">
</li>
 
<li>
<label for="info_new_pass">Новый пароль</label>
<span class="star">*</span>
<input type="text" name="info_new_pass" id="info_new_pass">
</li>
 
<li>
<label for="info_name">Имя</label>
<span class="star">*</span>
<input type="text" name="info_name" id="info_name" value=<?php echo $_SESSION['auth_name']; ?>>
</li>

<li>
<label for="info_surname">Фамилия</label>
<span class="star">*</span>
<input type="text" name="info_surname" id="info_surname" value=<?php echo $_SESSION['auth_surname']; ?>>


</li>
 
<li>
<label for="info_patronymic">Отчество</label>
<span class="star">*</span>
<input type="text" name="info_patronymic" id="info_patronymic" value=<?php echo $_SESSION['auth_patronymic'] ?>>
</li>
 
 
<li>
<label for="info_email">E-mail</label>
<span class="star">*</span>
<input type="text" name="info_email" id="info_email" value=<?php echo $_SESSION['auth_email']; ?>>
</li>
 
<li>
<label for="info_phone">Телефон</label>
<span class="star">*</span>
<input type="text" name="info_phone" id="info_phone" value=<?php echo $_SESSION['auth_phone']; ?>>
</li>
 
<li>
<label id="info_address">Адрес доставки</label>
                            <ul>
														<li><label>Страна</label><input type="text" name="info_address_country" id="info_address_country" value="<?php echo clear_string($_SESSION['auth_country_users']); ?>"></li>
                            <li><label>Город/Район</label><input type="text" name="info_address_gor_ray" id="info_address_gor_ray" value="<?php echo $_SESSION['auth_gor_ray']; ?>"></li>
                            <li><label>Село</label><input type="text" name="info_address_village" id="info_address_village" value="<?php echo $_SESSION["auth_village"]; ?>"></li>
                            <li><label>Улица</label><input type="text" name="info_address_street" id="info_address_street" value="<?php echo $_SESSION["auth_street"]; ?>"></li>
                            <li><label>Дом</label><input type="text" name="info_address_house" id="info_address_house" value="<?php echo clear_string($_SESSION["auth_house"]); ?>"></li>
                            <li><label>Квартира</label><input type="text" name="info_address_kv" id="info_address_kv" value="<?php echo $_SESSION["auth_kvar"];?>"></li>
                            <li><label>Почтовый индекс</label><input type="text" name="info_address_index" id="info_address_index" value="<?php echo $_SESSION["auth_index"];?>"></li>
                        </ul>
</li>
 
</ul>
 
 <p align="right"><input type="submit" id="form-submit" name="save_submit" value="Сохранить"></p>
</form>
</div>


<?php 
include("include/block-footer.php");//подключаем футер(подвал)
?>



</div>	
</body>
</html>
<?php 
} 
else{
	header("Location: index.php");
}?>


















