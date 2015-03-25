<?php
require_once("medoo/medoo.php");

class CdrRepository{

	private $db = null;
	private $start;
	private $end;
	private $type;

	public function __construct($start, $end, $type){
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
		$this->type = $type;
	}
	public function process(){

		switch ($this->type) {
			case 'relatorioDiario':{
				$periodo = "date_format(dateCreated,'%d-%m-%Y')";
				break;
			}
			case 'relatorioAnual':{
				$periodo = "date_format(dateCreated,'%Y')";
				break;	
			}		
			default:{
				$periodo = "date_format(dateCreated,'%m-%Y')";
				break;
			}
		}

		$query = "SELECT " . $periodo . " as Periodo, account, type, peer, carrier, status, ROUND(sum(billmin),2), count(1)
					FROM cdrs
					where dateCreated >= '{$this->start} 00:00:00'
						and dateCreated <= '{$this->end} 23:59:59'
					group by account, Periodo, type, peer, carrier, status
					order by account, Periodo, peer,sum(billmin)";
		$query = $this->db->query($query);
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
}
?>