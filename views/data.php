<?php

require_once("CdrRepository.php");
ini_set('memory_limit','524288');

$SID = session_id(); 
if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session'); 

$start = $_SESSION['start'];
$end = $_SESSION['end'];

$repository = new CdrRepository($start, $end);
$data = $repository->process();


//JSArray e JSON
//echo json_encode($data);

//CSV

function convert_to_csv($input_array, $output_file_name, $delimiter)
{
    /** open raw memory as file, no need for temp files */
    $temp_memory = fopen('php://memory', 'w');
    /** loop through array  */
    foreach ($input_array as $line) {
        /** default php csv handler **/
        fputcsv($temp_memory, $line, $delimiter);
    }
    /** rewrind the "file" with the csv lines **/
    fseek($temp_memory, 0);
    /** modify header to be downloadable csv file **/
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($temp_memory);
}


convert_to_csv($data, 'report.csv', ',');

//xml
/*$xml = new SimpleXMLElement('<root/>');
array_walk_recursive($data, array ($xml, 'addChild'));*/

//http://www.jidesoft.com/products/pivot.htm
//https://pivot.apache.org/
//http://www.zkoss.org/product/zkpivottable
//http://webpivottable.com/

?>