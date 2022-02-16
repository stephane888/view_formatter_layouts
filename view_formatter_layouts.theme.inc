<?php
use Drupal\view_formatter_layouts\ViewFormatterLayouts;

function template_preprocess_view_formatter_layouts_default(array &$variables) {
  $view = $variables['view'];
  $options = $view->style_plugin->options;
  
  if (!empty($options['view_layouts_fields'])) {
    $fields = ViewFormatterLayouts::unserialize($options['view_layouts_fields']);
    
    foreach ($variables['rows'] as $id => $row) {
      $variables['rows'][$id] = [];
      foreach ($fields as $key_layout => $layout_label) {
        foreach ($options['view_layouts_options'] as $field_machine_name => $field_layout) {
          if ($field_layout == $key_layout) {
            $variables['rows'][$id][$key_layout][] = $view->style_plugin->getField($id, $field_machine_name);
          }
        }
      }
    }
  }
  else {
    \Drupal::messenger()->addWarning("Le mode d'affichage doit avoir les champs.");
  }
}

function template_preprocess_vfl_gridsystem(array &$variables) {
/**
 *
 * @var \Drupal\views\ViewExecutable $view
 */
  // $view = $variables['view'];
  
  // foreach ($variables['rows'] as $id => $row) {
  // /**
  // * Pour effectuer le rendu, on verifie si ce sont les champs ou une entité.
  // */
  // if ($view->style_plugin->usesFields()) {
  // //
  // }
  // // si non, le rendu est automatique.
  // }
}