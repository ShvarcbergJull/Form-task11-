<?php 
namespace App;

include 'Flash.php';
//error_reporting(0);
use PDO;

class RegistrationBase
{
	private $name;
	private $lastname;
	private $email;
	private $phone;
	private $jel;
	private $error = array();
	public $table='participants';
	public $table2='subjects';
	public $table3='payments';
	private $topic = array(
		"bus" => "Бизнес",
		"tex" => "Технология",
		"RM" => "Реклама и маркетинг"
	);
	private $pay = array(
		"WM" => "Web-Money",
		"ya" => "yandex.money",
		"pp" => "PayPal",
		"cc" => "Credit Card"
	);

	private $dateCreate;
	private $dateUpdate;
	private $dateDelete;


	public function echo_error($key)
	{
		return $this->error[$key];
	}

	private function validate()
	{
		foreach (['name', 'lastname', 'email', 'phone', 'topic', 'pay'] as $key) 
		{
			if(empty($this->$key))
			{
				$this->error[$key] = "Это поле обязательно для ввода";
			}
		}

		if (!empty($this->error))
		{
			return false;
		}

		if (preg_match("/^[А-Я][а-я]+$/", $this->name) == null)
		{
			$this->error['name'] = "Введите имя русскими буквами, начиная с заглавной буквы";
		}

		if (preg_match("/^[А-Я][а-я]+$/", $this->lastname) == null)
		{
			$this->error['lastname'] = "Введите фамилию русскими буквами, начиная с заглавной буквы";
		}

		if (preg_match("/^[a-z0-9]+@[a-z]+\.[a-z]+$/i", $this->email) == null)
		{
			$this->error['email'] = "Вы неверно ввели e-mail";
			return false;
		}

		if (preg_match("/^(\+7|8)( ?)\d{3}( ?)\d{3}(-?)\d{2}(-?)\d{2}$/", $this->phone) == null)
		{
			$this->error['phone'] = "Вы неправильно ввели номер телефона";
			return false;
		}
		else
		{
			$this->phone = preg_replace("/^(\+7|8)(?: ?)(\d{3})(?: ?)(\d{3})(?:\-?)(\d{2})(?:\-?)(\d{2})$/", "$1 $2 $3-$4-$5", $this->phone);
		}

		return true;
	}

	public static function get_pdo(){
		$_pdo;
        if (empty($_pdo))
        {
            $_pdo = new PDO('mysql:host=localhost;dbname=form','root',''); 
        }

        return $_pdo;
    }

	public function save_in_db()
	{
		switch ($this->topic) {
			case 'bus':
				$t = 1;
				break;

			case 'tex':
				$t = 2;
				break;
			
			case 'RM':
				$t = 3;
				break;
		}

		switch ($this->pay) {
			case 'WM':
				$p = 1;
				break;
			
			case 'ya':
				$p = 2;
				break;

			case 'pp':
				$p = 3;
				break;

			case 'cc':
				$p = 4;
				break;
		}

        $sql = static::get_pdo()->prepare('INSERT INTO `'.$this->table.'` (`name`,`lastname`,`email`,`phone`,`subject_id`,`payment_id`,`deleted_at`, `created_at`, `update_at`) VALUES (?,?,?,?,?,?,?,?,?);');

        $sql->execute(array($this->name,$this->lastname,$this->email,$this->phone,$t,$p,$this->dateDelete, $this->dateCreate, $this->dateUpdate));

        return $sql->rowCount() === 1;
	}

	public function read_to_db()
	{
		$sql = static::get_pdo()->prepare('SELECT t1.id, t1.name, lastname, email, phone, t2.sub_name, t3.pay_name, created_at, update_at, deleted_at FROM `' . $this->table . '` t1,`' . $this->table2 . '` t2,`' . $this->table3 . '` t3 WHERE t1.subject_id = t2.id AND t1.payment_id = t3.id AND `deleted_at` is NULL;');
        $sql->execute();

        $objects = [];

        while ($object = $sql->fetchObject(static::class))
        {
            $str=$object->id."|".$object->name."|".$object->lastname."|".$object->email."|".$object->phone."|".$object->sub_name."|".$object->pay_name."|".$object->created_at."|".$object->updated_at;
            $res = preg_replace("/ /","", $str);
            echo "<input type='checkbox' name='f[]' value=".$res.">".$str."<br>";
            $objects[] = $object;
        }

        return $objects;
	}

	public function del(){
        if(empty($_POST['f'])){ 
                echo "<h2>Вы ничего не выбрали!</h2>";
        } 
        else{
            $af=$_POST['f'];
            $arr=array();
            foreach ($af as $key) {
                $res=explode('|', $key);
                array_push($arr, $res[0]);
            }
            echo "Удаление файлов:\n";
            $n=count($af);
            for($i=0;$i<$n;$i++){
                echo $af[$i]."<br>"; 
            }
            foreach ($arr as $k) { 
                $sql = $this->get_pdo()->prepare('UPDATE `'.$this->table.'` SET `deleted_at` = ? WHERE `id` = ?;');
                $sql->execute(array(date('Y-m-d-H-i-s'),$k)); 
                $n--;
            }
            if ($n == 0)
            	echo "<h2>Файлы удалены</h2>";
            else
            	echo "<h2>Некоторые файлы не были удалены</h2>";
        }
    }

	public function treatment()
	{
		$this->name = isset($_POST['name']) ? trim($_POST['name']) : null;
		$this->lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : null;
		$this->email = isset($_POST['email']) ? trim($_POST['email']) : null;
		$this->phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
		$this->topic = isset($_POST['topic']) ? trim($_POST['topic']) : null;
		$this->pay = isset($_POST['pay']) ? trim($_POST['pay']) : null;
		$this->jel = isset($_POST['jel']) ? 'yes' : 'no';
		$this->dateCreate = date('Y-m-d-H-i-s');
		$mes = new Flash;
		$mes->set('<h2>Ваша заявка отправлена успешно!</h2>');

		if ($this->validate())
		{
			$this->save_in_db();
			echo $mes->get();
			//header('Location: /SHU/sign/form.php');
			exit;
		}
	}
}
