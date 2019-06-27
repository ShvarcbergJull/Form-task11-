<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
	//error_reporting(0);
	include "script.php";
	if(empty($_POST['f'])){ 
		echo ("вы ничего не выбрали"); 
	} 
	else{ 
		$af=$_POST['f']; 
		$j=count($af); 
		echo "<p>Файлы: </p>";
		for ($i = 0;$i < $j;$i++)
		{
			str_replace([":", "/"], ["", ""], $af[$i]);
			echo $af[$i]."-удаление...\n";
		} 
		if (delt_test($af))
		{
	 		echo "<p><b>Файлы успешно удалены!</b></p>";
	 	}
	 	else
	 	{
	 		echo "<p><b>Некоторые файлы не были удалены</b></p>";
	 	}
	 }
?>

<form action="admin.php">
	<p><input type="submit" value="Вернуться к файлам"></p>
</form>
</body>
</html>
