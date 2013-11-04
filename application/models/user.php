<?php

	Class User Extends CI_MODEL {

		public $id;
		public $first_name;
		public $last_name;
		public $full_name;
		public $email;
		public $phone;
		public $address;
		public $created_at;
		public $facebook_id;
		public $access_token;
		public $facebook_data;

		public function create(){
			$this->created_at = date('Y-m-d H:i:s');
			$this->db->insert('User', $this);
			return $this->db->insert_id();
		}

		public function check(){
			$this->db->where("facebook_id", $this->facebook_id);
			$sql = $this->db->get("User")->result_array();
			if(@$sql[0]['id'] != ""){
				return $sql[0];
			}else{
				return false;
			}
		}

		public function update($update){
			$this->db->where("facebook_id", $this->facebook_id);
			$this->db->update("User", $update);
			return $this->db->affected_rows();
		}

		public function get_id(){
			$this->db->where("facebook_id", $this->facebook_id);
			$sql = $this->db->get("User")->result_array();
			if(@$sql[0]['id'] != ""){
				return $sql[0]['id'];
			}else{
				return false;
			}
		}

		public function get_email(){
			$this->db->where("facebook_id", $this->facebook_id);
			$sql = $this->db->get("User")->result_array();
			if(@$sql[0]['id'] != ""){
				return $sql[0]['email'];
			}else{
				return false;
			}
		}

	}

?>