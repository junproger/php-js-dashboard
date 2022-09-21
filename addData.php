<?php

$newData = Array("id" => 15, "name" => "name name", "power" => 100500);

function addData($newData) {
	
	if(!is_array($newData) || sizeof($newData) <= 0) return print_r("The data is empty");
	
	$tempData = json_decode(file_get_contents('temp.json'), true);
	$tempData[] = $newData;
	
	file_put_contents('temp.json', json_encode($tempData));
	
	return print_r(
		json_encode($tempData)
	);
};

addData($newData);
