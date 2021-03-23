<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Inflector\InflectorFactory;
use Illuminate\Support\Collection;

use function Symfony\Component\String\s;

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Router extends CI_Router
{
	public $controller_suffix = 'Controller';

	private $controller_dir = '';

	public function __construct()
	{
		$this->controller_dir = APPPATH . 'controllers/' . $this->directory;
		parent::__construct();
	}


	/**
	 * Set default controller
	 *
	 * @return	void
	 */
	protected function _set_default_controller()
	{
		if (empty($this->default_controller)) {
			show_error('Unable to determine what should be displayed. A default route has not been specified in the routing file.');
		}

		// Is the method being specified?
		if (sscanf($this->default_controller, '%[^/]/%s', $class, $method) !== 2) {
			$method = 'index';
		}

		$inflector = InflectorFactory::create()->build();
		$className = $inflector->classify($class . $this->controller_suffix);

		if (!file_exists($this->controller_dir . $className . '.php')) {
			// This will trigger 404 later
			return;
		}

		$this->set_class($class);
		$this->set_method($method);

		// Assign routed segments, index starting from 1
		$this->uri->rsegments = array(
			1 => $class,
			2 => $method
		);

		log_message('debug', 'No URI present. Default controller set.');
	}

	/**
	 * Set class name
	 *
	 * @param	string	$class	Class name
	 * @return	void
	 */
	public function set_class($class)
	{
		$inflector = InflectorFactory::create()->build();
		$this->class = $inflector->classify(str_replace(array('/', '.'), '', $class) . $this->controller_suffix);
	}

	/**
	 * Set route mapping
	 *
	 * Determines what should be served based on the URI request,
	 * as well as any "routes" that have been set in the routing config file.
	 *
	 * @return	void
	 */
	protected function _set_routing()
	{
		parent::_set_routing();
		// TODO @hyunmui: 전체 컨트롤러를 뒤져서 또다른 routes cache file 을 생성하여 이것으로 빠르게 읽을 수 있도록 수정 필요
	}
}

/* End of file MY_Router.php */
