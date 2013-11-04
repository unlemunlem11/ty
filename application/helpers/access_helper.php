<?

	function loginCheck($return = false){
		$ci =& get_instance();
		if($ci->session->userdata("id") > 0){
			if($return){
				return true;
			}
		}else{
			if($return){
				return false;
			}else{
				redirect(base_url() . "welcome");
				return false;
				exit();
			}
		}
	}

	function segment_check(){
		$ci =& get_instance();
		if($ci->session->userdata("segment") > 2){
			return false;
		}else{
			return true;
		}
	}
?>