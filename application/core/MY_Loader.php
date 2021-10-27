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
     * Service Loader
     * 
     * This function lets users load and instantiate classes.
     * It is designed to be called from a user's app controllers.
     *
     * @param   string  the name of the class
     * @param   mixed   the optional parameters
     * @param   string  an optional object name
     * @return  void
     */
    public function service($service = '', $params = NULL, $object_name = NULL)
    {
        if(is_array($service))
        {
            foreach($service as $class)
            {
                $this->service($class, $params);
            }

            return;
        }

        if($service == '' or isset($this->services[$service])) {
            return FALSE;
        }

        if(! is_null($params) && ! is_array($params)) {
            $params = NULL;
        }

        $subdir = '';

        // Is the service in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($service, '/')) !== FALSE)
        {
                // The path is in front of the last slash
                $subdir = substr($service, 0, $last_slash + 1);

                // And the service name behind it
                $service = substr($service, $last_slash + 1);
        }
        $name = config_item('subclass_prefix')."Service.php";
        
        // Load the parent service 
        if (class_exists(config_item('subclass_prefix')."Service")
             === FALSE && file_exists(APPPATH.'core/'.$name))
        {
            require(APPPATH.'core/'.$name);
        }

        foreach($this->service_paths as $filepath)
        {
            if ( ! file_exists($filepath))
            {
                continue;
            }

            include_once($filepath);

            $service = strtolower($service);

            if (empty($object_name))
            {
                $object_name = $service;
            }

            $service = ucfirst($service);
            $CI = &get_instance();
            if($params !== NULL)
            {
                $CI->$object_name = new $service($params);
            }
            else
            {
                $CI->$object_name = new $service();
            }

            $this->services[] = $object_name;
        }
    }
}