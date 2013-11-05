<?php 
	class Contact extends CI_Model{

		public function create(){
			$this->created_at = date("Y-m-d H:i:s");
			$this->ip_addres = $this->input->ip_address();
			$this->db->insert("Contact", $this);
			return $this->db->insert_id();
		}
	}

?>