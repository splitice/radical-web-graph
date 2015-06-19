<?php
namespace Radical\Utility\Image\Graph\Renderer;

class JSON extends ImageGraph implements IRenderable {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $schema){
		return $schema;
	}
}