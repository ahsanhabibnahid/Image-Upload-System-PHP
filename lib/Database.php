<?php
		/**Database Class**/

	class Database{
		public $host = 'localhost';
		public $user = "root";
		public $pass = "";
		public $dbname = "image_upload";
		public $link;
		public $error;

		/**Database Connection Constructor**/

		public function __construct(){
			$this->connection();
		}

		/**Database Connection**/

		public function connection(){
			$this->link = new mysqli($this->host,$this->user,$this->pass,$this->dbname);
			if (!$this->link) {
				$this->error = "Connection Failed".$this->link->connect_error;
			}
		}

		/**Insert Data**/

		public function insert($data){
			$insert_data = $this->link->query($data) or die($this->link->error.__LINE__);
			if ($insert_data) {
				return $insert_data;
			}
			else {
				return false;
			}
		}
			
		/**Select Data**/

		public function select($data){
			$select_data = $this->link->query($data) or die($this->link->error.__LINE__);
			if ($select_data->num_rows > 0) {
				return $select_data;
			}
			else {
				return false;
			}
		}

		/**Delete Data**/

		public function delete($data){
			$delete_data = $this->link->query($data) or die($this->link->error.__LINE__);
			if ($delete_data) {
				return $delete_data;
			}
			else {
				return false;
			}
		}

	}
?>