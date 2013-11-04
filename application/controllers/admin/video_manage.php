<?
	class Video_manage extends CI_Controller{

		function index(){
			$this->load->view('admin/videos');
		}

		public function get_list(){
			$this->load->library('datatables');
			$this->datatables->select("id, title, created_at");
			$this->datatables->from("Video");
			echo $this->datatables->generate();
		}

		public function detail($id, $update = false){
			$this->load->model('Video');
			$this->Video->id = $id;
			$data['detail'] = $this->Video->get_item();
			if($update){
				$data['update'] = true;
			}
			$this->load->view('admin/video_detail', $data);
		}

		public function save(){
			$post = $this->input->post(null, true);
			$this->load->model('Video');
			$this->Video->id = $post['id'];
			$this->Video->update($post);
			$this->detail($post['id'], true);
		}
	}
?>