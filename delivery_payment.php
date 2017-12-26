<?php 
session_start();
//подключаем шапку категории для подключения для всех страниц легче-_-
	include("include/db_connect.php");
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
<?php 	include("include/block-heade.php"); ?>
	<div class="main">	
			<p class="p-1">При заказе товара учитывайте следующие особенности:</p>
		<ul class="us">
			<li>Заказы на сумму больше 1 000 рублей отправляются только  после получения предоплаты.</li>
			<li>Оптовые заказы должны быть предоплачены онлайн в течении 24 часов с момента оформления.</li>
			<li>Доставка EMS доступна при заказе от 10 000 рублей.</li>
		</ul>
		<p class="p-2">Мы отправляем заказы по всей России. На сайте предусмотрены следующие виды доставки:</p>
		<div class="table-1">
			<table class="table-main">
				<tr>
					<td>
						<span class="pochta">ПОЧТА РОССИИ</span>
					</td>
					<td>
						<span class="EMS">EMS</span>
					</td>
				</tr>
			</table>	
		</div>
		<div>
			<h3>Способы оплаты</h3>
			<div class="table-2">
				<table class="table-main">
					<tr>
						<td>
							<span class="sber">Cбербанка</span>
						</td>
						
						<td>
							<span class="wm">WebMoney</span>
						</td>
					</tr>
					<tr>
						<td>
							<span class="yandex">Яндекс.Деньги</span>
						</td>
						
						<td>
							<span class="qw">Qiwi</span>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
<?php 
	include("include/block-footer.php");//подключаем шапку категории для подключения для всех страниц легче-_-
?>
</div>
</body>
</html>
