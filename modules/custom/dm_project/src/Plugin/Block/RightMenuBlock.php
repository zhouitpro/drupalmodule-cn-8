<?php

namespace Drupal\dm_project\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\dm_project\ProjectHelper;
use Drupal\node\NodeInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Right menu' Block.
 *
 * @Block(
 *   id = "project_right_menu",
 *   admin_label = @Translation("Right menu"),
 *   category = @Translation("Right menu"),
 * )
 */
class RightMenuBlock extends BlockBase {

  /**
   * 获取所有的h2,h3标签.
   *
   * @param $source_html
   *
   * @return array
   */
  public function load_tags($source_html) {
    $dom = new \DomDocument();
    $meta = '<meta content="text/html; charset=utf-8" http-equiv="Content-Type">';
    $dom->loadHTML($meta . $source_html);
    $xpath = new \DomXPath($dom);
    $doms = $xpath->query("//h2|//h3");
    $tags = [];
    foreach ($doms as $element) {
      if ($element->nodeValue && $element->getAttribute('id')) {
        $tags[] = array(
          'title' => $element->nodeValue,
          'id'    => $element->getAttribute('id'),
          'tag'   => $element->nodeName,
        );
      }
    }

    return $tags;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $anchor_link_has = [];
    $node = \Drupal::routeMatch()->getParameter('node');
//    $categorys = $node->get('field_module_category')->getValue();
//    && in_array(DM_PROJECT_CORE_MODULE_TID, array_column($categorys, 'target_id'))
    if ($node instanceof NodeInterface && $node->getType() == 'project') {

      $anchor_link_has = array();
      $anchor_link_has[] = Link::fromTextAndUrl($this->t('module description'), Url::fromRoute('<current>', array(), array(
        'fragment' => "main-content",
      )));

      $ConfigContent = $node->get('field_module_config')->value;
      $tags = $this->load_tags($ConfigContent);

      $index_id = 1;

      // 创建子目录.
      if ($tags) {
        foreach ($tags as $tag) {

          if ($tag['tag'] == 'h2') {
            $index = $tag['tag'] . $index_id;
            $index_id++;
          }

          if (isset($index)) {
            $link = Link::fromTextAndUrl($tag['title'], Url::fromRoute('<current>', array(), array(
              'fragment' => $tag['id'],
            )));

            if ($tag['tag'] == 'h2') {

              $anchor_link_has[$index] = array(
                '#theme'     => 'item_list',
                '#list_type' => 'ol',
                '#title'     => $link,
              );
            }

            // 如果有h3标签,将h3标签写成h2的子标签.
            if ($tag['tag'] == 'h3') {
              $anchor_link_has[$index]['#items'][] = $link;
            }
          }
        }
      }

      if(!ProjectHelper::IsCoreModule($node)) {
        $anchor_link_has[] = Link::fromTextAndUrl($this->t('module download'), Url::fromRoute('<current>', array(), array(
          'fragment' => 'block-module-download',
        )));
      }

      foreach ($anchor_link_has as $key => $anchor_link_has_item) {
        if (is_array($anchor_link_has_item) && empty($anchor_link_has_item['#items'])) {
          $anchor_link_has[$key] = $anchor_link_has_item['#title'];
        }
      }
    }

    // build block render.
    return array(
      '#cache' => ['max-age' => 0],
      '#theme'     => 'item_list',
      '#list_type' => 'ul',
      '#items'     => $anchor_link_has,
    );
  }
}
