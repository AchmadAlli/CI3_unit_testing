<?php

class MY_Loader extends CI_Loader
{
    /**
     * List of loaded sercices
     *
     * @var array
     * @access protected
     */
    protected $services = array();
    /**
     * List of paths to load sercices from
     *
     * @var array
     * @access protected
     */
    protected $service_paths = array();

    /**
     * Constructor
     * 
     * Set the path to the Service files
     */
    public function __construct()
    {
        parent::__construct();
        $this->service_paths = array(
            ...glob(APPPATH.'services/*.php'),
            ...glob(APPPATH.'domain/**/services/*.php')
        );
    }

	/**
	 * Model Loader
	 *
	 * Loads and instantiates models.
	 *
	 * @param	mixed	$service	Service name
	 * @param	string	$name		An optional object name to assign to
	 * @return	object
	 */
	public function service($service, $name = '')
	{
		if (empty($service))
		{
			return $this;
		}
		elseif (is_array($service))
		{
			foreach ($service as $key => $value)
			{
				is_int($key) ? $this->service($value, '') : $this->service($key, $value);
			}

			return $this;
		}

		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($service, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($service, 0, ++$last_slash);

			// And the model name behind it
			$service = substr($service, $last_slash);
		}

		if (empty($name))
		{
			$name = $service;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return $this;
		}

		$CI =& get_instance();
        
        $parentService = config_item('subclass_prefix')."Service.php";
        require_once(APPPATH.'core/'.$parentService);

		if (isset($CI->$name))
		{
			throw new RuntimeException('The service name you are loading is the name of a resource that is already being used: '.$name);
		}

		$service = ucfirst($service);
		if ( ! class_exists($service, FALSE))
		{
			foreach (glob(APPPATH.'domain/**/services/'. $service .'.php') as $service_path)
			{
				if ( ! file_exists($service_path))
				{
					continue;
				}

				require_once($service_path);

				if ( ! class_exists($service, FALSE))
				{
                    print_r($service);
					throw new RuntimeException($service_path);
				}

				break;
			}

			if ( ! class_exists($service, FALSE))
			{
                print_r($service);
				throw new RuntimeException('Unable to locate the service you have specified: '.$service);
			}
		}

		$this->services[] = $name;
		$service = new $service();
		$CI->$name = $service;
		log_message('info', 'Service "'.get_class($service).'" initialized');
		return $this;
	}
}