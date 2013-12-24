<?php
namespace Radical\Utility\Image\Graph\Schema;

class Axis extends Internal\SchemaBase {
	public $format = 'number';
	public $label;
	public $labelSkip = 1;
	public $symbol = null;
	public $autosize = true;
}