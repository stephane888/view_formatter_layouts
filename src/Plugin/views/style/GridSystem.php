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
 *   id = "vfl--gridsystem",
 *   title = @Translation(" Grid system VLF "),
 *   help = @Translation(" propose un system de grid model paulabianco.net "),
 *   theme = "vfl_gridsystem",
 *   display_types = { "normal" }
 * )
 */
class GridSystem extends StylePluginBase {
  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;
  
}