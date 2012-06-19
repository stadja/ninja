<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reader extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Users','',TRUE);
		$this->load->model('Flux','',TRUE);

		$this->user = $this->Users->get($this->session->userdata('userId'));
		$this->data['user'] = $this->user;

		if (!$this->user || !$this->user->hasRights('reader')) {
			redirect('/');
			return false;
		}
	}

	function index() {
		$this->data['main_view'] = 'dashboard';
		$this->data['main_frame'] = 'reader/index';
		$this->load->view('template', $this->data);
	}

	function setup() {
		$this->data['flux_collection'] = $this->Flux->getFullCollection();

		if (!$this->input->post('flux_setup')) {
			$this->data['main_view'] = 'dashboard';
			$this->data['main_frame'] = 'reader/setup';
			$this->load->view('template', $this->data);
			return false;
		}

		$this->user->resetFluxSubscription();
		foreach ($this->input->post('flux') as $flux_id) {
			$this->user->subscribeToFlux($flux_id);
		}

		redirect('reader/setup');
	}

	function scales() {
			$this->data['main_view'] = 'dashboard';
			$this->data['main_frame'] = 'reader/scales';
			$this->load->view('template', $this->data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
