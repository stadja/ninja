<?php
class Users extends CI_Model {

	var $is_confirmed = 0;

	function __construct($stdUser = '') {
		parent::__construct();
		if ($stdUser != '') {
			foreach($stdUser as $key => $value) {
				$this->$key          = $value;
			}
		} 
	}

	function get($id = '') {
		$query = $this->db->get_where('users', array('id' => $id));
		if($query->num_rows() > 0) {
			return new self($query->row());
		}
		return false;
	}

	function add($email, $firstname = '', $name = '') {
		$data = array(
			'email'     => $email,
			'firstname' => $firstname,
			'name'      => $name
		);

		$this->db->insert('users', $data); 

		$this->email     = $email;
		$this->firstname = $firstname;
		$this->name      = $name;
		$this->id        = $this->db->insert_id();

		return $this;
	}

	function findByEmail($email) {
		$query = $this->db->get_where('users', array('email' => $email));
		if($query->num_rows() > 0) {
			return new self($query->row());
		}
		return false;
	}


	function getByPermission($permission) {
		$query = $this->db->get_where('permissions', array('name' => $permission));
		$permission_value = $query->row()->value;
		$collection = '';
		$query = $this->db->select("users.*")->from('user_permissions')->like('permissions', '"'.$permission_value.'"')->join('users', 'users.id = user_permissions.user')->get();		
		foreach ($query->result() as $user) {
			$id = $user->id;
			$collection->$id = new self($user);
		}
		return $collection;
		
	}

	function setPermissions($permissions = array()) {	
		$data = array(
			'user' => $this->getId()
		);

		$query = $this->db->get_where('user_permissions', $data);
		$data['permissions'] = json_encode($permissions);

		if($query->num_rows() > 0) {
			$this->db->update('user_permissions', $data, array('user' =>$this->getId()));
		} else {
			$this->db->insert('user_permissions', $data);
		}
		
	}

	function setPassword($password) {	
		$this->load->library('encrypt');
		$password = $this->encrypt->sha1($password);
		return $this->db->update('users', array('password' => $password), array('id' => $this->getId()));	
	}	

	function confirm($confirm = true) {
		return $this->db->update('users', array('is_confirmed' => $confirm), array('id' => $this->getId()));
	}

	function do_login($email, $password) {
		$this->load->library('encrypt');
		$password = $this->encrypt->sha1($password);
		$query = $this->db->get_where('users',array('email' => $email, 'password' => $password));

		if($query->num_rows() > 0) {
			$user =  new self($query->row());
		} else {
			$user = false;
		}

		$this->session->set_userdata('user', $user);
		$this->session->set_userdata('userId', $user->id);

	return $user;
	}
	
	function hasRights($rightsId) {
		$query = $this->db->get_where('permissions', array('name' => $rightsId));
		if($query->num_rows() < 1) {
			return false;
		}

		$rightsValue = $query->row()->value;

		$query = $this->db->get_where('user_permissions', array('user' => $this->getId()));
		if($query->num_rows() < 1) {
			return false;
		}
		$userRights = json_decode($query->row()->permissions);
		return in_array($rightsValue, $userRights);
	}

	function getCDCFlux () {
		if (!isset($this->fluxCollection)) {
			$this->load->model('flux');

			$query = $this->db->select("flux.*")->from('flux_cdc')->where('cdc', $this->getId())->join('flux', 'flux_cdc.flux = flux.id')->get();		
			$fluxCollection = $query->result();
			$this->fluxCollection = array();
			foreach ($fluxCollection as $flux) {
				$this->fluxCollection[] = new Flux($flux);
			}
		}
		return $this->fluxCollection;
	}

	function hasSuscribedToFlux ($flux_id) {
		$result = $this->db->get_where('`user_subscription', array('user' => $this->getId(), 'flux' => $flux_id))->row();
		return (sizeof($result) > 0);
	}

	function resetFluxSubscription() {
		$this->db->delete('user_subscription', array('user' => $this->getId())); 
	}

	function subscribeToFlux ($flux_id) {
		$data = array(
		   'user' => $this->getId(),
		   'flux' => $flux_id
		);

		$this->db->insert('user_subscription', $data); 
	}

	function getSubscribedFlux() {
		$this->load->model('Flux','',TRUE);
		if (!isset($this->subscribedFlux)) {
			$this->subscribedFlux = array();
			$flux_collection = $this->db->get_where('`user_subscription', array('user' => $this->getId()))->result();
			$result = array();

			foreach ($flux_collection as $flux_subscription) {
				$this->subscribedFlux[] = new Flux(array('id' => $flux_subscription->flux));
			}
		}
		return $this->subscribedFlux;
	}

	function getEmail() {
		return $this->email;
	}

	function getId() {
		return (isset($this->id)) ? $this->id : 0;
	}
}
?>

