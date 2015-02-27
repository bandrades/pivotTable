<?php
require_once("medoo/medoo.php");

class CdrRepository{

	private $db = null;
	private $start;
	private $end;

	public function __construct($start,$end){
			$cfg = array(
		    'database_type' => 'mysql',
		    'database_name' => 'talkalot',
		    'server' => 'db1.aws.ligflat.com.br',
		    'username' => 'luismr',
		    'password' => 'Trustm3!',
		    'port' => 3306,
		    'charset' => 'utf8',
		    'Option' => [PDO :: ATTR_CASE => PDO :: CASE_NATURAL]
		);

		$this->db = new medoo($cfg);
		$this->start = $start;
		$this->end = $end;
	}

	public function process(){
		$query = "SELECT date_format(dateCreated,'%Y-%m'), type, peer, carrier, billmin " .
					" FROM cdrs " .
					" where dateCreated >= '" . $this->start . " 00:00:00' " .
					" and dateCreated <= '" . $this->end . " 23:59:59' " .
					" LIMIT 1000";

		$data = $this->db->query($query)->fetchAll();

		return $data;
	}
}
?>