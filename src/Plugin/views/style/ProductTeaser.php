<?php

namespace Drupal\view_formatter_layouts\Plugin\views\style;

use Drupal\core\form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\view_formatter_layouts\ViewFormatterLayouts;
use Drupal\Component\Plugin\PluginBase;


/**
 * Style plugin to render a list of years and months
 * in reverse chronological order linked to content.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "vfl-product-teaser",
 *   title = @Translation(" view Product tesaer "),
 *   help = @Translation("Render default model"),
 *   theme = "vfl_product_teaser",
 *   display_types = { "normal" }
 * )
 */
class ProductTeaser extends StylePluginBase
{

	function __construct($configuration, $plugin_id, $plugin_definition)
	{
		parent::__construct($configuration, $plugin_id, $plugin_definition);
	}

	/**
	 * Does the style plugin for itself support to add fields to it's output.
	 *
	 * @var bool
	 */
	protected $usesFields = TRUE;

	/**
	 * Does the style plugin allows to use style plugins.
	 *
	 * @var bool
	 */
	protected $usesRowPlugin = TRUE;

	/**
	 * Does the style plugin support custom css class for the rows.
	 *
	 * @var bool
	 */
	protected $usesRowClass = TRUE;

	/**
	 *
	 * {@inheritdoc}
	 */
	protected function defineOptions()
	{
		$options = parent::defineOptions();
		$options['view_layouts_fields'] = [
				'default' => NULL
		];
		$options['view_layouts_options'] = [
				'default' => NULL
		];
		$options['row_class'] = [
				'default' => 'col-md-3'
		];
		return $options;
	}

	/**
	 *
	 * {@inheritdoc}
	 */
	public function buildOptionsForm(&$form, FormStateInterface $form_state)
	{
		parent::buildOptionsForm($form, $form_state);
		if (isset($form['grouping'])) {
			unset($form['grouping']);
			$labels = $this->CustomLabels($this->displayHandler->getFieldLabels(TRUE));
			// listes des champs.
			$form['view_layouts_fields'] = [
					'#type' => 'hidden',
					'#default_value' => ViewFormatterLayouts::serialise($this->defaultRegions())
			];

			/**
			 * Add section
			 */
			$form['view_layouts_options'] = [
					'#type' => 'details',
					'#title' => 'Mappes les champs ci-dessous.',
					"#tree" => true,
					'#open' => true
			];
			foreach ( $labels as $key => $label ) {
				$form['view_layouts_options'][$key] = [
						'#type' => 'select',
						'#title' => $label,
						'#options' => $this->defaultRegions(),
						// '#required' => TRUE,
						'#default_value' => (isset($this->options['view_layouts_options'][$key])) ? $this->options['view_layouts_options'][$key] : '',
						'#empty_value' => ''
					// '#description' => $this->t('Select the layout that will be used to display "' . $label . '"')
				];
			}
		}
	}

	/**
	 * Fournis le model à utiliser.
	 */
	public function defaultRegions($model = "product-teaser")
	{
		$options = [];
		if ($model == 'product-teaser') {
			$options = [
					'image' => 'Image',
					'title' => "Title",
					'reference' => "Reference",
					'referencef' => "Reference fournisseur",
					'description' => "Description",
					'price' => "Prix",
					'button' => "Button",
					'stock' => 'Stock'
			];
		}
		return $options;
	}

	/**
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	protected function CustomLabels($data)
	{
		return \json_decode(json_encode($data), true);
	}
}


