<?php
spl_autoload_register();
use App\RegistrationBase;

$reg = new RegistrationBase;
?>


<!DOCTYPE HTML> 
<html> 
<head> 
<meta charset="utf-8"> 
<title>Test_Form</title> 
</head> 
<body> 
<h2 align="center">Файлы: </h2>
<form action="del.php" method="POST"> 
<?php
$reg->read_to_db();
?>
<p><input type="submit" value="Удалить данные"></p> 
</form>  
<p><a href="/SHU/sign">Вернутся к форме</a></p>
</body> 
</html>
