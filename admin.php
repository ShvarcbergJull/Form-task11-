<!DOCTYPE HTML> 
<html> 
<head> 
<meta charset="utf-8"> 
<title>Test_Form</title> 
</head> 
<body> 
<h2 align="center">Файлы: </h2>
<?php 
$fd = fopen('formfile/data.txt', 'r+');
?> 
<form action="del.php" method="POST"> 
<?php
while (!feof($fd))
{
	$ft = htmlentities(fgets($fd));
	$str = array();	
	$str = explode("|", trim($ft));
	if (!empty($str[0]))
	{
		if (trim($str[9]) === "n")
			echo "<input type='checkbox' name='f[]' value=".$str[7].">".$str[7]."<br>";
	}
}
?> 
<p><input type="submit" value="Удалить данные"></p> 

</form>  
<p><a href="/SHU/sign">Вернутся к форме</a></p>
</body> 
</html>
