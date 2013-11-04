<?php
class Account extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	public function login(){
		$this->load->model('User');
		$this->User->set($this->input->post(null,true));
		$user = $this->User->validate();
		
		if($user != false){
			if($user['last_login'] == ""){
				$this->session->set_userdata("first_login", true);
			}
			$this->User->id = $this->session->userdata("id");
			$this->session->set_userdata("last_login", date("Y-m-d H:i:s"));
			$this->User->update(array("last_login" => date("Y-m-d H:i:s")));
			echo 1;
		}else{
			echo 0;
		}
		//echo json_encode(array("hede" => "hodo"));
		
	}

	/*
	public function register(){
		$post = $this->input->post(null, true);
		$this->load->model("User");
		$this->load->model("Seller");

		$this->Seller->name = $post['name'];
		$this->Seller->tax_number = $post['tax_number'];
		$this->Seller->address = $post['address'];
		$name = explode(" ", $post['user_name']);
		$this->User->first_name = $name[0];
		unset($name[0]);
		$last_name = implode(" ", $name);
		$this->User->last_name = $last_name;
		$this->User->title = $post['user_title'];
		$this->Seller->phone = $post['phone'];
		$this->User->phone = $post['phone'];
		$this->Seller->email = $post['email'];
		$this->User->email = $post['email'];
		$this->User->seller_id = $this->Seller->create();
		echo $this->User->create();
	}
	*/


	public function test(){
		$this->session->set_userdata("hede", "hodo");
	}	
	public function session(){
		print_r($this->session->all_userdata());
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function profile(){
		loginCheck();

		$data['question'] = get_question("anasayfa1");

		$this->load->model('QuizAnswer');
		$this->QuizAnswer->quiz_id = 1;
		$data["quiz"] = $this->QuizAnswer->check();
		
		$this->load->model('UserLog');
		$data['hp'] = $this->UserLog->get_total_point();
		$this->load->view("profile", $data);
	}

	public function update_profile(){
		loginCheck();
		$post = $this->input->post(null, true);
		$editable = array("name", "tax_number", "tax_office", "address", "phone", "first_name", "last_name", "title", "email");
		
		if(in_array($post['key'], $editable)){
			if($post['model'] == "user"){
				$this->load->model('User');
				$this->User->id = $this->session->userdata("id");
				$this->User->update(array($post['key'] => $post['val']));
				$this->session->set_userdata($post['key'], $post['val']);
			}
			if($post['model'] == "seller"){
				$this->load->model('Seller');
				$this->Seller->id = $this->session->userdata("seller_id");
				$this->Seller->update(array($post['key'] => $post['val']));
			}	
		}
		
		echo 1;
	}

	public function get_hareket_puanlari(){
		$this->load->library("datatables");
		$this->datatables->select("DATE_FORMAT(created_at, '%d-%m-%Y %h.%i') as create_date, model, point", false);
		$this->datatables->where("user_id", $this->session->userdata("id"));
		$this->datatables->from("UserLog");
		$a = $this->datatables->generate();
		
		$a = json_decode($a);

		if(count($a->aaData) > 0){
			for ($i=0; $i < count($a->aaData); $i++) { 
				$a->aaData[$i][1] = model($a->aaData[$i][1]);
			}
		}

		echo json_encode($a);
	}

	public function profil_turu(){
		if($this->session->userdata("profile_data") == ""){
			$this->load->view("profil_turu");	
		}
	}

	public function finish_tour(){
		loginCheck();
		$this->load->model('User');
		$this->User->id = $this->session->userdata("id");
		$this->User->update(array("profile_data" => json_encode($this->input->post('sorular'))));
		$this->session->set_userdata("profile_data", json_encode($this->input->post('sorular')));
	}

	public function renew(){
		loginCheck();
		$this->db->query("update User set profile_data = null, last_login = null where User.id = " . $this->session->userdata("id"));
		

	}

}
?>