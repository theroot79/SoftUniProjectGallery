<?php

namespace VTF;

/**
 * Class for validation of input data.
 *
 * Class Validation
 * @package VTF
 */
class Validation
{

	private $_rules = array();
	private $_errors = array();

	/**
	 * Creates a list of rules
	 *
	 * @param $rule string Validation Rule to call from static methods
	 * @param $value string|null Value to check
	 * @param null $params array|string Parameters relative to value
	 * @param null $name string Name of the check , used later in error management
	 * @return $this
	 */
	public function setRule($rule, $value, $params = null, $name = null)
	{
		$this->_rules[] = array('val' => $value, 'rule' => $rule, 'par' => $params, 'name' => $name);
		return $this;
	}

	/**
	 * Clears the rules
	 */
	public function clearRules()
	{
		$this->_rules = array();
	}

	/**
	 * Main validate method, based on the list of rules - validates all items.
	 *
	 * @return bool
	 */
	public function validate()
	{
		$this->_errors = array();
		if (count($this->_rules) > 0) {
			foreach ($this->_rules as $rule) {
				if ($this->$rule['rule']($rule['val'], $rule['par']) == false) {
					if ($rule['name']) {
						$this->_errors[] = $rule['name'];
					} else {
						$this->_errors[] = $rule['rule'];
					}
				}
			}
		}

		return (bool)!count($this->_errors);
	}

	/**
	 * Returns a list of errors.
	 *
	 * @return array A list of errors
	 */
	public function getErrors()
	{
		return $this->_errors;
	}

	public static function matches($val1, $val2)
	{
		return $val1 == $val2;
	}

	public static function alphabet($val)
	{
		return (bool) preg_match('/^[a-zа-Я]{1,1000}$/i', $val);
	}

	public static function alphanum($val)
	{
		return (bool) preg_match('/^(a-z0-9)+$/i', $val);
	}

	public static function alphanumdash($val)
	{
		return (bool) preg_match('/^(-a-z0-9_-)+$/i', $val);
	}

	public static function numeric($val)
	{
		return is_numeric($val);
	}

	public static function email($val)
	{
		return filter_var($val, FILTER_VALIDATE_EMAIL) !== false;
	}

	public static function url($val)
	{
		return filter_var($val, FILTER_VALIDATE_URL) !== false;
	}

	public static function ip($val)
	{
		return filter_var($val, FILTER_VALIDATE_IP) !== false;
	}

	public static function emails($val)
	{
		if (is_array($val)) {
			foreach ($val as $mail) {
				if (self::email($mail) == false) {
					return false;
				}
			}
		} else {
			return false;
		}
		return true;
	}

	public function __call($a, $b)
	{
		throw new \Exception('Invalid validation rule', 400);
	}

	public static function minlength($string, $minlength)
	{
		return (mb_strlen($string) >= $minlength);
	}
}