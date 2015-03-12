<?php

require_once("CdrRepository.php");
require_once("Csv_Writer.php");

$SID = session_id(); 
if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session'); 

$start = $_GET['start'];
$end = $_GET['end'];
$type = $_GET['type']; 

$repository = new CdrRepository($start, $end, $type);
$csv = new Csv_Writer();

$result = $repository->process();
$csv->write($result);

?>