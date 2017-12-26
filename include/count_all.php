<?php  
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
	include("../functions/functions.php");
	include("db_connect.php");
	$login = $_SESSION['auth_login'];
	$result = mysql_query("SELECT * FROM cart,reg_user,products WHERE reg_user.login='$login'  AND products.id_products = cart.cart_id_products",$link)or die(mysql_error());
	if(mysql_num_rows($result) > 0)
	{
		$row=mysql_fetch_array($result);
		$count_all = $row["count"];
		$cart_count = $row["cart_count"];
		if($count_all > $cart_count)
		{
			$flag = $count_all - $cart_count;
			$update = mysql_query("UPDATE cart,products SET products.count='$flag' WHERE products.id_products=cart.cart_id_products",$link);
			echo 0;
		}
		else
		{
			$flag = 0;
			$update = mysql_query("UPDATE cart,products SET products.count='$flag' WHERE products.id_products = cart.cart_id_products",$link);
			echo 0;
		}
	}
}
?>