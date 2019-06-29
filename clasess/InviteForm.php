<?php
include   '/../config.php';

class InviteForm
{
	private $name;
	private $lastname;
	private $age;
	private $city;
	private $phone;
	private $email;
	private $tema = 
	[
		"Bus" => "Бизнес",
		"Tex" => "Технология",
		"RM" => "Реклама и маркетинг"
	];
	private $agree;
	private $pay = 
	[
		"WM" => "Web-Money",
		"YA" => "yandex.money",
		"PP" => "PayPal",
		"CC" => "Credit Card"
	];
	
	private $dateCreate;
	private $ipaddr;
	public $status;
	
	private $error = [];
	
	public function save()
	{
		$this->ipaddr = $_SERVER['REMOTE_ADDR']; 
		if (empty($this->status))
			$this->status = "n";
		$contents = $this->name."|".$this->lastname ."|".$this->age."|".$this->phone."|".$this->city."|".
		$this->email."|".$this->tema."|".$this->agree."|".$this->pay ."|".$this->dateCreate."|".$this->ipaddr."|".$this->status."\n";
		
		file_put_contents("data/allform.txt", $contents, FILE_APPEND);
	}
	
	private function validate()
	{
		foreach (['name', 'lastname',  'age', 'city', 'phone', 'email', 'tema','agree', 'pay'] as $key) 
		{
			if(empty($this->$key))
			{
				$this->error[$key] = "Ошибка.Заполните поле";
			}
		}
		if (!empty($this->error))	//проверка всех полей на пустоту
		{
			return false;
		}
		if(!preg_match_all('/^[А-Я]{1}[а-яА-Я]{2,}$/',$this->name))	//проверка имени
		{
			$this->error['name'] = "Неверно введено имя";
			return false;
		}
		if(preg_match_all('/^[А-Я]{1}[а-яА-Я]{2,29}$/',$this->lastname) == null)	//проверка фамилии
		{
			$this->error['lastname'] = "Неверно введена фамилия";
			return false;
		}
		if (preg_match('/^[a-z0-9]+@[a-z]+\.[a-z]+$/', $this->email) == null)	//проверка почты
		{
			$this->error['email'] = "Вы неверно ввели e-mail";
			return false;
		}
		
		if (preg_match('/^(\+7|8)\d{10}$/', $this->phone) == null)	//проверка номера телефона
		{
			$this->error['phone'] = "Неверно введен номер телефона";
			return false;
		}
		else
		{
			$this->phone=format_phone($this->phone);
		}
		return true;
	}
	
	public function format_phone($phone)
	{	
			$patterns= ['/^(\+7|8)((\d){3})((\d){3})((\d){2})(\d{2})$/'];	//+79991234566
			$replacements = ['${1} ${2} ${4}-${6}-${8}'];	////+7 999 123-45-66
			$phone= preg_replace($patterns, $replacements, $phone);
			return $phone;
	}
	public function errors_print($key)
	{
		return $this->error[$key];
	}
	public function get_date()
	{
		return $this->dateCreate;
	}
	
	
	public function treatment()
	{
		$this->name = isset($_POST['name']) ? trim($_POST['name']) : null;
		$this->lastname = isset($_POST['lastname']) ? trim($_POST['lastname']) : null;
		$this->age = isset($_POST['age']) ? trim($_POST['age']) : null;
		$this->phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
		$this->city = isset($_POST['city']) ? trim($_POST['city']) : null;
		$this->email = isset($_POST['email']) ? trim($_POST['email']) : null;
		$this->tema = isset($_POST['tema']) ? trim($_POST['tema']) : null;
		$this->agree = isset($_POST['agree']) ? 'yes' : 'no';
		$this->dateCreate = date('Y-m-d-H-i-s');
		
		if ($this->validate())	//если нет ошибок
		{
			$this->save();
			include "/templates/answer.php";
			exit;
		}
	}
	public function read_to_file($i)
	{
		$filelist = file_get_contents("data/allform.txt");
		$filelist = explode("\n", trim($filelist));
		if (!isset($filelist[$i]))
			return false;
		$str = explode("|", trim($filelist[$i]));
		$j = 0;
		foreach (['name', 'lastname',  'age', 'city', 'phone', 'email', 'tema','agree', 'pay', 'dateCreate', 'ipaddr', 'status'] as $key) 
		{
			$this->$key = $str[$j];
			$j++;
		}
		return true;
	}
}