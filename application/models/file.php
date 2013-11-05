<?
	class File extends CI_Model{

		public function create(){
			$this->created_at = date("Y-m-d H:i:s");
			$this->ip_address = $this->input->ip_address();
			$this->db->insert("File", $this);
			return $this->db->insert_id();
		}
	}
?>