<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cdc extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Users','',TRUE);
		$this->load->model('Flux','',TRUE);

		$this->user = $this->Users->get($this->session->userdata('userId'));
		$this->data['user'] = $this->user;

		if (!$this->user || !$this->user->hasRights('cdc')) {
			redirect('/');
			return false;
		}

	}

	public function index()
	{
		$this->addNews();
	}

	public function addNews() {	

		$this->data['main_view'] = 'dashboard';
		$this->data['main_frame'] = 'cdc/addNews';
		$this->load->view('template', $this->data);
		return false;

 		redirect('cdc/addNews');
	}

	public function getNews($flux_id) {

		$news = $this->Flux->get($flux_id)->getAllNews();

		$return_object->Result = 'OK';
		$return_object->Records = $news;

		if (!$news) {
			$return_object->Result = 'ERROR';
			$return_object->Message = 'La liste des News est vide pour le flux "'.$flux_id.'" ! Vite, écrivez un nouveau message ;)';
		}

		echo json_encode($return_object);
		die();
	}

	public function createNews($flux_id) {

		$news = $this->Flux->get($flux_id)->addNews($this->input->post('title'), $this->input->post('small_description'), $this->input->post('text'), $this->user);

		$return_object->Result = 'OK';
		$return_object->Record = $news;

		if (!$news) {
			$return_object->Result = 'ERROR';
			$return_object->Message = 'La liste des News est vide pour le flux "'.$flux_id.'" ! Vite, écrivez un nouveau message ;)';
		}

		echo json_encode($return_object);
		die();
	}

	public function updateNews($flux_id) {
		$news = $this->Flux->updateNews($this->input->post('id'), $this->input->post('title'), $this->input->post('small_description'), $this->input->post('text'));

		$return_object->Result = 'OK';
		$return_object->Record = $news;

		if (!$news) {
			$return_object->Result = 'ERROR';
			$return_object->Message = 'La liste des News est vide pour le flux "'.$flux_id.'" ! Vite, écrivez un nouveau message ;)';
		}

		echo json_encode($return_object);
		die();
	}

	public function deleteNews($flux_id) {
		$news = $this->Flux->deleteNews($this->input->post('id'));

		$return_object->Result = 'OK';

		echo json_encode($return_object);
		die();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
