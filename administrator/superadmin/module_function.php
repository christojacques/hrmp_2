<?php 

include_once 'db.php';


class Modules{
	public function __construct($db){
		$this->db=$db;
	}

	public function showmodule(){
		$sql="SELECT * FROM `modules`";
		$stml=$this->db->prepare($sql);
		$stml->execute();
		$result=$stml->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}
}

$module=new Modules($db);




 ?>