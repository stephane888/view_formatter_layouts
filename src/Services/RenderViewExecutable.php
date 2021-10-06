<?php

namespace Drupal\view_formatter_layouts\Services;

use Drupal\view_formatter_layouts\Services\Exception\ViewFormatterLayoutsLogicException;
use Drupal\views\ViewExecutable;
use Drupal\Core\Template\Attribute;
use Drupal\views\Plugin\views\field\EntityField;
use Stephane888\Debug\debugLog;


class RenderViewExecutable
{

	protected $ViewExecutable;

	private $style_plugin;

	/**
	 *
	 * @var \Drupal\views\Plugin\views\display\DefaultDisplay $Display
	 */
	private $Display;

	function __construct(ViewExecutable $ViewExecutable)
	{
		$this->ViewExecutable = $ViewExecutable;
	}

	function getStylePlugin()
	{
		$this->style_plugin = $this->ViewExecutable->style_plugin;
		return $this->style_plugin;
	}

	function getDefaultdisplay()
	{
		$this->Display = $this->ViewExecutable->style_plugin->displayHandler->default_display;
		return $this->Display;
	}

	/**
	 *
	 * @param array $regions
	 * @param array $rows
	 * @throws ViewFormatterLayoutsLogicException
	 * @return array|\Drupal\Component\Render\MarkupInterface|NULL
	 */
	function render(Array $rows)
	{
		$this->getStylePlugin();
		$FieldsMapper = $this->style_plugin->options;
		if (empty($FieldsMapper['view_layouts_options']))
			throw new ViewFormatterLayoutsLogicException(" L'affichage " . $this->style_plugin->getDerivativeId() . " ne dispose pas de champs. ");
		$FieldsMapper = $FieldsMapper['view_layouts_options'];
		// $regions = $this->style_plugin->defaultRegions();
		$vars = [];
		foreach ( $rows as $id => $row ) {
			foreach ( $FieldsMapper as $field_machine_name => $regionKey ) {
				$attributes = new Attribute();
				$attributes->addClass([
						'item',
						$regionKey
				]);
				$vars[$id][$regionKey]['attributes'] = $attributes;
				$vars[$id][$regionKey]['content'][] = $this->GetField($this->ViewExecutable->field[$field_machine_name], $id, $field_machine_name);
			}
		}
		return $vars;
	}

	/**
	 * Cette fonction devra etre ameliorer, pour pouvoir afficher le contenu en utilisant un rendu avec les templates.
	 *
	 * @param EntityField $field
	 * @return string[][]|string[][][][]|NULL[][]
	 */
	function GetField($field, $id, $field_machine_name)
	{
		$f = [];
		if (! empty($field->options['label'])) {
			$f[] = [
					'#type' => 'html_tag',
					'#tag' => 'span',
					"#attributes" => [
							'class' => [
									'item-label'
							]
					],
					'#value' => $field->options['label']
			];
		}
		$f[] = [
				'#type' => 'html_tag',
				'#tag' => 'span',
				"#attributes" => [
						'class' => [
								'item-content'
						]
				],
				'#value' => $this->style_plugin->getField($id, $field_machine_name)
		];
		return $f;
	}

	/**
	 * Cette fonction devra etre ameliorer, pour pouvoir afficher le contenu en utilisant un rendu avec les templates.
	 *
	 * @param EntityField $field
	 * @return string[][]|string[][][][]|NULL[][]
	 */
	function GetField__FURTUR($field)
	{
		// dump($field->render_item(0, $item));
		$f = [];
		if (! empty($field->options['label'])) {
			$f[] = [
					'#type' => 'html_tag',
					'#tag' => 'span',
					"#attributes" => [
							'class' => [
									'item-label'
							]
					],
					'#value' => $field->options['label']
			];
		}
		// $f[] = [
		// '#type' => 'inline_template',
		// '#template' => $field->last_render,
		// '#context' => []
		// ];
		$f[] = [
				'#type' => 'html_tag',
				'#tag' => 'span',
				"#attributes" => [
						'class' => [
								'item-content'
						]
				],
				'#value' => $field->last_render
		];
		return $f;
	}

	function ApplyAttributes()
	{
		$this->getStylePlugin();
		$Attribute = new Attribute();
		if (isset($this->style_plugin->options['row_class'])) {
			return $Attribute->addClass($this->style_plugin->options['row_class']);
		}
		else
			throw new ViewFormatterLayoutsLogicException(" L'affichage " . $this->style_plugin->getDerivativeId() . " ne dispose pas de row_class. ");
	}
}