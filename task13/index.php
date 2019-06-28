<?php
spl_autoload_register();

use App\RegistrationBase;
error_reporting(0);
$reg = new RegistrationBase;
if (!empty($_POST))
{
	$reg->treatment();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Форма регистрации</title>
</head>
<body>
	<h1 align="center">Форма регистрации</h1>
	<form action="<?= $_SERVER['REQUEST_URI'];?>" method="POST">
		<p><input placeholder="Имя" name="name" value="<?= isset($_POST['name']) ? $_POST['name']:''?>"><?php echo $reg->echo_error('name') ?></p>

		<p><input placeholder="Фамилия" name="lastname" value="<?= isset($_POST['lastname']) ? $_POST['lastname']:''?>" required><?php echo $reg->echo_error('lastname') ?></p>

		<p><input placeholder="Эл.адрес" name="email" value="<?= isset($_POST['email']) ? $_POST['email']:''?>" required><?php echo $reg->echo_error('email') ?></p>

		<p><input placeholder="Телефон" name="phone" value="<?= isset($_POST['phone']) ? $_POST['phone']:''?>" required><?php echo $reg->echo_error('phone') ?></p>
		
		<p>Выберете тематику конференции</p>
		<p>
		<select name="topic"> 
			<optgroup label="Тема"> 
				<option value="bus" name="bus">Бизнес</option> 
				<option value="tex" name="tex">Технологии</option>
				<option value="RM" name="RM">Реклама и Маркетинг</option>
			</optgroup> 
		</select></p>

		<p>Выберете способ оплаты</p>
		<p>
		<select name="pay"> 
			<optgroup label="Оплата"> 
				<option value="WM" name="WM">WebMoney</option> 
				<option value="ya" name="ya">Yandex.money</option>
				<option value="PP" name="PP">PayPal</option>
				<option value="cc" name="cc">Credit card</option>
			</optgroup> 
		</select>

		<p>Хотите получать рассылку?<input type="checkbox" name="jel"></p>
	<p><input type="submit" value="Отправить"></p>
	</form>

	<form action="admin_test.php">
		<p><input type="submit" value="Админ"></p>
	</form>

</body>
</html>
