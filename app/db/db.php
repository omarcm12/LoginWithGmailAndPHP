<?php 
	
	class DB{
		private $conn;		
		public function __construct(){
			$this->conn = new mysqli('localhost', 'root', '', 'tutorialgoogle');

		}

		public function get_connection(){
			return $this->conn;
		}
	}


 ?>