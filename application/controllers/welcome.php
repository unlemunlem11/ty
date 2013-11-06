<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('welcome');
		
	}

	public function user_check(){
		$this->load->model('User');
		$this->User->facebook_id = $this->session->userdata("fid");
		$user = $this->User->check();
		if($user == false){
			echo 0;
		}else{
			echo $user['form'];
		}
	}

	public function user(){		
		$post = $this->input->post('userdata');
		$this->facebook->setAccessToken($post['access_token']);

		$user = $this->facebook->getUser();
		if ($user) {
            try {
                $userdata['me'] = $this->facebook
                    ->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }else{
        	echo "hata";
        	return false;
        	exit();
        }

        $this->session->set_userdata("access_token", $post['access_token']);
		$this->session->set_userdata("fid", $userdata['me']['id']);
		
		$this->load->model('User');
		$this->User->first_name = $userdata['me']['first_name'];
		$this->User->last_name = $userdata['me']['last_name'];
		$this->User->full_name = $userdata['me']['first_name'] . " " . $userdata['me']['last_name'];
		$this->User->email = $userdata['me']['email'];
		$this->User->facebook_id = $userdata['me']['id'];
		$this->User->facebook_data = json_encode($userdata['me']);
		$this->User->access_token = $post['access_token'];
		$this->User->access_token_expire_date = $post['access_token_expire_date'];
		$this->User->form = 0;

		$user = $this->User->check();
		
		if($user == false){
			$this->User->create();	
		}
	}

	function upload(){
		//$targetFolder = '/casecontest/uploads'; // Relative to the root
		$targetFolder = '/ty/uploads'; // Relative to the root
		log_message("error", "lets start ");
		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$filename = rand(1,9999999999) . $_FILES['file']['name'];
			$targetFile = rtrim($targetPath,'/') . '/' . $filename;
			//$targetFile = rtrim($targetPath,'/') . '/' . $this->input->post('model') . "-" . $this->input->post('onarka') . "-" . $this->input->post('renk') . ".jpg";
			
			// Validate the file type
			$fileTypes = array('jpg','jpeg', 'png', 'pdf', 'ai', 'psd', 'tif'); // File extensions
			$fileParts = pathinfo($_FILES['file']['name']);
			log_message("error", "if -> ");
			if (in_array($fileParts['extension'],$fileTypes)) {
				log_message("error", "if true");
				move_uploaded_file($tempFile,$targetFile);
				log_message("error", "file moved");
				$this->load->model('User');
				$this->load->model('File');
				$this->User->facebook_id = $this->session->userdata("fid");
				$this->File->user_id = $this->User->get_id();
				$this->File->name = $filename;
				log_message("error", "facebook_id: " . $this->User->facebook_id);
				$this->File->create();
				log_message("error", "created");
				echo 1;
			} else {
				log_message("error", "if false");
				echo 0;
			}
		}
	}

	function create(){
		$post = $this->input->post(null,true);
		$update['form'] = 1;
		$update['first_name'] = $post['first_name'];
		$update['last_name'] = $post['last_name'];
		$update['email'] = $post['email'];
		$update['phone'] = $post['phone'];
		$update['university'] = $post['university'];

		$this->load->model('User');
		$this->User->facebook_id = $this->session->userdata("fid");
		echo $this->User->update($update);
	}

	function contact(){
		$post = $this->input->post(null,true);
		$this->load->model('Contact');
		$this->load->model('User');
		$this->User->facebook_id = $this->session->userdata("fid");
		$this->Contact->user_id = $this->User->get_id();
		$this->Contact->first_name = $post['first_name'];
		$this->Contact->last_name = $post['last_name'];
		$this->Contact->email = $post['email'];
		$this->Contact->message = $post['message'];
		echo $this->Contact->create();
	}

	function sekme(){
		$this->load->view('sekme');
	}
}
