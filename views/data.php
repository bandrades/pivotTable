<?php

require_once("CdrRepository.php");
require_once("Csv_Writer.php");

$SID = session_id(); 
if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session'); 

$start = $_SESSION['start'];
$end = $_SESSION['end'];

$qtd_page = 5000;

$repository = new CdrRepository($start, $end);
$total = $repository->countDate();
$num_page = (int) ceil($total / $qtd_page);
$csv = new Csv_Writer();

for($i = 1; $i <= $num_page; $i++){
    $result = $repository->process($i,$qtd_page);
    $csv->write($result);
}

?>