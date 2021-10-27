<?php 

class Functional extends CI_Model
{
  public function getFunctional()
  {
    return [
      [
        "id" =>  1,
        "name" => "Telesales Leader"
      ],
      [
        "id" =>  2,
        "name" => "Sales Leader"
      ],
    ];
  }
}