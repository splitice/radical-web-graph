<?php
namespace Radical\Utility\Image\Graph\Source\Internal;

use Radical\Utility\Image\Graph\Source\IGraphSource;
use Radical\Utility\Image\Graph\Renderer\IRenderable;
use Radical\Utility\Image\Graph\Schema;

abstract class GraphBase implements IGraphSource {
	public $schema;
	
	function __construct($format = 'number',$title = null){
		$this->schema = new Schema\Graph();
		$this->schema->title = $title;
		$this->schema->axis['X']->format = $format;
	}
	
	abstract function getData();
	
	function setup($width,$height){	
		$this->schema->box->width = $width;
		$this->schema->box->height = $height;
	}
	function draw(IRenderable $R){
		$this->schema->data->SetAll($this->getData());

		return $R->Output($this->schema);
	}
}