<?php
class DBConfig {
	
	public static function read($key) {
		$key = preg_replace('/\s+/', '', $key);
		$matches = array();
		
		foreach(DatabaseConfigLoaderModel::GetModel()->getModeledData() as $keyIndex => $value) {
			if(preg_match('/^'.$key.'/', $keyIndex)) {
				$matches[$keyIndex] = $value;
				$matches = ConfigUtils::buildArray($matches);
			}
		}	
		
		if(!empty($matches)) {
			$e =  array_filter(explode(DatabaseConfigLoaderModel::GetModel()->getDelimeter(), $key));
			for($n = 0; $n < count($e) - 1; $n++) {
				$matches = array_shift($matches);	
			}
			$matches = $matches[end($e)];
		} else {
			$matches = null;
		}	

		return $matches;
		
	}	
}
?>
