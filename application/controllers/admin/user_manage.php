<?
	class User_manage extends CI_Controller{

		function index(){
			$this->load->view('admin/users');
		}

		function get_users($seller_id = false){
			$this->load->library("datatables");
			$this->datatables->select("id, (select name from Seller where Seller.id = seller_id limit 1) as firma, title, first_name, last_name, phone, email, title, created_at", false);
			$this->datatables->from("User");
			if($seller_id){
				$this->datatables->where("seller_id", intval($seller_id));
			}
			echo $this->datatables->generate();
		}

		function detail($user_id){
			$this->load->model('User');
			$this->User->id = $user_id;
			$data['detail'] = $this->User->get_item();
			$this->load->view('admin/user_detail', $data);
		}

		function save_info(){
			$post = $this->input->post(null,true);
			$this->load->model('User');
			$this->User->id = $this->input->post('id');
			$this->User->update($post);
			$this->detail($this->input->post('id'));
		}
	}
?>