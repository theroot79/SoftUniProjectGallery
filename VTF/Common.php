<?php

namespace VTF;

/**
 * Used for some basic functionalities.
 *
 * Class Common
 * @package VTF
 */
class Common
{
	/**
	 * Cleans input values.
	 *
	 * @param $data
	 * @param string $types
	 * @return bool|float|int|mixed
	 */
	public static function normalize ($data , $types = 'int|string|email') {
		$typeArr = explode("|",$types);

		if(is_array($typeArr) && count($typeArr)>0){

			foreach($typeArr as $v){

				if($v == 'int'){
					$data = intval($data);
				}
				if($v == 'float'){
					$data = floatval($data);
				}
				if($v == 'double'){
					$data = (double) $data;
				}
				if($v == 'bool'){
					$data = boolval($data);
				}
				if($v == 'string'){
					$data = filter_var($data, FILTER_SANITIZE_STRING);
				}
				if($v == 'email'){
					$data = filter_var($data, FILTER_SANITIZE_EMAIL);
				}
				if($v == 'email'){
					$data = filter_var($data, FILTER_SANITIZE_EMAIL);
				}
				if($v == 'trim'){
					$data = trim($data);
				}
			}
		}
		return $data;
	}


}
