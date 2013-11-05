<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('welcome');
		
	}

	public function loginback(){
		$user = $this->facebook->getUser();
		if ($user) {
            try {
                $userdata['me'] = $this->facebook
                    ->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }else{
        	echo "fail";
        }
	}

	public function user(){		
		$user = $this->facebook->getUser();
		if ($user) {
            try {
                $userdata['me'] = $this->facebook
                    ->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }else{
        	$params = array(
			  'scope' => 'user_likes,user_about_me,user_interests,user_education_history,user_work_history,email,user_birthday,user_hometown,user_location,user_relationships,user_relationship_details,user_website',
			  'redirect_uri' => 'https://bridgestonetasarimyarismasi.fb-applicationstore.net/ty/welcome/loginback/'
			);
        	header("location: " . $this->facebook->getLoginUrl($params));
        }
        $post = $this->input->post('userdata');
		
		$this->load->model('User');
		$this->User->first_name = $userdata['me']['first_name'];
		$this->User->last_name = $userdata['me']['last_name'];
		$this->User->full_name = $userdata['me']['first_name'] . " " . $userdata['me']['last_name'];
		$this->User->email = $userdata['me']['email'];
		$this->User->facebook_id = $userdata['me']['id'];
		$this->User->facebook_data = json_encode($userdata['me']);
		$this->User->access_token = $post['access_token'];
		$this->User->access_token_expire_date = $post['access_token_expire_date'];
		
		$user = $this->User->check();
		
		if($user == false){
			$this->User->create();	
		}
	}

	function upload(){
		sleep(3);
		$targetFolder = '/casecontest/uploads'; // Relative to the root

		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['file']['name'];
			//$targetFile = rtrim($targetPath,'/') . '/' . $this->input->post('model') . "-" . $this->input->post('onarka') . "-" . $this->input->post('renk') . ".jpg";
			
			// Validate the file type
			$fileTypes = array('jpg','jpeg', 'png', 'pdf', 'ai', 'psd', 'tif'); // File extensions
			$fileParts = pathinfo($_FILES['file']['name']);
			
			if (in_array($fileParts['extension'],$fileTypes)) {
				move_uploaded_file($tempFile,$targetFile);
				echo 1;
			} else {
				echo 0;
			}
		}

		//$_FILES['file']['name'];
	}

	function create(){
		$post = $this->input->post(null,true);
		print_r($post);
	}
}