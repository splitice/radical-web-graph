<?php
namespace Radical\Utility\Image\Graph\Renderer;

class String extends RawRender {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $pChart){
		ob_start();
		parent::Output($pChart);
		$string = ob_get_contents();
		ob_end_clean();
		return $string;
	}
}