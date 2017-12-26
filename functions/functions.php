<?php  

function clear_string($cl_str)
{
	$cl_str = strip_tags($cl_str);//удаления всех тегов 
$cl_str = mysql_real_escape_string($cl_str);//очистка спец.символо(? ''), для того, чтобы нельзя было формировать запрос через UrL
$cl_str = trim($cl_str);//trim - удаление пробелов

return $cl_str;
}

function group_numerals($int){
	switch(strlen($int)){
		case '4':
		$price = substr($int,0,1).' '.substr($int,1,4);
		break;
		case '5':
		$price = substr($int,0,2).' '.substr($int,2,5);
		break;
		case '6':
		$price = substr($int,0,3).' '.substr($int,3,6);
		break;
		default:
		$price = $int;
		break;
	}
	return $price;
}


?>