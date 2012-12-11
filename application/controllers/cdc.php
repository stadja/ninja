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

		$this->data['main_view'] = TEMPLATE_VERSION.'/dashboard';
		$this->data['main_frame'] = TEMPLATE_VERSION.'/cdc/addNews';
		$this->data['page_chosen'] = 'board';
		$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
		return false;

	}

	public function writeNews($id) {
		$this->load->library('grocery_CRUD');		
		$crud = new grocery_CRUD();
		$crud->set_table('news');
		$crud->set_subject('Article');
    	$crud->where('idflux',$id);
    	$crud->unset_columns('flux');
		$crud->set_relation('author','users','email');

     	$crud->change_field_type('created','invisible');
		$crud->change_field_type('updated','invisible');
		$crud->change_field_type('idflux','invisible');
		$crud->change_field_type('author','invisible');
    	$crud->callback_before_insert(array($this,'_before_insert'));
   	 	$crud->unset_edit_fields('created');
    	$crud->callback_before_update(array($this,'_before_update'));

		$output = $crud->render();
		$this->data['crud']      = $output;
		$this->data['main_view'] = TEMPLATE_VERSION.'/fragments/showCrud';
		$this->load->view(TEMPLATE_VERSION.'/template', $this->data);
		return false;

	}

	function _before_insert($post_array) {
		$now = date('Y-m-d H:i:s');
		$post_array['created'] = $now;
		$post_array['updated'] = $now;
		$post_array['idflux'] = $this->uri->segment(3);
		$post_array['author'] = $this->user->getId();
		return $post_array;	
	}  
	 
	function _before_update($post_array) {
		$post_array['updated'] = date('Y-m-d H:i:s');
		return $post_array;	
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
