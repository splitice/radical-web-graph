<?php
namespace Radical\Utility\Image\Graph\Renderer;

interface IRenderable {
	function output(\Radical\Utility\Image\Graph\Schema\Graph $pChart);
}