<?php
namespace Radical\Utility\Image\Graph\Renderer;

use Radical\Utility\Image\Graph\pChart\Color;
use Radical\Utility\Image\Graph\pChart\pChart;
use Radical\Utility\Image\Graph\pChart\pData;
use Radical\Utility\PHP\Extension;

abstract class ImageGraph {
	const BORDER = 40;
	
	protected function _buildChart(\Radical\Utility\Image\Graph\Schema\Graph $graph){
		$ext = new Extension('gd', 'gd2');
		if(!$ext->isLoaded()){
			throw new \Exception('GD2 is required for graphing');
		}
		
		$pChart = new pChart($graph->box->width,$graph->box->height);
		
		foreach($graph->color as $color){
			$pChart->Palette[] = Color::fromHex($color);
		}
		
		$dataSet = new pData;
		$dataSet->SetXAxisFormat($graph->axis['X']->format);

		if($graph->axis['X']->format == 'date' && isset($graph->axis['X']->dateFormat)){
			$pChart->setDateFormat($graph->axis['X']->dateFormat);
		}
		
		$data = $graph->data->toArray();
		if($graph->type == 'pie'){
			$data = array(array_values($data),array_keys($data));
		}
		
		foreach($data as $name=>$series){
			if($graph->type == 'pie')
				$name = 's'.$name;
			$dataSet->AddPoint($series,$name);
		}
		
		$dataSet->AddAllSeries();
		
		if($graph->type == 'line' || $graph->type == 'plot'){
			if(isset($graph->data['X']))
				$dataSet->SetAbsciseLabelSerie("X");
		}elseif($graph->type == 'pie'){
			if(count($data) == 2){
				$dataSet->SetAbsciseLabelSerie('s1');
			}else{
				throw new \Exception('Pie graph must have two series');
			}
		}
		
		foreach($graph->axis as $k=>$axis){
			if($axis->symbol !== null){
				$dataSet->setSerieSymbol($k, $axis->symbol);
			}
		}
		
		// Initialise the graph
		if($graph->type == 'line' || $graph->type == 'plot'){
			$pChart->setFontProperties("tahoma.ttf",8);
			$pChart->setGraphArea(70,30,$graph->box->width-static::BORDER,$graph->box->height-static::BORDER);
		}
		$pChart->drawFilledRoundedRectangle(0,0,$graph->box->width,$graph->box->height,5,240,240,240);
		$pChart->drawRoundedRectangle(5,5,$graph->box->width-5,$graph->box->height-5,5,230,230,230);
		
		$pChart->drawGraphArea(255,255,255,TRUE);
		
		//Get Data
		$data = $dataSet->GetData();
		
		if($graph->type == 'line' || $graph->type == 'plot'){
			//Remove X
			if(isset($data[0]) && isset($data[0]['X'])){
				$dataSet->RemoveSerie('X');
				$data = $dataSet->GetData();
			}
			
			if($data){
				$mode = pChart::SCALE_NORMAL;
				foreach($graph->axis as $k=>$v){
					if($k != 'X'){
						if(!$v->autoSize){
							$mode = pChart::SCALE_START0;
						}
					}
				}
				$pChart->drawScale($data,$dataSet->GetDataDescription(),$mode,150,150,150,TRUE,0,2);
			}
			
			if($graph->grid)
				$pChart->drawGrid(4,TRUE,230,230,230,50,(int)$graph->grid);
		}
		
		// Draw the 0 line
		$pChart->setFontProperties("tahoma.ttf",6);
		$pChart->drawTreshold(0,143,55,72,TRUE,TRUE);
		
		if($graph->title){
			$pChart->setFontProperties("tahoma.ttf",10);
		
			$size = new \Radical\Basic\String\Size($graph->title,$pChart->getFont("tahoma.ttf"));
			$pChart->drawTitle($size->getCenteredLeft($graph->box->width),22,$graph->title,50,50,50);
		}
		
		// Draw the line graph
		if($graph->type == 'line' || $graph->type == 'plot'){
			$pChart->drawLineGraph($data,$dataSet->GetDataDescription());
			$pChart->drawPlotGraph($data,$dataSet->GetDataDescription(),3,2,255,255,255);
		}elseif($graph->type == 'pie'){
			try {
				$radius = max($graph->box->width/2, $graph->box->height/2) - (self::BORDER);
				//Only draw if there is data
				foreach($data as $v){
					if(!empty($v['s0'])){
						$pChart->drawPieGraph($data, $dataSet->GetDataDescription(), $graph->box->width/2, $graph->box->height/2, $radius, pChart::PIE_PERCENTAGE);
						break;
					}
				}
			}catch(\Exception $ex){
				die(var_dump($ex->getMessage()));
			}
		}
		
		// Finish the graph
		$pChart->setFontProperties("tahoma.ttf",8);
		if($graph->type == 'line' || $graph->type == 'plot'){
			$pChart->drawLegend(75,35,$dataSet->GetDataDescription(),255,255,255);
		}elseif($graph->type == 'pie'){
			$pChart->drawPieLegend(20,35,$dataSet->GetData(),$dataSet->GetDataDescription(),250,250,250);
		}

		return $pChart;
	}
}