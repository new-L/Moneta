$(document).ready(function() {
submitHandler: function(form){
    $(form).ajaxSubmit({//отправляется в обработчик, который указали в форме
    success: function(data) { //проверяет данные, которые были отправлены
                                  
        if (data == true)//если все норм
    {
       $("#block-form-registration").fadeOut(300,function() {//селектор метод Fate... плавно убирает блок
         
        $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегистрированы!");//Вывод удачной регистрации
        $("#form_submit").hide();//исезнуть
         
       });
          
    }
    else
    {
       $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data); //Ошибка
    }
        } 
            }); 
            }
        });
