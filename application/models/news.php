<?php
class News extends CI_Model {

	function __construct($stdUser = '') {
		parent::__construct();
		if ($stdUser != '') {
			foreach ($stdUser as $key => $value) {
				$this->$key = $value;
			}
		} 

		return $this;
	}

	function getTitle() {
		if (!isset($this->title)) {
			return false;
		}
		return $this->title;
	}

	function getText() {
		if (!isset($this->text)) {
			return false;
		}
		return $this->text;
	}

	function getId() {
		if(!isset($this->idnews)) {
			return false;
		}
		return $this->idflux;
	}

	function getFlux() {
		if(!isset($this->flux)) {
			if(!isset($this->idflux)) {
				return false;
			}
			$this->load->model('Flux','',TRUE);
			$this->flux = $this->Flux->get($this->idflux);
		}
		return $this->flux;
	}

	function getAuthor() {
		if(!isset($this->author_user) || !$this->author_user) {
			$this->load->model('Users','',TRUE);
			if(!isset($this->author)) {
				return new Users();
			}
			$this->author_user = $this->Users->get($this->author);
			if (!$this->author_user) {
				return new Users();
			}
		}
		return $this->author_user;
	}

	function getLastlyUpdated($format = '%A, %e %B %G') {
		if(!isset($this->updated)) {
			return false;
		}
		$date = strtotime($this->updated);
		return strftime($format, $date);
	}

	function get($id = '') {
		$query = $this->db->get_where('news', array('idnews' => $id));
		if($query->num_rows() > 0) {
			return new self($query->row());
		}
		return false;
	}


	
}
?>

