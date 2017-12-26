$(document).ready(function(){
  loadcart();
  $("#block-sorting-list").hide();//убираем блок с листовым вариантом(скрываем)
 $("#style-grid").click(function(){
		$("#block-tovar-grid").show();//показать
 		$("#block-tovar-list").hide();//скрыть
 		$("#style-grid").attr("src","/images/icon-grid-active.png");
 		$("#style-list").attr("src","/images/list.png");
 		
 		$.cookie('select_style','grid');
 });



  $("#style-list").click(function(){
 		$("#block-tovar-grid").hide();
 		$("#block-tovar-list").show();
	 $("#style-list").attr("src","/images/list-active.png");
	 $("#style-grid").attr("src","/images/icon-grid.png");

	$.cookie('select_style','list');
 });

  if($.cookie('select_style') == 'grid'){
  	$("#block-tovar-grid").show();//показать
 		$("#block-tovar-list").hide();//скрыть
 		$("#style-grid").attr("src","/images/icon-grid-active.png");
 		$("#style-list").attr("src","/images/list.png");
  }
  else{
  	$("#block-tovar-grid").hide();
 		$("#block-tovar-list").show();

	$("#style-list").attr("src","/images/list-active.png");
	$("#style-grid").attr("src","/images/icon-grid.png");
  }





  $("#select-sort").click(function(){
  		$("#sorting-list").slideToggle(200);//slideToogle довйное нажатие 200-скорость
  });



//Листинг

  $('#block-category > ul > li > a').click(function(){//#block-category, указываем на ul ... указываем на ссылку(a)// метод click - отслеживает нажатие
    if($(this).attr('class') != 'active'){// проверяем не является ссылка классу active  , ключевое слово this - параметр, передает на какую именно ссылку мы нажимаем  ЕСЛИ ССЫЛКА НЕ РАВНЯЕТСЯ КЛАССУ АКТИВ
      $('#block-category > ul > li > ul').slideUp(400);//ТО ЗАКРЫВАЕМ ВСЕ КАТЕГОРИИ
      $(this).next().slideToggle(400);//открываем именно то, на что мы нажали   .next - метод открывает следующий список slideToggle 
        $('#block-category > ul > li > a').removeClass('active');//удаление всех классов
        $(this).addClass('active');//присваем КОНКРЕТНОЙ(this)категории active  
        $.cookie('celect_cat'.$(this).attr('id'));//cookie - для запоминания того, что было открыто  $(this).attr('id') - указываем на конкретные категории
    }
    else
    {
      $('#block-category > ul > li > a').removeClass('active');//если перестает быть активной ссылка, удаляет все активные классы
      $('#block-category > ul > li > ul').slideUp(400);//закрыть все списки
      $.cookie('select_cat','');  //сохраняем пустой cookie  
    }
});
    if($.cookie('select_cat') != '')
    {
      $('#block-category > ul > li > #'+$cookie('select_cat')).addClass('active').next().show();//если существует cookie с назваием select_cat и не пустой, то указываем на id категория +(соеденить) добавляем(addClass) класс указать следующые ссылки(next)  и показать (show)
    }


      $('#genpass').click(function(){
 $.ajax({
  type: "POST",
  url: "/functions/genpass.php",
  dataType: "html",
  cache: false,
  success: function(data) {
  $('#reg_pass').val(data);
  }
});
}); 



$('.top-auth').toggle(//класс кнопки"ВХОД ВЕРХНЕЙ"   toggle для того, чтобы форма исчезала(двойное нажатие)
  function(){
    $(".top-auth").attr("id","active-button");//появление формы
    $("#block_top_auth").fadeIn(300);//плавное появление, интервал появления
  },
  function(){
    $(".top-auth").attr("id","");//исчезание кнопки
    $("#block_top_auth").fadeOut(300);
  }
  );
//ДЛЯ скрытия и показания кода
$('#button_pass_show_hide').click(function(){
 var statuspass = $('#button_pass_show_hide').attr("class");
   
    if (statuspass == "pass-show")
    {
       $('#button_pass_show_hide').attr("class","pass-hide");
        
                            var $input = $("#auth_pass");
                            var change = "text";
                            var rep = $("<input placeholder='Пароль' type='" + change + "' >")
                                .attr("id", $input.attr("id"))
                                .val($input.val())
                                .insertBefore($input);
                            $input.remove();
                            $input = rep;
         
    }else
    {
        $('#button_pass_show_hide').attr("class","pass-show");
         
                            var $input = $("#auth_pass");
                            var change = "password";
                            var rep = $("<input placeholder='Пароль' type='" + change + "' >")
                                .attr("id", $input.attr("id"))
                                .val($input.val())
                                .insertBefore($input);
                            $input.remove();
                            $input = rep;        
        
    }
     
});


///////////////

$("#button_auth").click(function() {
        
 var auth_login = $("#auth_login").val();//помещаем !!!!значения!!! полей
 var auth_pass = $("#auth_pass").val();
 
  
 if (auth_login == "" || auth_login.length > 30 )
 {
    $("#auth_login").css("borderColor","#FDB6B6");
    send_login = 'no';
 }else {
     
   $("#auth_login").css("borderColor","#DBDBDB");
   send_login = 'yes'; 
      }
 
  
if (auth_pass == "" || auth_pass.length > 15 )
 {
    $("#auth_pass").css("borderColor","#FDB6B6");
    send_pass = 'no';
 }else {  $("#auth_pass").css("borderColor","#DBDBDB");  send_pass = 'yes'; }
 
 
 

 if ( send_login == 'yes' || send_pass == 'yes' )
 { 
    $.ajax({
  type: "POST",
  url: "include/auth.php",
  data: "login="+auth_login+"&pass="+auth_pass,
  dataType: "html",
  cache: false,
  success: function(data) {
 
  if (data == 'yes_auth')
  {
      location.reload();
  }else
  {
      $("#message_auth").slideDown(400);
      $("#button_auth").show();
       
  }
   
}
});  
}
});


$('#auth_user_info').toggle(
  function(){
    $('#block-user').fadeIn(300);
  },
  function(){
    $('#block-user').fadeOut(300);
  }
);

$('#logout').click(function(){
  $.ajax({
    type:"POST",
    url:"/include/logout.php",
    dataType:"html",
    cache: false,
    success: function(data){
      if(data == 'logout')
      {   
        location.reload();
      }
    }
  });
});


$('#confirm-button-next').click(function(e){
//Проверка самовывозы
if(!$(".order_delivery").is(":checked"))
{
  $(".label_delivery").css("color","#E07B7B");
  send_order_delivery = '0';
}else{$(".label_delivery").css("color","black"); send_order_delivery = '1';}

if(send_order_delivery == '1')
{//Отправка формы
  return true;
}
e.preventDefault();
});



$('.add-cart-style-list, .add-cart-style-grid').click(function(){
               
 var tid = $(this).attr("tid");
 
 $.ajax({
  type: "POST",
  url: "../include/addtocart.php",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) { 
  loadcart();
      }
});
 
});
 
function loadcart(){

     $.ajax({
  type: "POST",
  url: "/include/loadcart.php",
  dataType: "html",
  cache: false,
  success: function(data) {
    
  if (data == 0)
  {
   
    $("#cart > a").html("Корзина пуста");
     
  }else
  {
    $("#cart > a").html(data);
 
  }  
     
      }
});    
        
}
 
 
 /*function fun_group_price(intprice) {  
    // Группировка цифр по разрядам
  var result_total = String(intprice);
  var lenstr = result_total.length;
   
    switch(lenstr) {
  case 4: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
    break;
  }
  case 5: {
  groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
    break;
  }
  case 6: {
  groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6); 
    break;
  }
  case 7: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7); 
    break;
  }
  default: {
  groupprice = result_total;  
  }
}  
    return groupprice;
    }*/


$('#button-next').click(function(){
  alert("123");
 $.ajax({
  type: "POST",
  url: "../include/count_all.php",
  data: 1,
  dataType: "html",
  cache: false,
  success: function(data){
      if(data == 0)
      {   
        location.reload();
      }}
});
 
});



});
