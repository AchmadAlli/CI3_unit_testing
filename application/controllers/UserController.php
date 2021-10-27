<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use application\services\RoleService;

class UserController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->service('RoleService','roleService');
		$this->load->service('FunctionalService','serv');
	}

	public function index()
	{
		echo $this->serv->getFunctional();
	}
}
