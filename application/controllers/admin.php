<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		
		$this->load->library('grocery_CRUD');	

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
			$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
			$this->data['main_frame'] = TEMPLATE_VERSION.'/admin/changeFluxRights';
			$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
			return false;
		}
	}

	public function addFlux() {
		$crud = new grocery_CRUD();
		$crud->set_table('flux');
        $crud->set_subject('Flux');
        $crud->set_relation_n_n('cdcs', 'flux_cdc', 'users', 'idflux', 'iduser', 'email');
   	 	
   	 	$crud->unset_add_fields('rss');
     	$crud->change_field_type('created','invisible');
		$crud->change_field_type('updated','invisible');

		$crud->callback_column('rss',array($this,'_link_view'));

    	$crud->callback_before_insert(array($this,'_before_insert'));

   	 	$crud->unset_edit_fields('created');
    	$crud->callback_before_update(array($this,'_before_update'));

    	$crud->callback_after_insert(array($this,'_after_insert_flux'));

		$output = $crud->render();

		$this->data['main_view']  = TEMPLATE_VERSION.'/dashboard';
		$this->data['main_frame'] = TEMPLATE_VERSION.'/fragments/showCrud';
		$this->data['crud']       = $output;
		$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
		return false;
	}
	
	public function tools() {
		$crud = new grocery_CRUD();
		$crud->set_table('tools');
        $crud->set_subject('Outil');

     	$crud->change_field_type('created','invisible');
		$crud->change_field_type('updated','invisible');
    	$crud->callback_before_insert(array($this,'_before_insert'));
   	 	$crud->unset_edit_fields('created');
    	$crud->callback_before_update(array($this,'_before_update'));

   	 	$crud->unset_add_fields('serialization');

		$crud->add_action("Modifier le corps de l'outil"
			, ''
			, 'admin/edit_scales'
			, 'edit-inside-icon');

		$crud->add_action("Voir l'outil"
			, ''
			, 'reader/scales'
			, 'play-icon');
 
        $output = $crud->render();
		
		$this->data['main_view']  = TEMPLATE_VERSION.'/dashboard';
		$this->data['main_frame'] = TEMPLATE_VERSION.'/fragments/showCrud';
		$this->data['crud']       = $output;
		$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
		return false;
	}

	function _link_view($value, $row) {
		return "<a target='_blank' href='".$value."'>$value</a>";
	}

	function _before_insert($post_array) {
		$now = date('Y-m-d H:i:s');
		$post_array['created'] = $now;
		$post_array['updated'] = $now;
		return $post_array;	
	}  
	 
	function _before_update($post_array) {
		$post_array['updated'] = date('Y-m-d H:i:s');
		return $post_array;	
	}  

	function _after_insert_flux($post_array,$primary_key) {
		$data = array('rss' => 'http://stadja.net:8080/rss/'.$primary_key.'.xml');
		return $this->db->update('flux', $data, array('idflux' => $primary_key)); 
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
			$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
			$this->data['main_frame'] = TEMPLATE_VERSION.'/admin/invit';
			$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
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
		$user_invitation = array('user' => $user->getid(),
						'invitation' => $invitation_id);
		$this->db->insert('user_invitation', $user_invitation);

		$this->Mail->send_invitation($user, $invitation_id);

		$this->session->set_flashdata("invitation_sent", "L&#039;utilisateur ".$user->firstname.' '.$user->name.' a &eacute;t&eacute; invit&eacute; par un courriel envoy&eacute; &agrave; '.$user->email);

	}

	function edit_scales($id = 1) {
			$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
			$this->data['main_frame'] = TEMPLATE_VERSION.'/admin/editScales';
			
			$this->load->model('Tools','',TRUE);
			$this->data['scale'] = $this->Tools->get($id);
			$this->data['toolId'] = $id;
			$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
	}

	function edit_calcs($id = 1) {
			$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
			$this->data['main_frame'] = TEMPLATE_VERSION.'/admin/editCalcs';
			
			$this->load->model('Tools','',TRUE);
			$this->data['scale'] = $this->Tools->get($id);
			$this->data['toolId'] = $id;
			$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
	}

	function save_scale() {
			$id = $this->input->post('id');
			$serialization = $this->input->post('serialization');

			$this->load->model('Tools');
			$scale = $this->Tools->addOrUpdateScale($id, $serialization);

			return $scale;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
