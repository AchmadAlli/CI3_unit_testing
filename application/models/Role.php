<?php 

class Role extends CI_Model{
  
  public function getRoles()
  {
    return [
      [
        "id" => 1,
        "name" => "Officer"
      ],
      [
        "id" => 2,
        "name" => "Specialist"
      ]
    ];
  }
}