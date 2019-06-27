<?php
spl_autoload_register();

use App\Registration;

function delt($af)
{
	$filelist = file_get_contents("formfile/data.txt");
	$filelist = explode("\n", $filelist);
	$i = 0;
	foreach ($af as $j) {
		foreach ($filelist as $key => $values) {
			$str = explode("|", $values);
			if ($str[6] == $j)
			{
				$str[8] = "y";
				$filelist[$key] = implode("|", $str);
				$i++;
				break;
			}
		}
	}
	$filelist = implode("\n", $filelist);
	file_put_contents("formfile/data.txt", $filelist);
	if ($i === count($af))
		return true;
	return false;
}

function delt_test($af)
{
	$arob = array();
	$reg = new Registration;
	array_push($arob, array());
	$i = 0;
	$arob[$i] = new Registration;
	while ($arob[$i]->read_to_file($i)){
		array_push($arob, array());
		$i++;
		$arob[$i] = new Registration;
	}
	unset($arob[$i]);
	$i = 0;
	$count = 0;
	foreach ($af as $j) {
		foreach ($arob as $key) {
			if ($key->get_date() == $j)
			{
				$arob[$i]->statusDel = "y";
				$i = 0;
				$count++;
				break;
			}
			$i++;
		}
	}
	file_put_contents("formfile/data.txt", '');
	foreach ($arob as $key) {
		$key->save_in_file();
	}
	if ($count === count($af))
		return true;
	return false;
}
