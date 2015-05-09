<?php

namespace Models;
use \VTF\Db\Db;

class Main extends Db{

	private $_page = 0;
	const resultsPerPage = 8;

	/**
	 * Sets the current page number
	 *
	 * @param $page
	 */
	protected function setPage($page){
		$this->_page = intval($page);
	}

	/**
	 * Returns the current page number
	 */
	protected function getPage(){
		return $this->_page;
	}

}