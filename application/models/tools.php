<?php
class Tools extends CI_Model {

	function __construct($stdUser = '') {
		parent::__construct();
		if ($stdUser != '') {
			foreach ($stdUser as $key => $value) {
				$this->$key = $value;
			}
		} 

		return $this;
	}

	function get($id = '') {
		$query = $this->db->get_where('tools', array('id' => $id));
		if($query->num_rows() > 0) {
			return new self($query->row());
		}
		return false;
	}

	function addOrUpdateScale($id, $serialization = '') {
		$temp = $this->get($id);

		$now = date ("Y-m-d H:i:s");
		$data = array(
			'serialization' => $serialization,
			'type'          => 'scale',
			'updated'       => $now,
		);

		$this->serialization = $serialization;
		$this->type          = 'scale';
		$this->updated       = $now;

		if ($temp) {
			$this->db->update('tools', $data, array('id' => $id)); 
			return $this;
		}

		$data['id']      = $id;
		$data['created'] = $now;

		$this->db->insert('tools', $data); 

		$this->id      = $id;
		$this->created = $now;

		return $this;
	}

}
?>

