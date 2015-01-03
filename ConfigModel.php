<?php
class ConfigModel {
	
	private $_rawData;
	private $_mData;
	private $_delimeter;
	private $_searchKey;
	
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

	public function getValue() {
		$value = null;
		foreach($this->_rawData as $i => $data) {
			if($this->_searchKey == $data["key"]) {
				$value = $data["value"];
				break;
			}
		}	
		return $value;
	}
	
	public function getId() {
		$value = null;
		foreach($this->_rawData as $i => $data) {
			if($this->_searchKey == $data["key"]) {
				$value = $data["id"];
				break;
			}
		}	
		return $value;
	}
	
	public function getRawData() {
		return $this->_rawData;	
	}
	
	public function	getModeledData() {
		return $this->_mData;
	}	
		
	public function getType() {
		$value = null;
		foreach($this->_rawData as $i => $data) {
			if($this->_searchKey == $data["key"]) {
				$value = $data["stype"];
				break;
			}
		}	
		return $value;
	}		
	
	public function get($key) {
		$this->_searchKey = $key;
		return $this;
	}
	
	public function getDelimeter() {
		return $this->_delimeter;
	}	
		
}
?>
