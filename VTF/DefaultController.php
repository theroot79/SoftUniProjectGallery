<?php

namespace VTF;

/**
 * Base Framework controller
 *
 * Class DefaultController
 * @package VTF
 */
class DefaultController
{

	/**
	 * @var \VTF\App
	 */
	public $app;

	/**
	 * @var \VTF\Db\Db
	 */
	public $db;

	/**
	 * @var \VTF\View
	 */
	public $view;

	/**
	 * @var \VTF\ConfigParser
	 */
	public $config;

	/**
	 * @var \VTF\InputData
	 */
	public $input;


	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->app = App::getInstance();
		$this->db = $this->app->_dbConnections;
		$this->view = View::getInstance();
		$this->config = $this->app->getConfig();
		$this->input = InputData::getInstance();
	}
}
