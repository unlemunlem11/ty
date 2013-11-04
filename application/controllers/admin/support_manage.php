<?
class Support_manage extends CI_Controller{
	

	public function index(){
		$this->load->view('admin/support');
	}	

	public function get_tickets(){
		$this->load->library("datatables");
		$this->datatables->select("id, subject, (select concat(first_name, ' ', last_name) as user_name from User where User.id = user_id), created_at, status", false);
		$this->datatables->from("Ticket");
		echo $this->datatables->generate();
	}

	public function get_messages($ticket_id){
		$this->load->model('Ticket');
		$this->Ticket->id = $ticket_id;
		$data['messages'][0] = $this->Ticket->get_item();
		$data['messages'][0]['sender'] = "user";

		$this->load->model('TicketAnswer');
		$this->TicketAnswer->ticket_id = $ticket_id;
		$answers = $this->TicketAnswer->get_items();
		if(count(@$answers) > 0){
			foreach ($answers as $answer) {
				$data['messages'][] = $answer;

			}
		}

		echo json_encode($data['messages']);
	}

	public function reply(){
		$this->load->model('TicketAnswer');
		$this->TicketAnswer->ticket_id = $this->input->post('ticket_id');
		$this->TicketAnswer->message = $this->input->post('message');
		$this->TicketAnswer->sender = "admin";
		$this->TicketAnswer->admin_id = 1;
		$ticketanswer_id = $this->TicketAnswer->create();
		
		$this->load->model('Ticket');
		$this->Ticket->id = $this->TicketAnswer->ticket_id;
		$this->Ticket->update(array('status' => "1"));
		echo $ticketanswer_id;
	}

	public function get_sss(){
		$this->load->library("datatables");
		$this->datatables->select("id, title, text");
		$this->datatables->from("Faq");
		echo $this->datatables->generate();
	}

	public function get_faq(){
		$this->load->model('Faq');
		$this->Faq->id = $this->input->post('id');
		echo json_encode($this->Faq->get_item());
	}

	public function save_faq(){
		$post = $this->input->post(null,true);
		$this->load->model('Faq');
		$this->Faq->id = $post['id'];
		echo $this->Faq->update($post);
	}

	public function new_faq(){
		$post = $this->input->post(null,true);
		$this->load->model('Faq');
		$this->Faq->title = $post['title'];
		$this->Faq->text = $post['text'];
		echo $this->Faq->create();
	}

	public function faq_delete(){
		$this->load->model('Faq');
		$this->Faq->id = $this->input->post('id');
		echo $this->Faq->remove();
	}
}

?>