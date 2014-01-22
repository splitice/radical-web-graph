<?php
namespace Radical\Utility\Image\Graph\Renderer;

use Radical\Utility\Image\Graph\Renderer\IRenderable;

class JSON extends ImageGraph implements IRenderable {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $schema){
		return $schema;
	}
}