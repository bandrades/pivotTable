<?php

require_once("CdrRepository.php");
require_once("Csv_Writer.php");

$SID = session_id(); 
if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session'); 

$start = $_GET['start'];
$end = $_GET['end'];

$repository = new CdrRepository($start, $end);
$csv = new Csv_Writer();

$result = $repository->process();
$csv->write($result);

?>