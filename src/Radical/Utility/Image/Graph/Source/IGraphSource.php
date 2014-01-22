<?php
namespace Radical\Utility\Image\Graph\Source;
use Radical\Utility\Image\Graph\Renderer\IRenderable;

interface IGraphSource {
	function setup($width,$height);
	function draw(IRenderable $R);
}