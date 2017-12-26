<?php 
session_start();
if($_SESSION['auth'] == 'yes_auth')
{
//подключение к файлу с БД
include("include/db_connect.php");
include("functions/functions.php");

//unset($_SESSION['auth']);
//УДАЛЕНИЕ С КОРЗИНЫ
$login = $_SESSION['auth_login'];

$id = clear_string($_GET["id"]);
$action = clear_string($_GET["action"]);

switch($action){
	case 'clear':
	$clear = mysql_query("DELETE FROM cart WHERE cart.cart_id_users IN (SELECT id FROM reg_user)",$link);
	break;

	case 'delete':
	$delete = mysql_query("DELETE FROM cart WHERE cart.cart_id = '$id' AND cart.cart_id_users IN (SELECT id FROM reg_user) ",$link);
	break;}

	if(isset($_POST["submitdata"]))
	{
		$_SESSION["order_delivery"] = $_POST["order_delivery"];
		$_SESSION["order_note"] = $_POST["order_note"];

		header("Location: cart.php?action=completion");
	}
$result = mysql_query("SELECT * FROM cart,products,reg_user,banknotes WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND banknotes.id_products = cart.cart_id_products",$link);
		$result_c = mysql_query("SELECT * FROM cart,products,reg_user,coins WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND coins.id_products = cart.cart_id_products",$link);
		$result_r = mysql_query("SELECT * FROM cart,products,reg_user,rewards WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND rewards.id_products = cart.cart_id_products",$link);

if(mysql_num_rows($result) > 0 || mysql_num_rows($result_c) > 0 || mysql_num_rows($result_r) > 0){
		$row = mysql_fetch_array($result);
			$row_c = mysql_fetch_array($result_c);
			$row_r = mysql_fetch_array($result_r);
if(mysql_num_rows($result) > 0)
		{

		do
		{
			$int = $int + ($row["cart_price"] * $row["cart_count"]);//для цены товара на кол-во
} while($row = mysql_fetch_array($result));}
if(mysql_num_rows($result_c) > 0)
{
	do
		{
			$int = $int + ($row_c["cart_price"] * $row_c["cart_count"]);//для цены товара на кол-во
		}while($row_c = mysql_fetch_array($result_c));}
if(mysql_num_rows($result_r) > 0)
{
	do
		{
			$int =$int + ($row_r["cart_price"] * $row_r["cart_count"]);//для цены товара на кол-во
}while($row_r = mysql_fetch_array($result_r));
} 
$itogpricecart = $int;
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
	<title>Корзина заказов</title>
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
	
<?php 
	$action = clear_string($_GET["action"]);//принимаем значение с url для шагов покупки
	switch ($action){
		case 'oneclick':
		echo '
		<div id="block-step">
		<div id="name-step">	
		<ul>
			<li><a class="active">1. Корзина заказов</a></li>
			<li><span>&rarr;</span></li>
			<li><a>2. Контактная информация</a></li>
			<li><span>&rarr;</span></li>
			<li><a>3. Завершение</a></li>
		</ul>
		</div>
		<p>Шаг 1 из 3</p>
		<a href="cart.php?action=clear">Очистить</a>
		</div>

		';
		$login = $_SESSION['auth_login'];
		
		$result = mysql_query("SELECT * FROM cart,products,reg_user,banknotes WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND banknotes.id_products = cart.cart_id_products",$link);
		$result_c = mysql_query("SELECT * FROM cart,products,reg_user,coins WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND coins.id_products = cart.cart_id_products",$link);
		$result_r = mysql_query("SELECT * FROM cart,products,reg_user,rewards WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND rewards.id_products = cart.cart_id_products",$link);
		if(mysql_num_rows($result) > 0 || mysql_num_rows($result_c) > 0 || mysql_num_rows($result_r) > 0){
		$row = mysql_fetch_array($result);
			$row_c = mysql_fetch_array($result_c);
			$row_r = mysql_fetch_array($result_r);
					echo '
					<div id="header-list-cart">
					<div id="head1">Изображение</div>
						<div id="head2">Наименование товара</div>
						<div id="head3">Кол-во</div>
						<div id="head4">Цена</div>
						</div>			
		';
		if(mysql_num_rows($result) > 0)
		{

		do
		{
			$int = $row["cart_price"] * $row["cart_count"];//для цены товара на кол-во
			$all_price = $all_price + $int;//цена всеъ товаров
			echo'
		<div class="block-list-cart">
		<div class="img-cart">
		<p align="center"><img src="./product_images/'.$row["image"].'" width="120" height="105"></p>
		</div>
		<div class="title-cart">
		<p class ="cart_products"><a >'.$row["denomination"].' '.$row["curr_un"].', '.$row["year"].'</a></p>
		</div>

		<div class="count-cart">
		<ul class="input-count-style">
		<li>
		<p align="center" class="count-minus">-</p>
		</li>
		
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'"></p></li>

		<li>
		<p align="center" class="count-plus">+</p>
		</li>
		</ul>
		</div>
		<div class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p>'.$int.'</p></div>
		<div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="/images/bsk_item_del.png"></a></div>
		<div id="bottom-cart-line"></div>
		</div>
		';
} while($row = mysql_fetch_array($result));}

if(mysql_num_rows($result_c) > 0)
{
	do
		{
			$int = $row_c["cart_price"] * $row_c["cart_count"];//для цены товара на кол-во
			$all_price = $all_price + $int;//цена всеъ товаров
	echo'
		<div class="block-list-cart">
		<div class="img-cart">
		<p align="center"><img src="./product_images/'.$row_c["image"].'" width="120" height="105"></p>
		</div>
		<div class="title-cart">
		<p class ="cart_products"><a >'.$row_c["denomination"].' '.$row_c["curr_un"].', '.$row_c["year"].'</a></p>
		</div>

		<div class="count-cart">
		<ul class="input-count-style">
		<li>
		<p align="center" class="count-minus">-</p>
		</li>
		
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row_c["cart_count"].'"></p></li>

		<li>
		<p align="center" class="count-plus">+</p>
		</li>
		</ul>
		</div>
		<div class="price-product"><h5><span class="span-count">'.$row_c["cart_count"].'</span> x <span>'.$row_c["cart_price"].'</span></h5><p>'.$int.'</p></div>
		<div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="/images/bsk_item_del.png"></a></div>
		<div id="bottom-cart-line"></div>
		</div>
		';
}while($row_c = mysql_fetch_array($result_c));
} 

if(mysql_num_rows($result_r) > 0)
{
	do
		{
			$int = $row_r["cart_price"] * $row_r["cart_count"];//для цены товара на кол-во
			$all_price = $all_price + $int;//цена всеъ товаров
	echo'
		<div class="block-list-cart">
		<div class="img-cart">
		<p align="center"><img src="./product_images/'.$row_r["image"].'" width="120" height="105"></p>
		</div>
		<div class="title-cart">
		<p class ="cart_products"><a >'.$row_r["name"].'</a></p>
		</div>

		<div class="count-cart">
		<ul class="input-count-style">
		<li>
		<p align="center" class="count-minus">-</p>
		</li>
		
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row_r["cart_count"].'"></p></li>

		<li>
		<p align="center" class="count-plus">+</p>
		</li>
		</ul>
		</div>
		<div class="price-product"><h5><span class="span-count">'.$row_r["cart_count"].'</span> x <span>'.$row_r["cart_price"].'</span></h5><p>'.$int.'</p></div>
		<div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="/images/bsk_item_del.png"></a></div>
		<div id="bottom-cart-line"></div>
		</div>
		';
}while($row_r = mysql_fetch_array($result_r));
} 

	echo '  
		<h2 class="itog-price" align="right">Итого: <strong>'.$all_price.'</strong> руб.</h2>
		<p align="right" class="button-next"><a href="cart.php?action=confirm">Далее</a></p> 
		'; 
}
		else{
			echo '<h3 id="clear-cart" align="center">Корзина пуста</h3>';
		}
		break;
		case 'confirm':
		echo '
		<div id="block-step">
		<div id="name-step">		
		<ul>
			<li><a href="cart.php?action=oneclick">1. Корзина заказов</a></li>
			<li><span>&rarr;</span></li>
			<li><a class="active">2. Контактная информация</a></li>
			<li><span>&rarr;</span></li>
			<li><a>3. Завершение</a></li>
		</ul>
		</div>
		<p>Шаг 2 из 3</p>
		</div>

		';
		$chck ="";
		if($_SESSION['order_delivery'] == "По почте")$chck1 = "checked";
if($_SESSION['order_delivery'] == "Курьером")$chck2 = "checked";
if($_SESSION['order_delivery'] == "Самовывоз")$chck3 = "checked";
		
	echo '
	<h3 class="title-h3">Способ доставки:</h3>
	<form method="post">
	<ul id="info-radio">
	<li>
	<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery1" value="По почте" '.$chck1.'>
	<label class="label_delivery" for="order_delivery1">По почте</label>
	</li>
	<li>
	<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery2" value="Курьером" '.$chck2.'>
	<label class="label_delivery" for="order_delivery2">Курьером</label>
	</li>

	<li>
	<input type="radio" name="order_delivery" class="order_delivery" id="order_delivery3" value="Самовывоз" '.$chck3.'>
	<label class="label_delivery" for="order_delivery3">Самовывоз</label>
	</li>
	</ul>
	<h3 class="title-h3">Информация для доставки:</h3>
	<ul id="info-order">
	';
echo '
<li><label class="order_label_style" for="order_note">Примечание</label> <textarea name="order_note">'.$_SESSION["order_note"].'</textarea><span>Уточните информацию о заказе.<br> Например, удобное время для звонка<br> нашего менеджера</span></li>
</ul>
<p align="right"><input type="submit" name="submitdata" id="confirm-button-next" value="Далее"></p>
</form>

';






		break;
		case 'completion':
		echo '
		<div id="block-step">
		<div id="name-step">		
		<ul>
			<li><a href="cart.php?action=oneclick">1. Корзина заказов</a></li>
			<li><span>&rarr;</span></li>
			<li><a href="cart.php?action=confirm">2. Контактная информация</a></li>
			<li><span>&rarr;</span></li>
			<li><a class="active">3. Завершение</a></li>
		</ul>
		</div>
		<p>Шаг 3 из 3</p>
		</div>


<h3 class="title-h3">Конечная информация:</h3>
		';
		if($_SESSION['auth'] == 'yes_auth')
		{
			echo '
			<ul id="list-info">
			<li><strong>Способ доставки:</strong> '.$_SESSION['order_delivery'].'</li>
			<li><strong>Email:</strong> '.$_SESSION['auth_email'].'</li>
			<li><strong>ФИО:</strong> '.$_SESSION['auth_surname'].' '.$_SESSION['auth_name'].' '.$_SESSION['auth_patronymic'].'</li>';
			if(!empty($_SESSION['auth_village']) && !empty($_SESSION['auth_kvar'])){
			echo'<li><strong>Адрес доставки:</strong> '.$_SESSION['auth_country_users'].', '.$_SESSION['auth_gor_ray'].', '.$_SESSION['auth_village'].', '.$_SESSION['auth_street'].', '.$_SESSION['auth_house'].', '.$_SESSION['auth_kvar'].', '.$_SESSION['auth_index'].'</li>
			';}
			else{
				echo'<li><strong>Адрес доставки:</strong> '.$_SESSION['auth_country_users'].', '.$_SESSION['auth_gor_ray'].', '.$_SESSION['auth_street'].', '.$_SESSION['auth_house'].', '.$_SESSION['auth_index'].'</li>
				';
			}
			echo'<li><strong>Телефон:</strong> '.$_SESSION['auth_phone'].'</li>
			<li><strong>Примечание:</strong> '.$_SESSION['order_note'].'</li>
			</ul>';
		}
echo '
<h2 class="itog-price" align="right">Итого: <strong>'.$itogpricecart.'</strong> руб.</h2>
<p align="right" id="button-next"><a>Оплатить</a></p>';






		break;
		default:

		echo '
		<div id="block-step">
		<div id="name-step">	
		<ul>
			<li><a class="active">1. Корзина заказов</a></li>
			<li><span>&rarr;</span></li>
			<li><a>2. Контактная информация</a></li>
			<li><span>&rarr;</span></li>
			<li><a>3. Завершение</a></li>
		</ul>
		</div>
		<p>Шаг 1 из 3</p>
		<a href="cart.php?action=clear">Очистить</a>
		</div>

		';

		$login = $_SESSION['auth_login'];

		$result = mysql_query("SELECT * FROM cart,products,reg_user,banknotes WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND banknotes.id_products = cart.cart_id_products",$link);
		$result_c = mysql_query("SELECT * FROM cart,products,reg_user,coins WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND coins.id_products = cart.cart_id_products",$link);
		$result_r = mysql_query("SELECT * FROM cart,products,reg_user,rewards WHERE reg_user.login = '$login' AND cart.cart_id_users = reg_user.id AND products.id_products = cart.cart_id_products AND rewards.id_products = cart.cart_id_products",$link);
		if(mysql_num_rows($result) > 0 || mysql_num_rows($result_c) > 0 || mysql_num_rows($result_r) > 0){
		$row = mysql_fetch_array($result);
			$row_c = mysql_fetch_array($result_c);
			$row_r = mysql_fetch_array($result_r);
if(!empty($login)){
					echo '
					<div id="header-list-cart">
					<div id="head1">Изображение</div>
						<div id="head2">Наименование товара</div>
						<div id="head3">Кол-во</div>
						<div id="head4">Цена</div>
						</div>			
		';}
		if(mysql_num_rows($result) > 0)
		{

		do
		{
			$int = $row["cart_price"] * $row["cart_count"];//для цены товара на кол-во
			$all_price = $all_price + $int;//цена всеъ товаров
			echo'
		<div class="block-list-cart">
		<div class="img-cart">
		<p align="center"><img src="./product_images/'.$row["image"].'" width="120" height="105"></p>
		</div>
		<div class="title-cart">
		<p class ="cart_products"><a >'.$row["denomination"].' '.$row["curr_un"].', '.$row["year"].'</a></p>
		</div>

		<div class="count-cart">
		<ul class="input-count-style">
		<li>
		<p align="center" class="count-minus">-</p>
		</li>
		
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row["cart_count"].'"></p></li>

		<li>
		<p align="center" class="count-plus">+</p>
		</li>
		</ul>
		</div>
		<div class="price-product"><h5><span class="span-count">'.$row["cart_count"].'</span> x <span>'.$row["cart_price"].'</span></h5><p>'.$int.'</p></div>
		<div class="delete-cart"><a href="cart.php?id='.$row["cart_id"].'&action=delete"><img src="/images/bsk_item_del.png"></a></div>
		<div id="bottom-cart-line"></div>
		</div>
		';
} while($row = mysql_fetch_array($result));}

if(mysql_num_rows($result_c) > 0)
{
	do
		{
			$int = $row_c["cart_price"] * $row_c["cart_count"];//для цены товара на кол-во
			$all_price = $all_price + $int;//цена всеъ товаров
	echo'
		<div class="block-list-cart">
		<div class="img-cart">
		<p align="center"><img src="./product_images/'.$row_c["image"].'" width="120" height="105"></p>
		</div>
		<div class="title-cart">
		<p class ="cart_products"><a >'.$row_c["denomination"].' '.$row_c["curr_un"].', '.$row_c["year"].'</a></p>
		</div>

		<div class="count-cart">
		<ul class="input-count-style">
		<li>
		<p align="center" class="count-minus">-</p>
		</li>
		
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row_c["cart_count"].'"></p></li>

		<li>
		<p align="center" class="count-plus">+</p>
		</li>
		</ul>
		</div>
		<div class="price-product"><h5><span class="span-count">'.$row_c["cart_count"].'</span> x <span>'.$row_c["cart_price"].'</span></h5><p>'.$int.'</p></div>
		<div class="delete-cart"><a href="cart.php?id='.$row_c["cart_id"].'&action=delete"><img src="/images/bsk_item_del.png"></a></div>
		<div id="bottom-cart-line"></div>
		</div>
		';
}while($row_c = mysql_fetch_array($result_c));
} 

if(mysql_num_rows($result_r) > 0)
{
	do
		{
			$int = $row_r["cart_price"] * $row_r["cart_count"];//для цены товара на кол-во
			$all_price = $all_price + $int;//цена всеъ товаров
	echo'
		<div class="block-list-cart">
		<div class="img-cart">
		<p align="center"><img src="./product_images/'.$row_r["image"].'" width="120" height="105"></p>
		</div>
		<div class="title-cart">
		<p class ="cart_products"><a >'.$row_r["name"].'</a></p>
		</div>

		<div class="count-cart">
		<ul class="input-count-style">
		<li>
		<p align="center" class="count-minus">-</p>
		</li>
		
<li><p align="center"><input class="count-input" maxlength="3" type="text" value="'.$row_r["cart_count"].'"></p></li>

		<li>
		<p align="center" class="count-plus">+</p>
		</li>
		</ul>
		</div>
		<div class="price-product"><h5><span class="span-count">'.$row_r["cart_count"].'</span> x <span>'.$row_r["cart_price"].'</span></h5><p>'.$int.'</p></div>
		<div class="delete-cart"><a href="cart.php?id='.$row_r["cart_id"].'&action=delete"><img src="/images/bsk_item_del.png"></a></div>
		<div id="bottom-cart-line"></div>
		</div>
		';
}while($row_r = mysql_fetch_array($result_r));
} 

	echo '  
		<h2 class="itog-price" align="right">Итого: <strong>'.$all_price.'</strong> руб.</h2>
		<p align="right" class="button-next"><a href="cart.php?action=confirm">Далее</a></p> 
		'; 
}
		else{
			echo '<h3 id="clear-cart" align="center">Корзина пуста</h3>';
		}
		break;
	}
?>

</div>


<?php 
include("include/block-footer.php");//подключаем футер(подвал)
?>



</div>	
</body>
</html>
<?php }else{echo'<!DOCTYPE html>
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
	<title>Корзина заказов</title>
</head>
<body>
<div id="block-body">
';
	include("include/block-heade.php");//подключаем шапку сайта
	echo '<div id="cart_reg">Требуется регистрация!</div>';
	include("include/block-footer.php");
	echo'</div>	
</body>
</html>';
} ?>



















