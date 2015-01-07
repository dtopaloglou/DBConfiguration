<?php
class ConfigModel {
	
	private $_rawData;
	private $_mData;
	private $_delimeter;
	
	public function __construct($rawData, $delimeter = '.') {
		$this->_rawData = $rawData;
		$this->_delimeter = $delimeter;	
		$this->_convert();
	}
	
	
	private function _convert() {
		foreach($this->_rawData as $i => $data) {
			$this->_mData[$data["key"]] = $data["value"];
		
		}
	}	

	public function getRawData() {
		return $this->_rawData;	
	}
	
	public function	getModeledData() {
		return $this->_mData;
	}	
		
	public function getDelimeter() {
		return $this->_delimeter;
	}	
		
}
?>
