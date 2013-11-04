<?
	function get_question($blok){
		$ci =& get_instance();

		$ci->load->model('Question');

		$ci->Question->blok = $blok;
		$data['question'] = $ci->Question->get_question();

		
		$ci->load->model('QuestionOption');
		$data['question']['options'] = $ci->QuestionOption->get_list(null, null, array("question_id" => $data['question']['id']));

		return $data['question'];
	}
?>