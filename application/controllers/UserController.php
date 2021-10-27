<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use application\services\RoleService;

class UserController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->service('FunctionalService','service');
		$this->load->service('RoleService','roleService');
	}

	public function index()
	{
		$roles = $this->roleService->getRoles();
		$functionals = $this->service->getFunctional();

		echo json_encode(array_merge($roles, $functionals));
	}
}
