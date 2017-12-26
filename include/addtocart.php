<?php 
session_start();

if($_SESSION['auth'] == 'yes_auth'){
	include("db_connect.php");

	include("../functions/functions.php");
	$login = $_SESSION['auth_login'];
$id = clear_string($_POST["id"]);
$result = mysql_query("SELECT * FROM cart,reg_user,products WHERE reg_user.login='$login'  AND cart.cart_id_products = '$id'",$link)or die(mysql_error());
if(mysql_fetch_array($result) > 0)
{
	$row = mysql_fetch_array($result);
	$new_count = $row["cart_count"] + 1;
	$update = mysql_query("UPDATE cart,reg_user,products SET cart.cart_count='$new_count' WHERE reg_user.login='$login' AND cart.cart_id_users IN (SELECT id FROM reg_user)  AND cart.cart_id_products = '$id'",$link);
}
else
{
	
	$login = $_SESSION['auth_login'];
	$result_f = mysql_query("SELECT * FROM reg_user WHERE login='$login'");
	$row_f = mysql_fetch_array($result_f);

	$result = mysql_query("SELECT * FROM products WHERE id_products ='$id'",$link);
	$row = mysql_fetch_array($result);
	mysql_query("INSERT INTO cart (cart_id_products,cart_price,cart_datetime,cart_id_users)
		VALUES(
		'".$row["id_products"]."',
		'".$row["price"]."',
		NOW(),
		'".$row_f["id"]."');",$link);
}


}



 ?>