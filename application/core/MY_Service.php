<?php 

class MY_Service {

  /**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;

  public function __construct()
  {
    $this->load =& load_class('Loader', 'core');
		$this->load->initialize();
    
    log_message('debug', "Service Class Initialized");
  }

  	/**
	 * Enable the use of CI super-global
	 *
	 * @param	string	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}

}