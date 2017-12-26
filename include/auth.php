<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		include('db_connect.php');
		include('../functions/functions.php');


		$login = strtolower(clear_string($_POST["login"]));
$pass =  strtolower(clear_string($_POST["pass"]));

		$pass = md5($pass);//шифрование пароля (md5 - стары метод шифровки)
 		$pass = strrev($pass);//переворачиваем пароль
 		$pass = "9nm2rv8q".$pass."2yo6z";//и добавим левые цифры и буквы


		$result = mysql_query("SELECT * 
			FROM reg_user,address 
			WHERE reg_user.login = '$login' AND reg_user.password = '$pass' AND address.address_id = reg_user.address_id",$link);
		
		if(mysql_num_rows($result) <= 0){
				echo 'no_auth';
		}
		if(mysql_num_rows($result) > 0)
		{
			$row = mysql_fetch_array($result);
			session_start();//начало сессии
			$_SESSION['auth'] = 'yes_auth';//пользователь авторизирован
			$_SESSION['auth_pass'] = $row["password"];
			$_SESSION['auth_login'] = $row["login"];
			$_SESSION['auth_surname'] = $row["surname"];
			$_SESSION['auth_name'] = $row["name"];
			$_SESSION['auth_patronymic'] = $row["patronymic"];
			$_SESSION['auth_phone'] = $row["phone"];
			$_SESSION['auth_email'] = $row["email"];
			$_SESSION['auth_country_users'] = $row["country_users"];
			$_SESSION['auth_gor_ray'] = $row["gor_ray"];
			$_SESSION['auth_village'] = $row["village"];
			$_SESSION['auth_street'] = $row["street"];
			$_SESSION['auth_house'] = $row["house"];
			$_SESSION['auth_kvar'] = $row["kvar"];
			$_SESSION['auth_index'] = $row["index"];
			echo 'yes_auth';
		}

	}
?>