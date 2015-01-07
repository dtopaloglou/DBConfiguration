<?php
class DBConfig {
	
	public static function read($key) {
		$model = DatabaseConfigLoaderModel::getModel();
		$key = preg_replace('/\s+/', '', $key);
		return new Setting($model, $key);
		
	}	
}
?>
