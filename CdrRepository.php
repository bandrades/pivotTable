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
		    'username' => 'brunaas',
		    'password' => 's3nh@f0rt3987',
		    'port' => 3306,
		    'charset' => 'utf8',
		    'Option' => [PDO :: ATTR_CASE => PDO :: CASE_NATURAL]
		);

		$this->db = new medoo($cfg);
		$this->start = $start;
		$this->end = $end;
	}

	public function process($page,$qtd_page){
		$query = "SELECT date_format(dateCreated,'%Y-%m') as Periodo, type, peer, carrier, billmin
					FROM cdrs
					where dateCreated >= '{$this->start} 00:00:00'
						and dateCreated <= '{$this->end} 23:59:59'
						and dateCreated IS NOT NULL
						and billmin > 0
					limit ". ($page-1) * $qtd_page  .", $qtd_page";

		$query = $this->db->query($query);
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}

	public function countDate(){
		$valor = " SELECT count(1) as Total " .
					" FROM cdrs " .
					" where dateCreated >= '" . $this->start . " 00:00:00' " .
					" and dateCreated <= '" . $this->end . " 23:59:59' ";

		$query = $this->db->query($valor);
		$valorT = $query->fetchAll();

		return $valorT[0]["Total"];
	}
}
?>