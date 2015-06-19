<?php
namespace Radical\Utility\Image\Graph\Renderer;

class Kendo extends ImageGraph implements IRenderable {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $schema){
		$data = array();
		foreach($schema->data as $axis=>$axis_data){
			$format = function($r){return $r;};
			if($schema->axis[$axis]){
				switch($schema->axis[$axis]->format){
					case 'date':
						$dateFormat = $schema->axis[$axis]->dateFormat;
						$format = function ($r) use($dateFormat) { return date($dateFormat,$r); };
						break;
				}
			}
			foreach($axis_data as $k=>$v){
				
				if(isset($data[$k])){
					$data[$k][$axis] = $format($v);
				}else{
					$data[$k]=array($axis => $format($v));
				}
			}
		}
		return array_values($data);
	}
}