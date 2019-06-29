<?php
spl_autoload_register();
include_once   '\clasess\InviteForm.php'; 
function chek_newdel($del)
{
	$pole =[];
	$form= new InviteForm;
	array_push($pole,[]);
	$j = 0;
	$pole[$j] = new InviteForm;
	while ($pole[$j]->read_to_file($j))
	{
		array_push($pole,[]);
		$j++;
		$pole[$j] = new InviteForm;
	}
	unset($pole[$j]);	//разрушает переменные
	$j = 0;
	$count = 0;
	
	
	foreach ($del as $j) 
	{
		foreach ($pole as $key) 
		{
			if ($key->get_date() == $j)
			{
				$pole[$j]->status = "del";
				$j = 0;
				$count++;
				break;
			}
			$j++;
		}
	}
	file_put_contents("data/allform.txt", '');
	foreach ($pole as $key) {
		$key->save();
	}
	if ($count === count($del))
		return true;
	return false;
}
