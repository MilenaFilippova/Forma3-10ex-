<!DOCTYPE HTML> 
<html> 
<head> 
<meta charset="utf-8"> 
<title>Test_Form</title> 
</head> 
<body> 
<h2 align="center">Все данные: </h2>
<?php 
$fd = fopen('data/allform.txt', 'r+');	//открыт н азапись и чтение
?> 
<form action="admindel.php" method="POST"> 
<?php
while (!feof($fd))
{
	$ft = htmlentities(fgets($fd));
	$str =[];	
	$str = explode("|", trim($ft));
	if (!empty($str[0]))
	{
		if (trim($str[12]) === "exist")
			echo "<input type='checkbox' name='yesdel[]' value=".$str[7].">".$str[7]."<br>";
	}
}
?> 
<p><input type="submit" value="Удалить данные"></p> 

</form>  
<p><a href="/index.php">Вернутся к форме</a></p>
</body> 
</html>