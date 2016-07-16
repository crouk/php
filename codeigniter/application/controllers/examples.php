<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}
	/*OFICINAS*/
	public function offices_management()
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
	/*EMPLEADOS*/
	public function employees_management()
	{
		try{
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
		}catch(Exception $e){
				show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	/*CLIENTES*/
	public function customers_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	/*PEDIDOS*/
	public function orders_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	/*PRODUCTOS*/
	public function products_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	/*PELICULAS*/
	public function film_management()
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
	/*PELICULAS BOOTstrap*/
	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	/*********************************** MULTIGRID ************************************************************/
	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{

		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}
	
	/*********************************** /MULTIGRID ************************************************************/
	/*** USUARIOS ***/
	public function user_management()
	{
		try{
			/*-Nuevo Objeto-*/
			$crud = new grocery_CRUD();
			/*-Tipo Tablas('datatables' o 'flexigrid')-*/
			$crud->set_theme('datatables');
			/*-Tabla de BD*/
			$crud->set_table('users');
			/*-Alias tabla*/
			$crud->set_subject('Usuarios');
			/*-Idioma*/
			$crud->set_language('spanish');
			/*-Ordenado-*/
			$crud->order_by('id','asc');
			/*-column y field y required-*/
			$crud->columns('id','surname','name','username','email','estado');
			/*Campos Requeridos*/
			$crud->required_fields('username','name','surname','password','email','telephone','acces_type');
			
			/*ALIAS*/
			$crud->display_as('username','Usuario')
			->display_as('email','Email')
			->display_as('password','Clave')
			->display_as('name','Nombre')
			->display_as('created_at','Fecha de creacion')
			->display_as('surname','Apellido')
			->display_as('acces_type','Tipo de Usuario')
			->display_as('start_date','Fecha inicio validez')
			->display_as('end_date','Fecha fin validez')
			->display_as('telephone','Telefono')
			->display_as('active','Activo');
			
			/*TIPOLOGIA DE CAMPOS*/
			$crud->field_type('password','password');
			$crud->field_type('password','password');
			$crud->field_type('created_at', 'hidden');
			$crud->field_type('start_date', 'hidden');
			$crud->field_type('end_date', 'hidden');
			$crud->field_type('active','hidden');
			$crud->field_type('email_enviado','hidden');
			$crud->field_type('fecha_email','hidden');
			
			/*RELACION*/
			$crud->set_relation('acces_type','user_type','name');
			
			/*-CALLBACKS*/
			$crud->callback_before_insert(array($this,'checking_fechas_validez_usuario'));
			$crud->callback_column('estado',array($this,'_GC_Estatus_active'));
			
			/*-ACCIONES*/
			$crud->add_action('Val.','http://192.168.2.33/pruebas/assets/bootstrap/img/led/user.png','administrador/activar_desactivar_login','ui-icon-person');
			
			$output = $crud->render();
			
			$this->_example_output($output);
			
		}catch (Excpetion $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}	
	}
	
	function encrypt_password($post_array) {
		/*
		Lo que hacemos es encriptar el password siempre y cuando
		el campo password no este vacio, en ese caso no se hace nada
		*/
		$this->load->library('encrypt');
		$key = 'super-secret-key';
		$post_array['password'] = $this->encrypt->encode($post_array['password'], $key);
		return $post_array;
	}
	
	function decrypt_password($value) {
		/*Lo que hacemos es des-encriptar el password siempre y cuando
		 * el campo password no este vacio, en ese caso no se hace nada
			* */
		$this->load->library('encrypt');
		$key = 'super-secret-key';
		$decrypted_password = $this->encrypt->decode($value, $key);
		return "<input type='password' name='password' value='$decrypted_password' />";
	}
	
	function checking_fechas_validez_usuario($post_array){
	
		if((empty($post_array['created_at']))){
			
			$post_array['created_at']=date('Y-m-d H:i:s');
			$post_array['active'] = 1;
			$post_array['email_enviado'] = 0;
				
			/*Ciframos el password*/
			//$this->load->library('encrypt');
			//$key = 'super-secret-key';
			//$post_array['password'] = $this->encrypt->encode($post_array['password'], $key);
		}
		return $post_array;
	}

	function activar_desactivar_login($id)
	{
		$query = "SELECT active FROM users where id = ".$id;
		$resultdo = $this->db->query($query);
		foreach ($resultdo->result() as $activo){
			switch ($activo->active){
				case 1:
					$query="UPDATE users SET active = 0 WHERE id=".$id;
					$this->db->query($query);
					$this->desactivar_vigencia($id);
					redirect('administrador/user_management');
					break;
				case 0:
					$query="UPDATE users SET active = 1 WHERE id=".$id;
					$this->db->query($query);
					$this->activar_vigencia($id);
					redirect('administrador/user_management');
					break;
						
			}
		}
	}
	function _GC_Estatus_active($value,$row){
		if($row->active == 1){
			return '<span class ="alert"> On </span>';
		}else{
			return '<span class ="alert alert-danger">Off</span>';
		}
	}
	/*** /USUARIOS ***/
}
