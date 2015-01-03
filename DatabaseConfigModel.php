<?php
class DatabaseConfigLoaderModel  { 

	private static $_rawData = array();
	private static $_model; 
	private function __construct() {}
	
	public static function loadModel(ConfigModel $model) {
		self::$_model = $model;
	}
	
	public static function GetModel() {
		return self::$_model;	
	}
	

}
?>
