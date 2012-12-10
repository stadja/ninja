<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class account extends CI_Controller {

	var $user;
	var $data;

	function __construct() {
		parent::__construct();
		$this->load->model('Users','',TRUE);
		$this->user = $this->Users->get($this->session->userdata('userId'));
		$this->data['user'] = $this->user;
	}


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		if (!$this->user) {
			$this->login();
			return false;
		} else {
			redirect('/');
		}
	}

	public function main() {
        if (!$this->user) {
            redirect('/');
            return false;
        } 

        $this->data['main_view'] = 'dashboard';
        $this->data['main_frame'] = 'account/main';

        $this->load->view('lunatum/template', $this->data);
	}

	/**
	 * Callback 
	 **/
	public function checkInvitation($email) {
		$this->form_validation->set_message('checkInvitation', "Le champ %s ne correspond pas à l'identifiant d'invitation.");
		return $this->user->email == $email;
	}

	public function respondToInvitation($invitation_id = '') {

		$this->data['invitation_id'] = $invitation_id;

		$query = $this->db->get_where('user_invitation', array('invitation' => $invitation_id));
		if($query->num_rows() < 1) {
			debug("Il n'y a pas (ou plus) d'invitation correspondante à cet identifiant.");
			die();
		}

		$this->user = $this->Users->get($query->row()->user);
		$this->data['user'] = $this->user;

		$this->form_validation->set_rules('email', "'Courriel'", 'trim|required|valid_email|callback_checkInvitation');
		$this->form_validation->set_rules('password', "'Mot de passe'", 'trim|required');
		$this->form_validation->set_rules('password_conf', "'Confirmation du mot de passe'", 'trim|required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			 $this->data['main_view'] = 'account/respondToInvitation';
			 $this->load->view('lunatum/template', $this->data);
			return false;
		}

		$password = $this->input->post('password');
		$this->user->setPassword($password);
		$this->user->confirm();

		$this->db->where('user', $this->user->id)->delete('user_invitation');

		$this->user->do_login($this->user->email, $password);

 		redirect('account/main');		
	}

    /**
     * Callback
     **/
    public function authentification($password) {

		$this->user = $this->Users->do_login($this->input->post('email'), $password);

		$this->form_validation->set_message('authentification', "Il n'y a pas de compte correspondant : Courriel ou Mot de Passe incorrect");
		return $this->user;

	}

	public function login () {
		$this->form_validation->set_rules('email', "'Courriel'", 'trim|required|valid_email');
		$this->form_validation->set_rules('password', "'Mot de passe'", 'trim|required|callback_authentification');

		if ($this->form_validation->run() == FALSE) {
			$this->data['main_view'] = 'account/login';
			$this->load->view('lunatum/template', $this->data);
			return false;
		}

		redirect('/');
	}
	
	public function disconnect () {
		$this->session->sess_destroy();
		redirect('/');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
