<?php

namespace Drupal\view_formatter_layouts;

use Symfony\Component\Serializer\Serializer;
use Drupal\views\ViewExecutable;
use Drupal\views\Entity\View;
use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\field\Custom as viewCustomField;
use Drupal\views\Render\ViewsRenderPipelineMarkup;
use Drupal\view_formatter_layouts\Plugin\views\style\VflLamaisonsaintgobainComments;
use Drupal\Core\Entity\EntityInterface;

class ViewFormatterLayouts {
  
  /**
   * Returns the theme hook definition information.
   */
  public static function getThemeHooks() {
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
    //
    $hooks['vfl_gridsystem'] = [
      'preprocess functions' => [
        'template_preprocess_vfl_gridsystem'
      ],
      'file' => 'view_formatter_layouts.theme.inc'
    ];
    //
    return $hooks;
  }
  
  public static function serialise($data, $format = 'json') {
    // $_Serializer = new Serializer();
    // return $_Serializer->encode($data, $format);
    return serialize($data);
  }
  
  public static function unserialize($data, $format = 'json') {
    // $_Serializer = new Serializer();
    // return $_Serializer->encode($data, $format);
    return unserialize($data);
  }
  
  public static function getViewTitle(View $View, array &$variables) {
    $variables["title"] = $View->label();
  }
  
  /**
   * Cette function est utile pour pouvoir suivre les classes et valider l'object
   *
   * @param VflLamaisonsaintgobainComments $plugin
   * @return \Drupal\view_formatter_layouts\Plugin\views\style\VflLamaisonsaintgobainComments
   */
  public static function pluginVflLamaisonsaintgobainComments(VflLamaisonsaintgobainComments $plugin) {
    return $plugin;
  }
  
  public static function ResultRow(ResultRow $ResultRow) {
    //
  }
  
  public static function viewCustomField(viewCustomField $viewCustomField) {
    // $viewCustomField->getValue($values)
  }
  
  public static function ViewsRenderPipelineMarkup(ViewsRenderPipelineMarkup $ViewsRenderPipelineMarkup) {
    return $ViewsRenderPipelineMarkup->__toString();
  }
  
  public static function ViewExecutable(ViewExecutable $ViewExecutable, array &$variables) {
    $variables['title'] = $ViewExecutable->display_handler->default_display->options['title'];
  }
  
  /**
   * permet de faire le rendu d'une ligne utilisant une entity.
   * Ceci est a utiliser dans de rare cas, car lorsque la view a definie le content type et view_mode, le rendu se fait de maniere automatique.
   */
  public static function renderRowEntity($row, array $options) {
    if (!empty($row->_entity) && $row->_entity instanceof EntityInterface) {
      /**
       *
       * @var EntityInterface $entity
       */
      $entity = $row->_entity;
      /**
       *
       * @var \Drupal\Core\Entity\EntityViewBuilderInterface $view_builder
       */
      $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity->getEntityTypeId());
      $view_mode = !empty($options['view_mode']) ? $options['view_mode'] : 'default';
      return $view_builder->view($entity, $view_mode);
    }
  }
  
}

