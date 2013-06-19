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
		$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
		$this->data['main_frame'] = TEMPLATE_VERSION.'/reader/index';
		$this->data['page_chosen'] = 'board';
		$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
	}

	function news($id = 31) {

		$this->load->model('News','',TRUE);
		$news = $this->News->get($id);

		$this->data['news'] = $news;

		// debug($news->getAuthor());
		// debug($news->getAuthor()->getPatronyme());

		$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
		$this->data['main_frame'] = TEMPLATE_VERSION.'/reader/news';
		$this->data['page_chosen'] = 'board';
		$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
	}

	function setup() {

		$this->load->model('Flux','',TRUE);
		$this->data['flux_collection'] = $this->Flux->getFullCollection();

		if (!$this->input->post('flux_setup')) {
			$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
			$this->data['main_frame'] = TEMPLATE_VERSION.'/reader/setup';
			$this->data['page_chosen'] = 'board';
			$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
			return false;
		}

		$this->user->resetFluxSubscription();
		foreach ($this->input->post('flux') as $flux_id) {
			$this->user->subscribeToFlux($flux_id);
		}

		redirect('reader/setup');
	}

	function tool($id) {
		$this->load->model('Tools','',TRUE);
		$tool = $this->Tools->get($id);

		if ($tool->type == 'calc') {
			redirect('/reader/calc/'.$id);
		} else {
			redirect('/reader/scale/'.$id);
		}
	}

	function scale($id) {
			$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
			$this->data['main_frame'] = TEMPLATE_VERSION.'/reader/scales';
			
			$this->load->model('Tools','',TRUE);
			$this->data['scale'] = $this->Tools->get($id);
			
			$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
	}

	function calc($id) {
			$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
			$this->data['main_frame'] = TEMPLATE_VERSION.'/reader/calcs';
			
			$this->load->model('Tools','',TRUE);
			$this->data['tool'] = $this->Tools->get($id);
			
			$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
	}

	function json_get_specialities() {
		$this->load->model('Specialities','',TRUE);
		$collection = $this->Specialities->getAll();
		echo json_encode($collection);
		die();
	}

	function json_get_tool_by_specialities($id_specialities = false) {
		if (!$id_specialities) {
			$this->load->model('Tools','',TRUE);
			$collection = $this->Tools->getAll('id, title');
			echo json_encode($collection);
		} else {
			$this->load->model('Specialities','',TRUE);
			$collection = $this->Specialities->getTool($id_specialities);
			echo json_encode($collection);
		}
		die();
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
