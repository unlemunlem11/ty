<?

		
	function ticket_status($key){
		$array = array(
				"0" => "Cevap Bekliyor",
				"1" => "Cevaplandı"
			);
		return $array[$key];
	}

	function model($key){
		$array = array(
			'1' => "blog", 
			'2' => "video",
			'3' => "product",
			'4' => "quiz",
			'5' => "login"
			);
		return $array[$key];
	}

	function segment($key){
		$array = array(
			'1' => "Gold", 
			'2' => "Premium",
			'3' => "Register"
			);
		return $array[$key];
	}
?>