<?php
namespace Radical\Utility\Image\Graph\Source;

class DatabaseZeroed extends Database {
	function getData(){
		$data = parent::getData();
		foreach($data as $k=>$array){
			foreach($array as $key=>$value){
				foreach($data as $k2 => $array2){
					if(!isset($data[$k2][$key])){
						$data[$k2][$key] = 0;
					}
				}
			}
		}
		foreach($data as $k=>$v){
			ksort($data[$k]);
		}
		return $data;
	}
}