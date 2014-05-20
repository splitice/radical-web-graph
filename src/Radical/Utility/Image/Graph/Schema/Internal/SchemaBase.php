<?php
namespace Radical\Utility\Image\Graph\Schema\Internal;

abstract class SchemaBase implements \JsonSerializable {
	function jsonSerialize(){
		$t = get_object_vars($this);
		foreach($t as $k=>$v){
			if($v === null){
				unset($t[$k]);
			}
		}
		return $t;
	}
}