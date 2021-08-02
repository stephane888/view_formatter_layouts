<?php
namespace Drupal\view_formatter_layouts\Plugin\views\style;

use Drupal\core\form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\view_formatter_layouts\ViewFormatterLayouts;

/**
 * Style plugin to render a list of years and months
 * in reverse chronological order linked to content.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "vfl-lamaisonsaintgobain-comments",
 *   title = @Translation("view comment model simple"),
 *   help = @Translation("Render default model"),
 *   theme = "vfl_lamaisonsaintgobain_comments",
 *   display_types = { "normal" }
 * )
 */
class VflLamaisonsaintgobainComments extends StylePluginBase {

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
	 *
	 * {@inheritdoc}
	 */
	protected function defineOptions() {
		$options = parent::defineOptions();
		$options['view_layouts_fields'] = [
			'default' => NULL
		];
		$options['view_layouts_options'] = [
			'default' => NULL
		];
		return $options;
	}

	/**
	 *
	 * {@inheritdoc}
	 */
	public function buildOptionsForm(&$form, FormStateInterface $form_state) {
		parent::buildOptionsForm($form, $form_state);
		if (isset($form['grouping'])) {
			unset($form['grouping']);
			$labels = $this->CustomLabels($this->displayHandler->getFieldLabels(TRUE));
			// listes des champs.
			$form['view_layouts_fields'] = [
				'#type' => 'hidden',
				'#default_value' => ViewFormatterLayouts::serialise($this->defaultOptions())
			];
			/**
			 * add section
			 */
			$form['view_layouts_options'] = array(
				'#type' => 'details',
				'#title' => 'Mappes les champs ci-dessous.',
				"#tree" => true,
				'#open' => true
			);
			foreach ($labels as $key => $label) {
				$form['view_layouts_options'][$key] = [
					'#type' => 'select',
					'#title' => $label,
					'#options' => $this->defaultOptions(),
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
	protected function defaultOptions($model = "cards") {
		$options = [];
		if ($model == 'cards') {
			$options = [
				'card_title_field' => 'Commentaire',
				'card_content_field' => "Nom de l'utilisateur",
				'card_image_field' => "Note etoile",
				'card_localisation' => "Localisation",
				'card_nombre_etoile' => "Nombre d'etoile"
			];
		}
		return $options;
	}

	protected function CustomLabels($data) {
		return \json_decode(json_encode($data), true);
	}
}