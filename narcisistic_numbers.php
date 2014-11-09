<?php

$num_count = 0;
$i = 1;
while($num_count < 25) {
	// convert int to string then explode and save as array
	$digits = str_split($i);
	
	// save digit count to variable
	$digit_count = count($digits);

	// see if the sum of each digit to the power equal to the digit count is equal to the original number
	$total = 0;
	foreach ($digits as  $digit) {
		$total += pow($digit, $digit_count);
	}

	// if it is then print it and increase num_count by one
	if ($total == $i) {
		echo $i . PHP_EOL;
		$num_count++;
	}
	$i++;
} 