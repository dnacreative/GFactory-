<?php	
// NOTE: Remove error reporting when in production
// error_reporting(E_ALL); 
// ini_set('display_errors', 1);

// Define the super path constant
define("GAL_PATH", 'my_galleries');

// Splits camelCased words - Regex on stackoverflow: 
// stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression
function fixCamelCase($file_name) {	
	$name = "";
	$re = '/(?<=[a-z])(?=[A-Z])/x';
	$w_array = preg_split($re, $file_name);
	$w_count = count($w_array);

	if ($w_count > 1) {
		for ($i = 0; $i < $w_count; ++$i) { 
			$name .= $w_array[$i]. " "; 
		}

		// trim on return because an extra space is attached on the concat above
		return trim($name);
	} else {
		return $file_name;
	}		
}

// Gets a friendly name from an already extracted filename
function fixFileName($file_name) {
	$name = str_replace('-', ' ', $file_name);
	$name = str_replace('_', ' ', $name);

	// Split camelCased words if necessary
	$name = fixCamelCase($name);

	return ucwords($name);
}	

// Gets a friendly name from the file path
function fixFilePath($file_path) { 
	// Retrieve file name by retrieving the basename and by removing the extension
	$name = strstr(basename($file_path), '.', true);

	// Remove dash and/or underscore
	$name = fixFileName($name);

	return ucwords($name);
}

// Autoload function that runs every time we instaniate a class that hasn't been loaded yet and includes it
function __autoload($class) {
	$class_path = 'classes/class.'.strtolower($class).'.php';

	if (file_exists($class_path)) {
		include_once($class_path);
	}
}