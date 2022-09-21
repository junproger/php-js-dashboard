<?php

function getData() {
	
	$tempData = file_get_contents('temp.json');
	
	echo "${tempData} \n <br /> <br /> \n";

	return (
		print_r(json_decode($tempData, true))
	);
	
};

getData();
