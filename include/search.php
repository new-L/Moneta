<?php 
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		include("db_connect.php");
		include("../functions/functions.php");


		$search = iconv("UTF-8","UTF-8",strtolower(clear_string($_POST['text'])));
		$result = mysql_query("SELECT * FROM `products`, `coins` b WHERE products.id_products = b.id_products AND (b.denomination LIKE '%$search%' OR products.`year` LIKE '%$search%') LIMIT 5",$link) or die(mysql_error());
$result_bank = mysql_query("SELECT * FROM `products`,`banknotes` a WHERE products.id_products = a.id_products AND (a.denomination LIKE '%$search%' OR products.`year` LIKE '%$search%') LIMIT 5",$link)or die(mysql_error());
$result_rew = mysql_query("SELECT * FROM `products`, `rewards` c WHERE products.id_products = c.id_products AND (c.name LIKE '%$search%') LIMIT 5",$link)or die(mysql_error());
		if(mysql_num_rows($result) > 0 && mysql_num_rows($result_bank) > 0 && mysql_num_rows($result_rew) > 0)
		{
			$row = mysql_fetch_array($result);
			$row_bank = mysql_fetch_array($result_bank);
			$row_rew = mysql_fetch_array($result_rew);
			do
			{
				echo '<li><a href="search.php?q='.$row["denomination"].'">'.$row["denomination"].', '.$row["year"].'</a></li>;
			}
		}


	}
?>