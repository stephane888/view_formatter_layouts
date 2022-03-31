<?php
use Drupal\Core\Template\Attribute;
use Drupal\view_formatter_layouts\ViewFormatterLayouts;
use Drupal\view_formatter_layouts\Services\RenderViewExecutable;

function template_preprocess_vfl_product_teaser(array &$variables)
{
	
	$RenderViewExecutable = new RenderViewExecutable($variables['view']);
	// $StylePlugin = $RenderViewExecutable->getStylePlugin(); //
$RenderViewExecutable->getDefaultdisplay(); // //
dump($RenderViewExecutable->getDefaultdisplay()->options); $variables['rows'] =
$RenderViewExecutable->render($variables['rows']);
$variables['#attached']['library'][] =
"view_formatter_layouts/vfl-product-teaser"; $variables['attributes'] =
$RenderViewExecutable->ApplyAttributes(); }
