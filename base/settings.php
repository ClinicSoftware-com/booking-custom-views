<?php

function dump( $x, bool $doExit = true ) {

    echo "<pre>";
    echo json_encode($x, JSON_PRETTY_PRINT);
    echo "<pre>";

    if ( $doExit ) exit();
}

// Enable errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '1G');
error_reporting(E_ALL);

// Make sure the environment exists
if ( !file_exists("../env.json") ) {
    // Throw the error
    throw new Exception("Failed to load the environment, please make sure the `env.json` file exists.");
    // Make sure to exist, just in case.
    exit();
}

// Load in all the variables
$environmentVariables = json_decode(file_get_contents("../env.json"), true);

foreach( $environmentVariables as $k => $v ) {
    ${$k} = $v;
}

// Load variables in memory
extract($environmentVariables);