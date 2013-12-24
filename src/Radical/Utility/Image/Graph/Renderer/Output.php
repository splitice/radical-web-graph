<?php
namespace Radical\Utility\Image\Graph\Renderer;

class Output extends RawRender {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $pChart){
		parent::Output($pChart);
		header('Content-Type: image/png',true);
	}
}