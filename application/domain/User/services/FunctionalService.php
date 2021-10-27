<?php

class FunctionalService extends MY_Service {

  public function __construct()
  {
    parent::__construct();
    $test = $this->load->model('Functional', 'functional');
  }

  public function getFunctional()
  {
    return $this->functional->getFunctional();
  }

}