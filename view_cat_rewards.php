<?php 
//подключение к файлу с БД
include("include/db_connect.php");
//подключение functions
include("functions/functions.php");
session_start();
//ВЫВОД ТОВАРОВ ПО КАТЕГОРИЯМ
$cat = clear_string($_GET["cat"]);
$type = clear_string($_GET["type"]);

//СОРИТРОВКА
$sorting = $_GET["sort"];//_GET - вытасиваем переменную с url-строки[название перменной]

switch ($sorting)//switch - сверяет инфу, и при сответствии выполнятет дейстивие
{
	case 'products.price-asc';//case - с чем будем сравнивать
	$sorting = 'price ASC';//price_ поле в БД
	$sort_name = 'От дешевых к дорогим';
	break;

	case 'products.price-desc';
	$sorting = 'price DESC';
	$sort_name = 'От дорогих к дешевым';
	break;


	default:
	$sorting = 'products.id_products DESC';
	$sort_name = 'Не сортировки';
	break;	
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="trackbar/jQuery/trackbar.css" type="text/css">
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
	


<?php 
//ПРВОЕРКА НА СУЩЕСТВОВАНИЕ СТРАНЫ И ТИП
if(!empty($cat) && !empty($type))//если переменная существует
{
	$query_cat = "country='$cat' AND type='$type'";//И страна = той стране, которую мы выбрали и тому типу 
	$cat_link = "cat=$cat&";
}
else
{
	if(!empty($type))//если существует только тип(в ссылке), то выводит все этого типа
	{
		$query_cat = "type='$type'";
	}
	else
	{
		$query_cat = "";
	}
	if(!empty($cat))//если существует только тип(в ссылке), то выводит все этого типа
	{
		$cat_link = "cat='.$cat.'&";
	}
	else
	{
		$cat_link = "";
	}
}
//ВЫВОД ТОВАРОВ
//1)SQL-запрос
$num = 9;//указываем, сколько хотим выводить товаров на сайт
 $page = (int)$_GET['page'];

 $count = mysql_query("SELECT COUNT(*) FROM `products` WHERE $query_cat",$link);//подсчет всех товаров
 $temp = mysql_fetch_array($count);//помещаем в тпеременную значние запроса $count

if($temp[0] > 0)//если в переменной есть товары то.....
{
	$tempcount = $temp[0];//помещаем в переменую кол-во товаров
	//Находим общее число страниц
	$total = (($tempcount - 1)/$num)+1;//кол-во товаров - 1, чтобы если число нецелое, чтобы выводился остаток на следующей странице
	$total = intval($total);//округление кол-ва страниц

	$page = intval($page);//округление для url строки

	if(empty($page) or $page<0)//если переменной с url нет, или page=0, то..
	{
		$page = 1;//помещаем в переменную единицу
	}
	if($page > $total)//если в Url page > максимального значения страниц, то...
	{
		$page = $total;//помещаем в переменную последнюю страницу()макс.число
	}
	//Вычисляем начиная с какого следует выводить товары
	$start = $page * $num - $num;//в перменную старт записывается значение страницы  (страницу * на кол-во товаров и минус этогоже кол-ва)

	$query_start_num = "LIMIT $start, $num";//LIMIT - сколько нужно вывести
}
$result = mysql_query("SELECT * FROM products INNER JOIN rewards ON products.id_products = rewards.id_products WHERE $query_cat AND products.count > 0 AND products.type='rewards' ORDER BY $sorting $query_start_num",$link) or die(mysql_error());
//Проверка(найдены ли товары в таблице)
if(mysql_num_rows($result) > 0)//если полей больше 0, то выполняем действие
{
	$row = mysql_fetch_array($result);//массив с результатом запроса
	//Вывод товара через do while

	//СОРТИРОВКА
	echo '
	<div id="block-sorting">
		<p id="nav-breadcrumbs"><a href="index.php">Главная страница</a> \ <span>Все товары</span></p>
		<ul id="option-list">
			<li>Вид:</li>
			<li><img  id="style-grid" src="images/icon-grid-active.png" alt=""></li>
			<li><img  id="style-list" src="images/list.png" alt=""></li>
			<li>Сортировать:</li>
			<li><a id="select-sort">'.$sort_name.'</a>
					<ul id="sorting-list">
						<li><a href="view_cat_rewards.php?'.$cat_link.'type='.$type.'&sort=price-asc">От дешевых к дорогим</a></li><!--sort-переменная, в которой будет хранится название сортировки-->
						<li><a href="view_cat_rewards.php?'.$cat_link.'type='.$type.' & sort=price-desc">От дорогих к дешевым</a></li>
					</ul>

			</li>
		
		</ul>
	</div>
	<ul id="block-tovar-grid">
	';
	//СОРТИРОВКА
	do
	{//'..'-разры строчки   $row[]-что именно нужно вывести     //class(block-images-grid, блок с картинкой)
	
//УМЕНЬШЕНИЕ КАРТИНКИ С СОХРАНЕНИЯМИ ПРОПОРЦИЙ
		echo  '  
			<li>
				<div class="block-product">
          <div class="block-images-grid">
						<img src="/product_images/'.$row["image"].'">
          </div>
					<div class="a1"><p class="style-title-grid"><a href="">'.$row["name"].'</a></p></div>
					<a class="add-cart-style-grid" tid="'.$row["id_products"].'">В Корзину</a>
					<p class="style-price-grid" ><b>'.$row["price"].'</b> руб.</p>
					</div>
			</li>

		';
//class(style-title-grid) - название        class(add-cart...) - кнопка  class(style-price-grid) - для цены
	}
	while($row = mysql_fetch_array($result));//выполняться до тех пор, пока не кончатся товары в таблице(поля)
}


?>

</ul>	



<!--2222222222222222222222-->

<?php 
//ВЫВОД ТОВАРОВ в ВАРИАНТЕ ЛИСТА(листом,а не сеткой)
//1)SQL-запрос

$result = mysql_query("SELECT * FROM products INNER JOIN rewards ON products.id_products = rewards.id_products WHERE $query_cat AND products.count > 0 AND products.type='rewards' ORDER BY $sorting $query_start_num",$link) or die(mysql_error());

//Проверка(найдены ли товары в таблице)
if(mysql_num_rows($result) > 0 )//если полей больше 0, то выполняем действие
{
	$row = mysql_fetch_array($result);//массив с результатом запроса
	//Вывод товара через do while

		//СОРТИРОВКА
	echo '
	<div id="block-sorting-list">
		<p id="nav-breadcrumbs"><a href="index.php">Главная страница</a> \ <span>Все товары</span></p>
		<ul id="option-list">
			<li>Вид:</li>
			<li><img  id="style-grid" src="images/icon-grid-active.png" alt=""></li>
			<li><img  id="style-list" src="images/list.png" alt=""></li>
			<li>Сортировать:</li>
			<li><a id="select-sort">'.$sort_name.'</a>
					<ul id="sorting-list">
						<li><a href="view_cat_rewards.php?'.$cat_link.'type='.$type.'&sort=price-asc">От дешевых к дорогим</a></li><!--sort-переменная, в которой будет хранится название сортировки-->
						<li><a href="view_cat_rewards.php?'.$cat_link.'type='.$type.' & sort=price-desc">От дорогих к дешевым</a></li>
					</ul>

			</li>
		
		</ul>
	</div>
<ul id="block-tovar-list">
	';
	//СОРТИРОВКА
	do
	{//'..'-разры строчки   $row[]-что именно нужно вывести     //class(block-images-grid, блок с картинкой)
	
//УМЕНЬШЕНИЕ КАРТИНКИ С СОХРАНЕНИЯМИ ПРОПОРЦИЙ
		echo  '  
			<li>
				<div class="block-product-list">
          <div class="block-images-list">
						<img src="/product_images/'.$row["image"].'">
          </div>
					<div class="a1"><p class="style-title-list"><a href="">'.$row["name"].'</a></p></div>
					<a class="add-cart-style-list" tid="'.$row["id_products"].'">В Корзину</a>
					<p class="style-price-list" ><b>'.$row["price"].'</b> руб.</p>
					</div>
			</li>

		
		';
//class(style-title-grid) - название        class(add-cart...) - кнопка  class(style-price-grid) - для цены
	}
	while($row = mysql_fetch_array($result));//выполняться до тех пор, пока не кончатся товары в таблице(поля)
}
echo'</ul>';	
//ДЛЯ ФОРМИРОВАНИЯ ССЫЛОК
if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page - 1).'">&lt;</a></li>';}//для ссылки "назад", если ссылка не 1, то кнопка есть и работает
if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page + 1).'">&gt;</a></li>';//для ссылки "вперед", если не есть общее кол-во страница, то выводим 
 
 
// Формируем ссылки со страницами
if($page - 5 > 0) $page5left = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page - 5).'">'.($page - 5).'</a></li>';//если результат больше нуля, то формируются ссылки
if($page - 4 > 0) $page4left = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page - 1).'">'.($page - 1).'</a></li>';
 
if($page + 5 <= $total) $page5right = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page + 5).'">'.($page + 5).'</a></li>';//если результат менье общего кол-ва страниц, то формируются ссылки
if($page + 4 <= $total) $page4right = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.($page + 1).'">'.($page + 1).'</a></li>';

//Проверка на вывод многоточиё общего вывода страниц
if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page='.$total.'">'.$total.'</a></li>';
}else
{
    $strtotal = ""; 
}
 //Если страниц больше одной, то выводим постраничную навигацию
if ($total > 1)
{
    echo '
    <div class="pstrnav">
    <ul>
    ';
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='view_cat_rewards.php?cat='.$cat.'&type='.$type.'&page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '
    </ul>
    </div>
    ';
}
?>
</div>


<?php 
include("include/block-footer.php");//подключаем футер(подвал)
?>



</div>	
</body>
</html>



















