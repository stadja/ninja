<?php
class Flux extends CI_Model {

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
			$query = $this->db->get_where('flux', array('id' => $this->getId()));
			if($query->num_rows() > 0) {
				foreach ($query->row() as $key => $value) {
					$this->$key = $value;
				}
			}
		}
		return $this->title;
	}

	function getId() {
		return $this->id;
	}

	function getFullCollection() {
		$query = $this->db->get('flux');

		 if($query->num_rows() > 0) {
 			$collection = '';
			foreach($query->result() as $flux) {
				$id = $flux->id;
				$collection->$id = new self($flux);
			}
			return $collection;
		 }
		return false;
	}

	function get($id = '') {
		$query = $this->db->get_where('flux', array('id' => $id));
		if($query->num_rows() > 0) {
			return new self($query->row());
		}
		return false;
	}

	function add($id, $title = '', $description = '') {
		$now = date ("Y-m-d H:i:s");
		$data = array(
			'id'     => $id,
			'title' => $title,
			'description'      => $description,
			'created'      => $now,
			'updated'      => $now,
			'rss' => 'http://stadja.net:8080/rss/'.$id.'.xml'
		);

		$this->db->insert('flux', $data); 

		$this->id     = $id;
		$this->title = $title;
		$this->description      = $description;
		$this->updated      = $now;

		$this->load->model('Users');
		$this->addNews('Message de Test pour le flux '.$title, 'Description pour le premier message', 'Premier Text', new Users());

		return $this;
	}

	function getAllNews() {
		$query = $this->db->get_where('news', array('flux' => $this->id));
		if($query->num_rows() > 0) {
			return $query->result();
		}
		return false;
	}

	function addNews($title, $small_description, $text, $user) {

		$data = array(
			'title'             => $title ,
			'small_description' => $small_description ,
			'text'              => $text,
			'author'            => $user->getId(),
			'created'           => date('Y-m-d H:i:s'),
			'updated'           => date('Y-m-d H:i:s'),
			'flux'              => $this->id
		);
		$this->db->insert('news', $data); 
		return $data;
	}

	function updateNews($id, $title, $small_description, $text) {

		$data = array(
			'id'				=> $id,
			'title'             => $title ,
			'small_description' => $small_description ,
			'text'              => $text,
			'updated'           => date('Y-m-d H:i:s'),
		);
		$this->db->update('news', $data, array('id' => $id)); 
		return $this->db->get_where('news', array('id' => $id))->row();
	}

	function isAuthoredBy($user) {

		if (!isset($this->cdcs)) {
			$this->cdcs = false;
			$flux_cdcs = $this->db->get_where('flux_cdc', array('flux' => $this->id))->result();
			
			foreach ($flux_cdcs as $flux_cdc) {
				$id_cdc = $flux_cdc->cdc;
				$this->cdcs->$id_cdc = true;
			}
		}

		$cdc_id = $user->getId();
		return isset($this->cdcs->$cdc_id);
	}

	function deleteNews($id) {
		return $this->db->delete('news', array('id' => $id)); 
	}
}
?>

