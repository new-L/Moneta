<?php 
session_start();
if($_SESSION['auth'] == 'yes_auth'){
if($_SERVER["REQUEST_METHOD"] == "POST"){
include("../functions/functions.php");
	include("db_connect.php");
$login = $_SESSION['auth_login'];
	$result = mysql_query("SELECT * FROM cart,reg_user,products WHERE reg_user.login='$login'  AND products.id_products = cart.cart_id_products",$link)or die(mysql_error());
	if(mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_array($result);

		do
		{
			$count = $count + $row["cart_count"];
			$int = $int + ($row["price"] * $row["cart_count"]);
		}while($row = mysql_fetch_array($result));
	

	if($count == 1 || $count == 21 || $count == 31 || $count == 41 || $count == 51 || $count == 61 || $count == 71 || $count == 81 || $count == 91 || $count == 101) ($str = ' товар');
	if ($count == 2 or $count == 3 or $count == 4 or $count == 22 or $count == 23 or $count == 24 or $count == 32 or $count == 33 or $count == 34 or $count == 42 or $count == 43 or $count == 44 or $count == 52 or $count == 53 or $count == 54 or $count == 62 or $count == 63 or $count == 64) ( $str = ' товара');
	if ($count == 5 or $count == 6 or $count == 7 or $count == 8 or $count == 9 or $count == 10 or $count == 11 or $count == 12 or $count == 13 or $count == 14 or $count == 15 or $count == 16 or $count == 17 or $count == 18 or $count == 19 or $count == 20 or $count == 25 or $count == 26 or $count == 27 or $count == 28 or $count == 29 or $count == 30 or $count == 35 or $count == 36 or $count == 37 or $count == 38 or $count == 39 or $count == 40 or $count == 45 or $count == 46 or $count == 47 or $count == 48 or $count == 49 or $count == 50 or $count == 55 or $count == 56 or $count == 57 or $count == 58 or $count == 59 or $count == 60 or $count == 65) ( $str = ' товаров');
 	
echo '<span>'.$count.$str.'</span> на сумму <span>'.group_numerals($int).'</span> руб.';
}
else
{
	echo 0;
}
}
}
?>
