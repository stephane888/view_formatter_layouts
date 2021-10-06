<?php

namespace Drupal\view_formatter_layouts;

use Symfony\Component\Serializer\Serializer;
use Drupal\views\ViewExecutable;
use Drupal\views\Entity\View;
use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\field\Custom as viewCustomField;
use Drupal\views\Render\ViewsRenderPipelineMarkup;
use Drupal\view_formatter_layouts\Plugin\views\style\VflLamaisonsaintgobainComments;


class ViewFormatterLayouts
{

	/**
	 * Returns the theme hook definition information.
	 */
	public static function getThemeHooks()
	{
		//
		$hooks['view_formatter_layouts_default'] = [
				'preprocess functions' => [
						'template_preprocess_view_formatter_layouts_default'
				],
				'file' => 'view_formatter_layouts.theme.inc'
		];
		//
		$hooks['vfl_lamaisonsaintgobain_comments'] = [
				'preprocess functions' => [
						'template_preprocess_vfl_lamaisonsaintgobain_comments'
				],
				'file' => 'vfl_lamaisonsaintgobain_comments.theme.inc'
		];
		//
		$hooks['vfl_product_teaser'] = [
				'preprocess functions' => [
						'template_preprocess_vfl_product_teaser'
				],
				'file' => 'vfl_product_teaser.theme.inc'
		];
		//
		$hooks['vfl_product_full'] = [
				'preprocess functions' => [
						'template_preprocess_vfl_product_full'
				],
				'file' => 'vfl_product_full.theme.inc'
		];
		return $hooks;
	}

	public static function serialise($data, $format = 'json')
	{
		// $_Serializer = new Serializer();
		// return $_Serializer->encode($data, $format);
		return serialize($data);
	}

	public static function unserialize($data, $format = 'json')
	{
		// $_Serializer = new Serializer();
		// return $_Serializer->encode($data, $format);
		return unserialize($data);
	}

	public static function getViewTitle(View $View, array &$variables)
	{
		$variables["title"] = $View->label();
	}

	/**
	 * Cette function est utile pour pouvoir suivre les classes et valider l'object
	 *
	 * @param VflLamaisonsaintgobainComments $plugin
	 * @return \Drupal\view_formatter_layouts\Plugin\views\style\VflLamaisonsaintgobainComments
	 */
	public static function pluginVflLamaisonsaintgobainComments(VflLamaisonsaintgobainComments $plugin)
	{
		return $plugin;
	}

	public static function ResultRow(ResultRow $ResultRow)
	{
		//
	}

	public static function viewCustomField(viewCustomField $viewCustomField)
	{
		// $viewCustomField->getValue($values)
	}

	public static function ViewsRenderPipelineMarkup(ViewsRenderPipelineMarkup $ViewsRenderPipelineMarkup)
	{
		return $ViewsRenderPipelineMarkup->__toString();
	}

	public static function ViewExecutable(ViewExecutable $ViewExecutable, array &$variables)
	{
		$variables['title'] = $ViewExecutable->display_handler->default_display->options['title'];
	}
}

