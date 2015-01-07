<?php
class AppSetting {
	
	private $_model;
	private $_searchKey;
	
	private $_value;
	private $_type;
	private $_id;
	
	public function __construct(ConfigModel $model, $searchKey) {
		
		$this->_model = $model;
		$this->_searchKey = $searchKey;

		$matches = $this->find();
		if(count($matches)>1) {

			$this->_value = $matches;
			$this->_type = 'array';
			$this->_id = null;
			
		} else {
			$this->retrieve();
		}

	}
	
	private function retrieve() {
		$value = null;
		foreach($this->_model->getRawData() as $i => $data) {
			if($this->_searchKey == $data["key"]) {
				$this->_value = $data["value"];
				$this->_id = $data["id"];
				$this->_type = $data["stype"];
				break;
			}
		}			
	}

	private function find() {
		$matches = array();
		
		foreach($this->_model->getModeledData() as $keyIndex => $value) {
			if(preg_match('/^'.$this->_searchKey.'/', $keyIndex)) {
				$matches[$keyIndex] = $value;
				$matches = ConfigUtils::buildArray($matches);
			}
		}	

		if(!empty($matches)) {
			$e =  array_filter(explode($this->_model->getDelimeter(), $this->_searchKey));
			for($n = 0; $n < count($e) - 1; $n++) {
				$matches = array_shift($matches);	
			}
			$matches = $matches[end($e)];
		} else {
			$matches = array();
		}	

		return $matches;		
	}

	public function getValue() {
		return $this->_value;
	}
	
	public function getId() {
		return $this->_id;
	}
	
	public function getType() {
		return $this->_type;
	}		
		
}
?>
