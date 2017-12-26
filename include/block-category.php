<div id="block-category">
<p class="header-title">Категории товаров</p>	

<ul><!--Требуется вывод через БД-->	
	<li><a id="index1">Монеты</a>

		<ul class="category-section">
			<p class="category_name"><b>Страна:</b></p>
			<li><a href="view_cat.php?type=monets"><b>Все страны</b></a></li>
			<!--ВЫВОД КАТЕГОРИЙ ЧЕРЕЗ БД-->
			<?php  
				$result = mysql_query("SELECT DISTINCT(country), type FROM products WHERE type='monets'",$link);

				if(mysql_num_rows($result) > 0)//если кол-во строк больше 0
				{
					$row = mysql_fetch_array($result);
					do
					{

						echo '
							<li><a href="view_cat.php?cat='.strtolower($row["country"]).'&type='.$row["type"].'">'.$row["country"].'</a></li>
						';//view_cat(файл, который отображает, определенные бренды(товары, в ссылке))  $row["country"](это название страны), strtolower - вывод в ссылку текст маленькими буквами
					//все, что в ссылке, формирование ссылки
					}//urlencode(кодирование русских символов)
					while($row = mysql_fetch_array($result));//пока row(переменная) = массиву данных
				}	
			?>
				

				<p class="category_name"><b>Год:</b></p>
			<li><a href="view_year.php?type=monets"><b>Все года</b></a></li>
			<!--ВЫВОД КАТЕГОРИЙ ЧЕРЕЗ БД-->
			<?php  
				$result_coin = mysql_query("SELECT DISTINCT(year), type FROM products WHERE type='monets'",$link);

				if(mysql_num_rows($result_coin) > 0)//если кол-во строк больше 0
				{
					$row_coin = mysql_fetch_array($result_coin);
					do
					{

						echo '
							<li><a href="view_year.php?year='.strtolower($row_coin["year"]).'&type='.$row_coin["type"].'">'.$row_coin["year"].'</a></li>
						';//view_cat(файл, который отображает, определенные бренды(товары, в ссылке))  $row["country"](это название страны), strtolower - вывод в ссылку текст маленькими буквами
					//все, что в ссылке, формирование ссылки
					}//urlencode(кодирование русских символов)
					while($row_coin = mysql_fetch_array($result_coin));//пока row(переменная) = массиву данных
				}	
			?>
			<!--Подраздел-->
		</ul>
	</li>
	

	<li><a id="index2">Банкноты</a>
		<ul class="category-section">
			<p class="category_name"><b>Страна:</b></p>
			<li><a  href="view_cat_bank.php?type=bancnots"><b>Все страны</b></a></li>
			<?php  
				$result = mysql_query("SELECT DISTINCT(country), type FROM products WHERE type='bancnots'",$link);

				if(mysql_num_rows($result) > 0)//если кол-во строк больше 0
				{
					$row = mysql_fetch_array($result);
					do
					{
						echo '
							<li><a href="view_cat_bank.php?cat='.strtolower($row["country"]).'&type='.$row["type"].'">'.$row["country"].'</a></li>
						';//view_cat(файл, который отображает, определенные бренды(товары, в ссылке))  $row["country"](это название страны), strtolower - вывод в ссылку текст маленькими буквами
					//все, что в ссылке, формирование ссылки
					}
					while($row = mysql_fetch_array($result));//пока row(переменная) = массиву данных
				}	
			?>
			<!--Подраздел-->
			<p class="category_name"><b>Год:</b></p>
			<li><a href="view_year_bank.php?type=bancnots"><b>Все года</b></a></li>
			<!--ВЫВОД КАТЕГОРИЙ ЧЕРЕЗ БД-->
			<?php  
				$result_bank = mysql_query("SELECT DISTINCT(year), type FROM products WHERE type='bancnots'",$link);

				if(mysql_num_rows($result_bank) > 0)//если кол-во строк больше 0
				{
					$row_bank = mysql_fetch_array($result_bank);
					do
					{

						echo '
							<li><a href="view_year_bank.php?year='.strtolower($row_bank["year"]).'&type='.$row_bank["type"].'">'.$row_bank["year"].'</a></li>
						';//view_cat(файл, который отображает, определенные бренды(товары, в ссылке))  $row["country"](это название страны), strtolower - вывод в ссылку текст маленькими буквами
					//все, что в ссылке, формирование ссылки
					}//urlencode(кодирование русских символов)
					while($row_bank = mysql_fetch_array($result_bank));//пока row(переменная) = массиву данных
				}	
			?>
		</ul>
	</li>
	

	<li><a id="index3">Награды</a>
		<ul class="category-section">
			<p class="category_name"><b>Страна:</b></p>
			<li><a href="view_cat_rewards.php?type=rewards"><b>Все страны</b></a></li>
			<?php  
				$result = mysql_query("SELECT DISTINCT(country), type FROM products WHERE type='rewards'",$link);

				if(mysql_num_rows($result) > 0)//если кол-во строк больше 0
				{
					$row = mysql_fetch_array($result);
					do
					{
						echo '
							<li><a href="view_cat_rewards.php?cat='.strtolower($row["country"]).'&type='.$row["type"].'">'.$row["country"].'</a></li>
						';//view_cat(файл, который отображает, определенные бренды(товары, в ссылке))  $row["country"](это название страны), strtolower - вывод в ссылку текст маленькими буквами
					//все, что в ссылке, формирование ссылки
					}
					while($row = mysql_fetch_array($result));//пока row(переменная) = массиву данных
				}	
			?>
			<!--Подраздел-->

		</ul>
	</li>



</ul>

</div>