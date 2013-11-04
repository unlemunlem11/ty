<?
	class Seller_manage extends CI_Controller{

		function index(){
			$this->load->view('admin/sellers');
		}

		function get_sellers(){
			$this->load->library("datatables");
			$this->datatables->select("id, name, tax_number, phone, email, lpn, segment, created_at", false);
			$this->datatables->from("Seller");
			echo $this->datatables->generate();
		}

		function detail($id){
			$this->load->model('Seller');
			$this->Seller->id = $id;
			$data['detail'] = $this->Seller->get_item();
			$this->load->view('admin/seller_detail', $data);
		}

		function save_info(){
			$post = $this->input->post(null,true);
			$this->load->model('Seller');
			$this->Seller->id = $this->input->post('id');
			$this->Seller->update($post);
			$this->detail($this->input->post('id'));
		}
	}
?>