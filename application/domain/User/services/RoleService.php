<?php 

class RoleService extends MY_Service
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Role', 'role');
  }

  public function getRoles()
  {
    return $this->role->getRoles();
  }


}