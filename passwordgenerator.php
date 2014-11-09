<?php

$args = getopt('l::s');

$chars = [
	'alpha_chars' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'],

	'num_chars' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
];

$special_chars = ['`',  '!', '"', '?', '$', '?', '%', '^', '&', '*', '(', ')', '_', '-', '+', '=', '{', '[', '}', ']', ':', ';', '@', '\'', '~', '#', '|', '\\', '<', ',', '>', '.', '?', '/'];

var_dump($args);

var_dump(isset($args['s']));

if (isset($args['l'])) {
	$password_length = $args['l'];
} else {
	$password_length = 15;
}

if(isset($args['s'])) {
	$chars['special_chars'] = $special_chars;
}

$password = '';

for ($i=0; $i < $password_length ; $i++) { 
	$new_char_type = array_rand($chars);
	$new_char = array_rand($chars[$new_char_type]);
	$password .= $chars[$new_char_type][$new_char];
}

echo $password;