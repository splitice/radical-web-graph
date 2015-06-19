<?php
namespace Radical\Utility\Image\Graph\Renderer;

class RawRender extends ImageGraph implements IRenderable {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $schema){
		$pChart = $this->_buildChart($schema);
		if(!$pChart->Render(null)){
			throw new \Exception('Failed to render image: '.error_get_last());
		}
	}
}