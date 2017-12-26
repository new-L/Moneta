<?php 
//подключение к файлу с БД
include("include/db_connect.php");
//подключение functions
include("functions/functions.php");
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<!--подключаение jquery для смены вида товара-->
    <script type="text/javascript" src="/js/jquery-1.8.2.min.js"></script><!--подключаение jquery для смены вида товара-->
    <script type="text/javascript" src="/js/jquery-3.2.1.js"></script> 
    <script type="text/javascript" src="trackbar/jQuery/jquery.trackbar.js"></script>
  <script type="text/javascript" src="trackbar/jQuery/jquery-1.2.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script><!--подключение куки для запоминания страниц-->
     
     <script type="text/javascript" src="/js/jquery.form.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.js"></script>  
    <script type="text/javascript" src="/js/TextChange.js"></script>
    <script type="text/javascript" src="js/shop.js"></script>
    
   
    

	<!--<script type="text/javascript" src="js/jquery.cookie.js"></script>--><!--подключение куки для запоминания страниц-->
    <!--<script type="text/javascript" src="js/jquery.form.js"></script>--><!--подключаение jquery для смены вида товара-->
	<!--<script type="text/javascript" src="js/jquery.validate.js"></script>--><!--подключение куки для запоминания страниц-->
      
	<script type="text/javascript">
$(document).ready(function() {  
      $('#form_reg').validate(
                {   
                    // правила для проверки
                    rules:{
                        "reg_login":{
                            required:true,
                            minlength:5,
                            maxlength:25,
                            remote: {
                            type: "post",    
                            url: "/reg/check_login.php"
                                    }
                        },
                        "reg_pass":{
                            required:true,
                            minlength:7,
                            maxlength:15
                        },
                        "reg_surname":{
                            required:true,
                            minlength:3,
                            maxlength:40
                        },
                        "reg_name":{
                            required:true,
                            minlength:3,
                            maxlength:40
                        },
                        "reg_patronymic":{
                            required:true,
                            minlength:3,
                            maxlength:40
                        },
                        "reg_email":{
                            required:true,
                            email:true
                        },
                        "reg_phone":{
                            required:true
                        },
                    },
 
                    // выводимые сообщения при нарушении соответствующих правил
                    messages:{
                        "reg_login":{
                            required:"Укажите Логин!",
                            minlength:"От 5 до 15 символов!",
                            maxlength:"От 5 до 15 символов!",
                            remote: "Логин занят!"
                        },
                        "reg_pass":{
                            required:"Укажите Пароль!",
                            minlength:"От 7 до 15 символов!",
                            maxlength:"От 7 до 15 символов!"
                        },
                        "reg_surname":{
                            required:"Укажите вашу Фамилию!",
                            minlength:"От 3 до 40 символов!",
                            maxlength:"От 3 до 40 символов!"                           
                        },
                        "reg_name":{
                            required:"Укажите ваше Имя!",
                            minlength:"От 3 до 40 символов!",
                            maxlength:"От 3 до 40 символов!"                              
                        },
                        "reg_patronymic":{
                            required:"Укажите ваше Отчество!",
                            minlength:"От 3 до 40 символов!",
                            maxlength:"От 3 до 40 символов!" 
                        },
                        "reg_email":{
                            required:"Укажите свой E-mail",
                            email:"Не корректный E-mail"
                        },
                        "reg_phone":{
                            required:"Укажите номер телефона!"
                        }
                    },
                     
    submitHandler: function(form){
    $(form).ajaxSubmit({
    success: function(data) { 
                                  
    if (data == true)
    {
       $("#block-form-registration").fadeOut(300,function() {
         
        $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегистрированы!");
        $("#form_submit").hide();
         
       });
          
    }
    else
    {
       $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data); 
    }
        } 
            }); 
            }
            });
        });
      
</script>
	<title>Регистрация</title>
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
	 <h2 class="h2-title">Регистрация</h2>
	 <form method="POST" id="form_reg" action="/reg/handler_reg.php"><!--Куда отправляется-->
			<p id="reg_message"></p>
			<!--БЛОК ДЛЯ ИНПУТОВ-->
			<div id="block-form-registration">
				<ul id="form-registration">
						<li>
							<label for="">Логин</label>
							<span class="star">*</span>
							<input type="text" name="reg_login" id="reg_login">
						</li>
						<li>
							<label for="">Пароль</label>
							<span class="star">*</span>
							<input type="text" name="reg_pass" id="reg_pass">
							<span id="genpass">Сгенерировать</span>
						</li>
						<li>
							<label for="">Имя</label>
							<span class="star">*</span>
							<input type="text" name="reg_name" id="reg_name">
						</li>
						<li>
							<label for="">Фамилия</label>
							<span class="star">*</span>
							<input type="text" name="reg_surname" id="reg_surname">
						</li>
						<li>
							<label for="">Отчество</label>
							<span class="star">*</span>
							<input type="text" name="reg_patronymic" id="reg_patronymic">
						</li>
						<li>
							<label for="">E-mail</label>
							<span class="star">*</span>
							<input type="text" name="reg_email" id="reg_email">
						</li>
						<li>
							<label for="">Мобильный телефон</label>
							<span class="star">*</span>
							<input type="text" name="reg_phone" id="reg_phone">
						</li>
						<li>
							<label id="address">Адрес доставки</label>
                            <ul>
							<li><label id="country_users">Страна</label><span class="star">*</span><input type="text" name="reg_address_country" id="reg_address_country"></li>
                            <li><label id="gor_ray">Город/Район</label><span class="star">*</span><input type="text" name="reg_address_gor_ray" id="reg_address_gor_ray"></li>
                            <li><label id="village">Село</label><input type="text" name="reg_address_village" id="reg_address_village"></li>
                            <li><label id="street">Улица</label><span class="star">*</span><input type="text" name="reg_address_street" id="reg_address_street"></li>
                            <li><label id="house">Дом</label><span  class="star">*</span><input type="text" name="reg_address_house" id="reg_address_house"></li>
                            <li><label id="kvar">Квартира</label><input type="text" name="reg_address_kv" id="reg_address_kv"></li>
                            <li><label id="index_">Почтовый индекс</label><span  class="star">*</span><input type="text" name="reg_address_index" id="reg_address_index"></li>
                        </ul>
						</li>
						<p align="right"><input type="submit" name="reg_submit" id="form-submit" value="Регистрация"></p>
				</ul>
			</div>
	 </form>
</div>

<?php 
include("include/block-footer.php");//подключаем футер(подвал)
?>



</div>	
</body>
</html>



















