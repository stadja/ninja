<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reader extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Users','',TRUE);

		$this->user = $this->Users->get($this->session->userdata('userId'));
		$this->data['user'] = $this->user;

		if (!$this->user || !$this->user->hasRights('reader')) {
			redirect('/account');
			return false;
		}
	}

	function index() {
		$this->data['main_view'] = 'dashboard';
		$this->data['main_frame'] = 'reader/index';
		$this->data['page_chosen'] = 'board';
		$this->load->view('template', $this->data);
	}

	function news($id = 31) {

		$this->load->model('News','',TRUE);
		$news = $this->News->get($id);

		$this->data['news'] = $news;

		// debug($news->getAuthor());
		// debug($news->getAuthor()->getPatronyme());

		$this->data['main_view'] = 'dashboard';
		$this->data['main_frame'] = 'reader/news';
		$this->data['page_chosen'] = 'board';
		$this->load->view('template', $this->data);
	}

	function setup() {

		$this->load->model('Flux','',TRUE);
		$this->data['flux_collection'] = $this->Flux->getFullCollection();

		if (!$this->input->post('flux_setup')) {
			$this->data['main_view'] = 'dashboard';
			$this->data['main_frame'] = 'reader/setup';
			$this->data['page_chosen'] = 'board';
			$this->load->view('template', $this->data);
			return false;
		}

		$this->user->resetFluxSubscription();
		foreach ($this->input->post('flux') as $flux_id) {
			$this->user->subscribeToFlux($flux_id);
		}

		redirect('reader/setup');
	}

	function scales($id = 1) {
			$this->data['main_view'] = 'dashboard';
			$this->data['main_frame'] = 'reader/scales';
			
			$this->load->model('Tools','',TRUE);
			$this->data['scale'] = $this->Tools->get($id);
			
			$this->load->view('template', $this->data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
