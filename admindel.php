<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
	//error_reporting(0);
	mb_internal_encoding('utf-8');
	error_reporting(0);
	include "functions.php";
	if(empty($_POST['yesdel']))
	{ 
		echo ("Вы ничего не выбрали для удаления"); 
	}
	else
	{ 
		$del=$_POST['yesdel']; 
		$j=count($del); 
		echo "<p>Все данные: </p>";
		for ($i = 0;$i < $j;$i++)
		{
			str_replace([":", "/"], ["", ""], $del[$i]);
			echo $del[$i].":удаление.\n";
		} 
		if (chek_newdel($del))
		{
	 		echo "<p><b>Выбранные данные удалены!</b></p>";
	 	}
	 	else
	 	{
	 		echo "<p><b>Не удалось удалить эти данные!</b></p>";
	 	}
	 }
?>

<form action="admin.php">
	<p><input type="submit" value="Вернуться к файлам"></p>
</form>
</body>
</html>
