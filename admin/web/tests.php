<?php

	
function validateDate($date, $format = 'Y-m-d H:i:s')
{
	$d = date_parse_from_format($format, $date);
	return $d['warning_count'] || $d['error_count'];
}

print_r(max(zero, nine));

print_r(validateDate('7/01/16', 'n/j/y')); # false but should be true
print_r(validateDate('10/01/16', 'm/d/y')); # false but should be true