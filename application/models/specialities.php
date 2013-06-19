<?php
class Specialities extends CI_Model {

	function __construct($stdUser = '') {
		parent::__construct();
		if ($stdUser != '') {
			foreach ($stdUser as $key => $value) {
				$this->$key = $value;
			}
		} 

		return $this;
	}

	function getAll() {
		$query = $this->db->get('specialities');
		$collection = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $speciality) {
				$collection[] = new self($speciality);
			}
		}
		return $collection;
	}

	function getTool($id_specialities) {
		$this->load->model('tools');
		$query = $this->db->get_where('tools_specialities', array('id_specialities' => $id_specialities));
		$collection = array();
		if($query->num_rows() > 0) {
			foreach($query->result() as $tool) {
				$collection[] = $this->tools->get($tool->id_tools);
			}
		}
		return $collection;
	}


	
}
?>

