<?php
class Csv_Writer
{
	public $stream, $wrote = false;

	function __construct() {
		header( 'Content-Type: csv' );
		$this->stream = fopen('php://output', 'w');
	}

	function write($data)
	{
		foreach ($data as $row)
			fputcsv($this->stream, $row);

		fflush($this->stream);
	}

	function __destruct() {
		fclose($this->stream);
	}
}
?>