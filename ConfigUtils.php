class ConfigUtils {
	
	public static function array_merge_recursive_drill() {
        $arrays = func_get_args();
        $base = array_shift($arrays);
        foreach ($arrays as $array) {
            reset($base); //important
            while (list($key, $value) = @each($array)) {
		
                if (is_array($value) && @is_array($base[$key])) {
                    $base[$key] = self::array_merge_recursive_drill($base[$key], $value);
                } else {
                    $base[$key] = $value;
                }
            }
        }

        return $base;	
	}
	
	public static function insert_using_keys($keys, $value){
		$array = array();
		$ref = &$array;
		while(count($keys) > 0){
			$n = array_shift($keys);
			if(!is_array($ref)) {
				$ref = array();
			}

			$ref = &$ref[$n];
		}
		$ref = $value;
		return $array;
	}
	
	public static function buildArray($strings, $delimeter = '.') {
		$list = array();
		foreach($strings as $key => $value) {
			$list[] = self::insert_using_keys(explode($delimeter, $key), $value);
		}
		return call_user_func_array('self::array_merge_recursive_drill', $list);	// as of PHP 5.3.0
	}
	
	public static function buildString($array, $delimeter = '.') {
		$results = array();
		$func = function($item, $key, $old_key = NULL) use (&$func, &$results, $delimeter) {
			if(is_array($item)) {
				array_walk($item, $func, $old_key . $key . $delimeter);
			} else {
				$results[$old_key . $key] = $item;
			}
		};
		array_walk($array, $func);
		return  $results;
	}
	
}
