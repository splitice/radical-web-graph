<?php
namespace Radical\Utility\Image\Graph\Renderer;

class Base64String extends StringRender {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $pChart){
		$string = parent::Output($pChart);
		return base64_encode($string);
	}
}