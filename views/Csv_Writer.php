<?php
class Csv_Writer
{
	public $stream, $wrote = false;

	function __construct() {
		header( 'Content-Type: text/csv' );
		$this->stream = fopen('php://output', 'w');
	}

	function write($data)
	{
		if (!$this->wrote) {
			$keys = array_keys($data[0]);
			fputcsv($this->stream, $keys);
			$this->wrote = true;
		}

		foreach ($data as $row)
			fputcsv($this->stream, $row);

		fflush($this->stream);
	}

	function __destruct() {
		fclose($this->stream);
	}
}
?>