<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		
		$this->load->library('grocery_CRUD');	
	}
	
	function _example_output($output = null)
	{
		$this->load->view('example.php',$output);	
	}
	
	function flux()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('flux');
        $crud->set_subject('Flux');
        $crud->set_relation_n_n('cdcs', 'flux_cdc', 'users', 'idflux', 'iduser', 'email');

   	 	//$crud->fields('title', 'description', 'created' ,  'updated' ,'rss', 'external', 'cdcs');
   	 	
   	 	$crud->unset_add_fields('rss');
     	$crud->change_field_type('created','invisible');
		$crud->change_field_type('updated','invisible');

		$crud->callback_column('rss',array($this,'_link_view'));

    	$crud->callback_before_insert(array($this,'_before_insert_flux'));

   	 	$crud->unset_edit_fields('created');
    	$crud->callback_before_update(array($this,'_before_update_flux'));

    	$crud->callback_after_insert(array($this,'_after_insert_flux'));

		$output = $crud->render();

		$this->_example_output($output);
	}
	
	function _link_view($value, $row) {
		return "<a target='_blank' href='".$value."'>$value</a>";
	}

	function _before_insert_flux($post_array) {
		$now = date('Y-m-d H:i:s');
		$post_array['created'] = $now;
		$post_array['updated'] = $now;
		return $post_array;	
	}  
	 
	function _before_update_flux($post_array) {
		$post_array['updated'] = date('Y-m-d H:i:s');
		return $post_array;	
	}  

	function _after_insert_flux($post_array,$primary_key) {
		$data = array('rss' => 'http://stadja.net:8080/rss/'.$primary_key.'.xml');
		return $this->db->update('flux', $data, array('idflux' => $primary_key)); 
	}

	function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}	
	
	function offices_management()
	{
		try{

			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');
			
			$output = $crud->render();
			
			$this->_example_output($output);
			
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');
			
			$crud->required_fields('lastName');
			
			$crud->set_field_upload('file_url','assets/uploads/files');
			
			$output = $crud->render();

			$this->_example_output($output);
	}
	
	function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','{lastName} {firstName}');
			
			$output = $crud->render();
			
			$this->_example_output($output);
	}	
	
	function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();
			
			$output = $crud->render();
			
			$this->_example_output($output);
	}
	
	function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));
			
			$output = $crud->render();
			
			$this->_example_output($output);
	}	
	
	function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}
	
	function film_management()
	{
		$crud = new grocery_CRUD();
		
		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');
		
		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');
		
		$output = $crud->render();
		
		$this->_example_output($output);
	}
	
}
