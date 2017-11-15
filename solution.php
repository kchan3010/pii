<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';


use thinkHr\Classes\EntryDataTransformer;
use thinkHr\Classes\PersonalIdentifier;
use thinkHr\Classes\UnitedStatesValidator;


array_shift($argv);
if (count($argv) == 0) {
    $argv = "php://stdin";
}

$usa_validator = new UnitedStatesValidator();
$transformer = new EntryDataTransformer();
$identifier = new PersonalIdentifier($usa_validator, $transformer);

$handle = fopen($argv[0], 'r');
while(($lineData = fgetcsv($handle)) !== FALSE)
{
    if($lineData[0] !== NULL)
    {
        $identifier->process($lineData);
    }
}

$filename = $argv[1];
$identifier->getResults($filename);

fclose($handle);
