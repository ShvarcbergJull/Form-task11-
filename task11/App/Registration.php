<?php

namespace App;

class Registration
{
	private $name;
	private $lastname;
	private $email;
	private $phone;
	private $jel;
	private $error = array();
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
	private $ipaddr;
	public $statusDel;

	private function check()
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

		if (preg_match("/^[a-z0-9]+@[a-z]+\.[a-z]+$/i", $this->email) == null)
		{
			$this->error['email'] = "Вы неверно ввели e-mail";
			return false;
		}

		if (preg_match("/^(\+7|8)\d{10}$/", $this->phone) == null)
		{
			$this->error['phone'] = "Вы неправильно ввели номер телефона";
			return false;
		}

		return true;
	}

	public function echo_error($key)
	{
		return $this->error[$key];
	}

	public function get_date()
	{
		return $this->dateCreate;
	}

	public function save_in_file()
	{
		$this->ipaddr = $_SERVER['REMOTE_ADDR'];
		if (empty($this->statusDel))
			$this->statusDel = "n";
		$contents = $this->name."|".$this->lastname."|".$this->email."|".$this->phone."|".$this->topic."|".$this->pay."|".$this->jel."|".$this->dateCreate."|".$this->ipaddr."|".$this->statusDel."\n";
		
		file_put_contents("formfile/data.txt", $contents, FILE_APPEND);
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

		if ($this->check())
		{
			$this->save_in_file();
			header('Location: /SHU/sign/form.php');
			exit;
		}

	}

	public function read_to_file($i)
	{
		$filelist = file_get_contents("formfile/data.txt");
		$filelist = explode("\n", trim($filelist));
		if (!isset($filelist[$i]))
			return false;
		$str = explode("|", trim($filelist[$i]));

		$j = 0;
		foreach (['name', 'lastname', 'email', 'phone', 'topic', 'pay', 'jel', 'dateCreate', 'ipaddr', 'statusDel'] as $key) {
			$this->$key = $str[$j];
			$j++;
		}

		return true;
	}
}
