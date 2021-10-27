<?php 

class RoleService extends MY_Service {
  private $userRoleModel;

  public function __construct()
  {
    parent::__construct();
    // $this->userRoleModel = new UserRole();
  }

  public function getMemberRole($user)
  {
    // echo count($this->userRoleModel->getRoles());
    echo "member role";
  }

  public function getSupervisor($user)
  {

  }

}