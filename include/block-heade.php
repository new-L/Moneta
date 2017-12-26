<div id="block-header">
<div id="header-top-block">
<ul id="header-top-menu">
	<li>Ваш город - <span>Симферополь</span></li>
	<li><a href="o-nas.php">О нас</a></li>
	<li><a href="../delivery_payment.php">Доставка и оплата</a></li>
	<li><a href="contacts.php">Контакты</a></li>
</ul>	

<?php 
if($_SESSION['auth'] == 'yes_auth')
{
 echo '<p id="auth_user_info" align="right"><img src="/images/user.png">Здравствуйте, '.$_SESSION['auth_name'].'!</p>';
}
else 
{
	echo '<p id="reg-auth-title" align="right"><a  class="top-auth">Вход</a><a href="registration.php">Регистрация</a></p>';
 } 
?>


<div id="block_top_auth"><!--Вход-->
	<div class="corner"></div>
	<form  method="post">
		<ul id="input_email_pass">
			<h3>Вход</h3>
			<p id="message_auth">Неверный Логин и(или) Пароль</p>
			<li><center><input type="text" name="login" id="auth_login" placeholder="Логин или E-mail"></center></li>
			<li><center><input type="password" name="pass" id="auth_pass" placeholder="Пароль"><span id="button_pass_show_hide" class="pass-show"></span></center></li><!--id для JS, чтобы кликать class для отображение глаза-->
			<ul id="list_auth">
				<li><input type="checkbox" name="rememberme" id="rememberme"><label for="rememberme">Запомнить меня</label></li>
			</ul>
			<p align="right" id="button_auth"><a>Вход</a></p>
		</ul>
	</form>




</div>
</div>	
<hr id="line" color="#E3E3E3">

<div id="block-user">
	<div class="corner2"></div>
	<ul>
			<li><img src="/images/user_info.png"><a href="profile.php">Профиль</a></li>
			<li><img src="/images/logout.png"><a id="logout">Выход</a></li>
	</ul>
</div>


<a href="../index.php"><img id="img-logo" src="images/logotip.png" alt="Moneta"></a>
<div id="logo-text">
	Интернет-магазин нумизматики<br>
	
</div>
<!--<div id = "logo-text2">Я как нищий – коллекционер монет.
У меня есть всё, но у меня ничего нет ©newL</div>-->
<div id="personal-info">
	<p align="right">Телефон</p>
	<h3 align="right">8 (918) 95-58-962</h3>
	<img src="/images/Telephone.png">

	<p align="right">Эллектронная почта</p>
	<h3 align="right">moneta@gmail.com</h3>
	<img src="/images/mail.png" class="mail">

</div>

<div id="block-search">
	<form method="GET" action="search.php?q="><!--Через url передача  будет передаваться в переменную q значение поля-->
		<input type="text" id="input-search" name="q" placeholder=" Поиск..." value="<?php echo $search; ?>"><!--placeholde-надпись внутри поиска-->
		<input type="submit" id="button-search" value="Поиск"><!--кнопка-->
	</form>


</div>



</div>
<div>
	<p align="right" id="cart"><img src="/images/cart-icon.png" alt="Корзина"><a href="cart.php?action=oneclick" >Корзина пуста</a></p>
<hr id="line" color="#E3E3E3">
</div>
