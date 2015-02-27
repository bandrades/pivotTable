<?php 
require 'flight/Flight.php';

Flight::route('GET /', function() {
	$SID = session_id(); 
	if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session'); 

	Flight::render('layout.php', null);
});

Flight::route('POST /', function(){
	$SID = session_id(); 
	if(empty($SID)) session_start() or exit(basename(__FILE__).'(): Could not start session'); 

    $request = Flight::request();

	$_SESSION['start'] = $request->data['inicio'];
	$_SESSION['end'] = $request->data['fim'];

	Flight::render('layout.php', null);
});

Flight::route('GET /data', function() {
	Flight::render('data.php', null);
});

Flight::start();

?>