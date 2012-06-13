<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {

	function __construct() {
		parent::__construct();

		set_js_path('admin');

		$this->load->model('Users','',TRUE);
		$this->load->model('Flux','',TRUE);

		$this->user = $this->Users->get($this->session->userdata('userId'));
		$this->data['user'] = $this->user;

		if (!$this->user || !$this->user->hasRights('admin')) {
			redirect('/');
			return false;
		}

	}

	public function index()
	{
		$this->invit();
	}

	public function changeFluxRights() {
		$this->data['users_cdc'] = $this->Users->getByPermission('cdc');
		$this->data['flux_collection'] = $this->Flux->getFullCollection();

		if ($this->form_validation->run() == FALSE)
		{
			$this->data['main_view'] = 'dashboard';
			$this->data['main_frame'] = 'admin/changeFluxRights';
			$this->load->view('template', $this->data);
			return false;
		}
	}

	public function addFlux() {	

		$this->form_validation->set_rules('title', "'Titre'", 'trim|required');
		$this->form_validation->set_rules('id', "'id'", 'trim|required');
		$this->form_validation->set_rules('description', "'description'", 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->data['main_view'] = 'dashboard';
			$this->data['main_frame'] = 'admin/addFlux';
			$this->load->view('template', $this->data);
			return false;
		}

		$id = $this->input->post('id');
		$title = $this->input->post('title');
		$description = $this->input->post('description');

		$flux = $this->Flux->get($id);
		if (!$flux) {
			$flux = $this->Flux->add($id, $title, $description);
		}

		$this->session->set_flashdata("alert", "Le flux '".$title."' a été crée.");
 		redirect('admin/addFlux');

	}

	public function invit()
	{	
		$this->form_validation->set_rules('firstname', "'Prénom'", 'trim');
		$this->form_validation->set_rules('name', "'Nom'", 'trim');
		// $this->form_validation->set_rules('email', "'Courriel'", 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('email', "'Courriel'", 'trim|required|valid_email');
		$this->form_validation->set_rules('rights[]', "'Droits'", 'trim|required');

		$this->data['rights'] = $this->db->order_by('value asc')->get('permissions')->result();

		if ($this->form_validation->run() == FALSE)
		{
			$this->data['main_view'] = 'dashboard';
			$this->data['main_frame'] = 'admin/invit';
			$this->load->view('template', $this->data);
			return false;
		}

		$email = $this->input->post('email');
		$firstname = $this->input->post('firstname');
		$name = $this->input->post('name');

		$user = $this->Users->findByEmail($email);
		if (!$user) {
			$user = $this->Users->add($email, $firstname, $name);
		}

		$rights = $this->input->post('rights');
		$user->setPermissions($rights);

		$this->officialyInvit($user);

 		redirect('admin/invit');

	}

	private function officialyInvit($user) {

		$this->load->model('Mail','',TRUE);
		$this->load->helper('string');

		$invitation_id = random_string('unique');
		$user_invitation = array('user' => $user->id,
						'invitation' => $invitation_id);
		$this->db->insert('user_invitation', $user_invitation);

		$this->Mail->send_invitation($user, $invitation_id);

		$this->session->set_flashdata("invitation_sent", "L&#039;utilisateur ".$user->firstname.' '.$user->name.' a &eacute;t&eacute; invit&eacute; par un courriel envoy&eacute; &agrave; '.$user->email);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
