<?php 
session_start();
//подключение к файлу с БД
include("include/db_connect.php");
include("functions/functions.php");

$search = clear_string($_GET["q"]);//принимаем переменную поиска
//СОРИТРОВКА

$sorting = $_GET["sort"];//_GET - вытасиваем переменную с url-строки[название перменной]

switch ($sorting)//switch - сверяет инфу, и при сответствии выполнятет дейстивие
{
	case 'price-asc';//case - с чем будем сравнивать
	$sorting = 'products.price ASC';//price_ поле в БД
	$sort_name = 'От дешевых к дорогим';
	break;

	case 'price-desc';
	$sorting = 'products.price DESC';
	$sort_name = 'От дорогих к дешевым';
	break;


	default:
	$sorting = 'products.id_products DESC';
	$sort_name = 'Не сортировки';
	break;	
}

//unset($_SESSION['auth']);
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
	<title>Поиск – <?php echo $search; ?></title>
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
if(strlen($search)>=3 && strlen($search) < 64)
	{
?>


<ul id="block-tovar-grid">
<?php 
 $num = 9;//указываем, сколько хотим выводить товаров на сайт
 $count = mysql_query("SELECT COUNT(*) FROM `products`, `coins` b WHERE products.id_products = b.id_products AND (b.denomination LIKE '%$search%' OR b.curr_un LIKE '%$search%' OR products.year LIKE '%$search%')",$link);//подсчет всех товаров
 $count_bank = mysql_query("SELECT COUNT(*) FROM `products`,`banknotes` a WHERE products.id_products = a.id_products AND (a.denomination LIKE '%$search%' OR a.curr_un LIKE '%$search%' OR products.year LIKE '%$search%')",$link);
 $count_rew = mysql_query("SELECT COUNT(*) FROM `products`, `rewards` c WHERE products.id_products = c.id_products AND (c.name LIKE '%$search%')",$link);
 $temp = mysql_fetch_array($count);//помещаем в тпеременную значние запроса $count
 $temp1 = mysql_fetch_array($count_bank);
 $temp2 = mysql_fetch_array($count_rew);
 $count_all = $temp[0] + $temp1[0] + $temp2[0];
if($count_all > 0)//если в переменной есть товары то.....
{
	$tempcount = $count_all;//помещаем в переменую кол-во товаров
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
//ПОСТРАНИЧНАЯ НАВИГАЦИЯ
//ВЫВОД ТОВАРОВ
//1)SQL-запрос
$result = mysql_query("SELECT * FROM `products`, `coins` b WHERE products.id_products = b.id_products AND (b.denomination LIKE '%$search%' OR b.curr_un LIKE '%$search%' OR products.`year` LIKE '%$search%')  AND products.count > 0 AND products.type='monets' ORDER BY $sorting $query_start_num",$link) or die(mysql_error());

$result_bank = mysql_query("SELECT * FROM `products`,`banknotes` a WHERE products.id_products = a.id_products AND (a.denomination LIKE '%$search%' OR a.curr_un LIKE '%$search%' OR products.`year` LIKE '%$search%') AND products.count > 0 AND products.type='bancnots'ORDER BY $sorting $query_start_num",$link)or die(mysql_error());

$result_rew = mysql_query("SELECT * FROM `products`, `rewards` c WHERE products.id_products = c.id_products AND (c.name LIKE '%$search%') AND products.count > 0 AND products.type='rewards' ORDER BY $sorting $query_start_num",$link)or die(mysql_error());
//Проверка(найдены ли товары в таблице)
if($count_all > 0)//если в переменной есть товары то.....
{

	echo '
		<div id="block-sorting">
		<p id="nav-breadcrumbs"><a href="index.php">Главная страница</a> \ <span>Поиск</span></p>
		<ul id="option-list">
			<li>Вид:</li>
			<li><img  id="style-grid" src="images/icon-grid-active.png" alt=""></li>
			<li><img  id="style-list" src="images/list.png" alt=""></li>
			<li>Сортировать:</li>
			<li><a id="select-sort">'.$sort_name.'</a>
					<ul id="sorting-list">
						<li><a href="search.php?q='.$search.'&sort=price-asc">От дешевых к дорогим</a></li><!--sort-переменная, в которой будет хранится название сортировки-->
						<li><a href="search.php?q='.$search.'&sort=price-desc">От дорогих к дешевым</a></li>
					</ul>

			</li>
		
		</ul>
	</div>';
if(mysql_num_rows($result) > 0 )//если полей больше 0, то выполняем действие
{
	$row = mysql_fetch_array($result);//массив с результатом запроса
	//Вывод товара через do while
	do
	{//'..'-разры строчки   $row[]-что именно нужно вывести     //class(block-images-grid, блок с картинкой)
//УМЕНЬШЕНИЕ КАРТИНКИ С СОХРАНЕНИЯМИ ПРОПОРЦИЙ
		echo  '  
			<li>
				<div class="block-product">
          <div class="block-images-grid">
						<img src="/product_images/'.$row["image"].'">
          </div>
					<div class="a1"><p class="style-title-grid"><a href="">'.$row["denomination"].' '.$row["curr_un"].', '.$row["year"].'</a></p></div>
					<a class="add-cart-style-grid" tid="'.$row["id_products"].'">В Корзину</a>
					<p class="style-price-grid" ><b>'.$row["price"].'</b> руб.</p>
					</div>
			</li>';
		}
		while($row = mysql_fetch_array($result));
}
			

if(mysql_num_rows($result_bank) > 0 ){
				$row_bank = mysql_fetch_array($result_bank);
				do
				{
			echo '<li>
				<div class="block-product">
          <div class="block-images-grid">
						<img src="/product_images/'.$row_bank["image"].'">
          </div>
					<div class="a1"><p class="style-title-grid"><a href="">'.$row_bank["denomination"].' '.$row_bank["curr_un"].', '.$row_bank["year"].'</a></p></div>
					<a class="add-cart-style-grid" tid="'.$row_bank["id_products"].'">В Корзину</a>
					<p class="style-price-grid" ><b>'.$row_bank["price"].'</b> руб.</p>
					</div>
			</li>';
}while($row_bank = mysql_fetch_array($result_bank));
		}
			


if(mysql_num_rows($result_rew) > 0){
	$row_rew = mysql_fetch_array($result_rew);
	do{
	echo'
<li>
	<div class="block-product">
   <div class="block-images-grid">
		<img src="/product_images/'.$row_rew["image"].'">
   </div>
	 <div class="a1"><p class="style-title-grid"><a href="">'.$row_rew["name"].'</a></p></div>
		<a class="add-cart-style-grid" tid="'.$row_rew["id_products"].'">В Корзину</a>
		<p class="style-price-grid" ><b>'.$row_rew["price"].'</b> руб.</p>
   </div>
</li>';
}
while($row_rew = mysql_fetch_array($result_rew));
}
//class(style-title-grid) - название        class(add-cart...) - кнопка  class(style-price-grid) - для цены


echo'</ul>';


?>


<!--2222222222222222222222-->
<ul id="block-tovar-list">
<?php 
//ВЫВОД ТОВАРОВ
//1)SQL-запрос
$result = mysql_query("SELECT * FROM `products`, `coins` b WHERE products.id_products = b.id_products AND (b.denomination LIKE '%$search%' OR products.year LIKE '%$search%') AND products.count > 0 AND products.type='monets' ORDER BY $sorting $query_start_num",$link)or die(mysql_error());
$result_bank = mysql_query("SELECT * FROM `products`,`banknotes` a WHERE products.id_products = a.id_products AND (a.denomination LIKE '%$search%' OR products.year LIKE '%$search%') AND products.count > 0 AND products.type='bancnots' ORDER BY $sorting $query_start_num",$link)or die(mysql_error());
$result_rew = mysql_query("SELECT * FROM `products`, `rewards` c WHERE products.id_products = c.id_products AND (c.name LIKE '%$search%') AND products.count > 0 AND products.type='rewards' ORDER BY $sorting $query_start_num",$link)or die(mysql_error());
//Проверка(найдены ли товары в таблице)
if($count_all > 0)//если в переменной есть товары то.....
{
echo '
		<div id="block-sorting">
		<p id="nav-breadcrumbs"><a href="index.php">Главная страница</a> \ <span>Поиск</span></p>
		<ul id="option-list">
			<li>Вид:</li>
			<li><img  id="style-grid" src="images/icon-grid-active.png" alt=""></li>
			<li><img  id="style-list" src="images/list.png" alt=""></li>
			<li>Сортировать:</li>
			<li><a id="select-sort">'.$sort_name.'</a>
					<ul id="sorting-list">
						<li><a href="index.php?sort=price-asc">От дешевых к дорогим</a></li><!--sort-переменная, в которой будет хранится название сортировки-->
						<li><a href="index.php?sort=price-desc">От дорогих к дешевым</a></li>
					</ul>

			</li>
		
		</ul>
	</div>';
if(mysql_num_rows($result) > 0 )//если полей больше 0, то выполняем действие
{
	$row = mysql_fetch_array($result);//массив с результатом запроса

	//Вывод товара через do while
	do
	{//'..'-разры строчки   $row[]-что именно нужно вывести     //class(block-images-grid, блок с картинкой)
	
//УМЕНЬШЕНИЕ КАРТИНКИ С СОХРАНЕНИЯМИ ПРОПОРЦИЙ
		echo  '  
			<li>
				<div class="block-product-list">
          <div class="block-images-list">
						<img src="/product_images/'.$row["image"].'">
          </div>
					<div class="a1"><p class="style-title-list"><a href="">'.$row["denomination"].' '.$row["curr_un"].', '.$row["year"].'</a></p></div>
					<a class="add-cart-style-list" tid="'.$row["id_products"].'">В Корзину</a>
					<p class="style-price-list" ><b>'.$row["price"].'</b> руб.</p>
					</div>
			</li>';
				}
	while($row = mysql_fetch_array($result));/*) && ($row_bank = mysql_fetch_array($result_bank)) && ($row_rew = mysql_fetch_array($result_rew)));*///выполняться до тех пор, пока не кончатся товары в таблице(поля)
}
if(mysql_num_rows($result_bank) > 0 )//если полей больше 0, то выполняем действие
{
	$row_bank = mysql_fetch_array($result_bank);
			do{
			echo'<li>
				<div class="block-product-list">
          <div class="block-images-list">
						<img src="/product_images/'.$row_bank["image"].'">
          </div>
					<div class="a1"><p class="style-title-list"><a href="">'.$row_bank["denomination"].' '.$row_bank["curr_un"].', '.$row_bank["year"].'</a></p></div>
					<a class="add-cart-style-list" tid="'.$row_bank["id_products"].'">В Корзину</a>
					<p class="style-price-list" ><b>'.$row_bank["price"].'</b> руб.</p>
					</div>
			</li>';
			}
			while($row_bank = mysql_fetch_array($result_bank));
}
if(mysql_num_rows($result_rew) > 0 )//если полей больше 0, то выполняем действие
{	
	$row_rew = mysql_fetch_array($result_rew);
	do{
	echo'
			<li>
				<div class="block-product-list">
          <div class="block-images-list">
						<img src="/product_images/'.$row_rew["image"].'">
          </div>
					<div class="a1"><p class="style-title-list"><a href="">'.$row_rew["name"].'</a></p></div>
					<a class="add-cart-style-list" tid="'.$row_rew["id_products"].'">В Корзину</a>
					<p class="style-price-list" ><b>'.$row_rew["price"].'</b> руб.</p>
					</div>
			</li>
		';
	}while($row_rew = mysql_fetch_array($result_rew));
}
//class(style-title-grid) - название        class(add-cart...) - кнопка  class(style-price-grid) - для цены

echo'</ul>';	

//ДЛЯ ФОРМИРОВАНИЯ ССЫЛОК
if ($page != 1){ $pstr_prev = '<li><a class="pstr-prev" href="search.php?q='.$search.'&page='.($page - 1).'">&lt;</a></li>';}//для ссылки "назад", если ссылка не 1, то кнопка есть и работает
if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="search.php?q='.$search.'&page='.($page + 1).'">&gt;</a></li>';//для ссылки "вперед", если не есть общее кол-во страница, то выводим 
 
 
// Формируем ссылки со страницами
if($page - 5 > 0) $page5left = '<li><a href="search.php?q='.$search.'&page='.($page - 5).'">'.($page - 5).'</a></li>';//если результат больше нуля, то формируются ссылки
if($page - 4 > 0) $page4left = '<li><a href="search.php?q='.$search.'&page='.($page - 4).'">'.($page - 4).'</a></li>';
if($page - 3 > 0) $page3left = '<li><a href="search.php?q='.$search.'&page='.($page - 3).'">'.($page - 3).'</a></li>';
if($page - 2 > 0) $page2left = '<li><a href="search.php?q='.$search.'&page='.($page - 2).'">'.($page - 2).'</a></li>';
if($page - 1 > 0) $page1left = '<li><a href="search.php?q='.$search.'&page='.($page - 1).'">'.($page - 1).'</a></li>';
 
if($page + 5 <= $total) $page5right = '<li><a href="search.php?q='.$search.'&page='.($page + 5).'">'.($page + 5).'</a></li>';//если результат менье общего кол-ва страниц, то формируются ссылки
if($page + 4 <= $total) $page4right = '<li><a href="search.php?q='.$search.'&page='.($page + 4).'">'.($page + 4).'</a></li>';
if($page + 3 <= $total) $page3right = '<li><a href="search.php?q='.$search.'&page='.($page + 3).'">'.($page + 3).'</a></li>';
if($page + 2 <= $total) $page2right = '<li><a href="search.php?q='.$search.'&page='.($page + 2).'">'.($page + 2).'</a></li>';
if($page + 1 <= $total) $page1right = '<li><a href="search.php?q='.$search.'&page='.($page + 1).'">'.($page + 1).'</a></li>';

//Проверка на вывод многоточиё общего вывода страниц
if ($page+5 < $total)
{
    $strtotal = '<li><p class="nav-point">...</p></li><li><a href="search.php?q='.$search.'&page='.$total.'">'.$total.'</a></li>';
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
    echo $pstr_prev.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active' href='search.php?page=".$page."'>".$page."</a></li>".$page1right.$page2right.$page3right.$page4right.$page5right.$strtotal.$pstr_next;
    echo '
    </ul>
    </div>
    ';
}

}else{
	echo '<p align="center" style="font: bold 25px sans-serif;">Ничего не найдено!</p>';
}
}else{
	echo '<p align="center" style="font: bold 25px sans-serif;">Ничего не найдено!</p>';
}
}else{
	echo '<p align="center" style="font: bold 25px sans-serif;">Поисковое значение должно быть от 3 и до 64 символов</p>';
}
?>

</div>


<?php 
include("include/block-footer.php");//подключаем футер(подвал)
?>



</div>	
</body>
</html>



















