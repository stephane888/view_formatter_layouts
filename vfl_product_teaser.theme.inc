<?php
use Drupal\Core\Template\Attribute;
use Drupal\view_formatter_layouts\ViewFormatterLayouts;
use Drupal\view_formatter_layouts\Services\RenderViewExecutable;
use Stephane888\Debug\debugLog;

function template_preprocess_vfl_product_teaser(array &$variables)
{
	// debugLog::$max_depth = 5;
	// debugLog::kintDebugDrupal($variables['view'], "template_preprocess_vfl_product_teaser");
	// dump($variables['rows'][0]);
	//
	$RenderViewExecutable = new RenderViewExecutable($variables['view']);
	// $StylePlugin = $RenderViewExecutable->getStylePlugin(); //
	$RenderViewExecutable->getDefaultdisplay(); //
	                                            // dump($RenderViewExecutable->getDefaultdisplay()->options); $variables['rows'] =
	$RenderViewExecutable->render($variables['rows']);
	$variables['#attached']['library'][] = "view_formatter_layouts/vfl-product-teaser";
	$variables['attributes'] = $RenderViewExecutable->ApplyAttributes();
}
