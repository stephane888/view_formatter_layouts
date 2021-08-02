<?php
use Drupal\view_formatter_layouts\ViewFormatterLayouts;
use Drupal\Component\Utility\Html;

function template_preprocess_vfl_lamaisonsaintgobain_comments(array &$variables) {
	// https://drupal.stackexchange.com/questions/251014/programmatically-get-view-custom-text/298994
	// dump($variables['view']);
	$view = $variables['view'];
	// dump($view->style_plugin);
	// ViewFormatterLayouts::getViewTitle($View, $variables);
	if (! empty($view)) {
		ViewFormatterLayouts::ViewExecutable($view, $variables);
		// ViewFormatterLayouts::getViewTitle($view, $variables);
	}

	// if (! empty($variables['view']->element['#title']))
	// ViewFormatterLayouts::getViewTitle($View, $variables);
	// $variables['title'] = $variables['view']->element['#title'];
	$style_plugin = ViewFormatterLayouts::pluginVflLamaisonsaintgobainComments($view->style_plugin);
	$options = $style_plugin->options;
	// dump($view->style_plugin->options);
	if (! empty($options['view_layouts_fields'])) {
		$fields = ViewFormatterLayouts::unserialize($options['view_layouts_fields']);
		$templateIconeStar = '<svg viewBox="0 0 24 24" ><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path></svg>';
		foreach ($variables['rows'] as $id => $row) {
			$variables['rows'][$id] = [];
			foreach ($fields as $key_layout => $layout_label) {
				foreach ($options['view_layouts_options'] as $field_machine_name => $field_layout) {
					if ($field_layout == $key_layout) {
						if ('card_nombre_etoile' == $key_layout) {
							$nombreEtoile = $style_plugin->getFieldValue($id, $field_machine_name);
							// dump($nombreEtoile);
							// $nombreEtoile = ViewFormatterLayouts::ViewsRenderPipelineMarkup($variables['view']->field[$field_machine_name]->original_value);
							// dump($style_plugin->options);
							$iconClass = 'active';
							$renderEtoile = [];
							for ($i = 1; $i <= 5; $i ++) {
								if ($nombreEtoile < $i)
									$iconClass = '';
								$renderEtoile[] = [
									'#type' => 'html_tag',
									'#tag' => 'span',
									"#attributes" => [
										'class' => [
											$iconClass,
											'start',
											'icon'
										]
									],
									'data' => [
										'#type' => 'inline_template',
										'#template' => $templateIconeStar
									]
								];
							}
							$variables['rows'][$id][$key_layout][] = [
								'#type' => 'html_tag',
								'#tag' => 'div',
								"#attributes" => [
									'class' => [
										Html::cleanCssIdentifier($key_layout),
										'icons-reviews',
										'd-flex',
										'justify-content-center'
									]
								],
								'data' => $renderEtoile
							];
						}
						else
							$variables['rows'][$id][$key_layout][] = [
								'#type' => 'html_tag',
								'#tag' => 'div',
								"#attributes" => [
									'class' => [
										Html::cleanCssIdentifier($key_layout)
									]
								],
								'data' => [
									'#type' => 'inline_template',
									'#template' => $style_plugin->getField($id, $field_machine_name)
								]
							];
					}
				}
			}
		}
	}
	else {
		\Drupal::messenger()->addWarning("Le mode d'affichage doit avoir les champs.");
	}
	// dump($variables);
}