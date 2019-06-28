<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php 
spl_autoload_register();
use App\RegistrationBase;

$reg = new RegistrationBase;
$reg->del();
?>

<form action="admin_test.php">
	<p><input type="submit" value="Вернуться к файлам"></p>
</form>
</body>
</html>
