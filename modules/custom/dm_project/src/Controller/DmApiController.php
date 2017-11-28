<?php

namespace Drupal\dm_project\Controller;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Controller\ControllerBase;
use Drupal\dm_project\ProjectHelper;
use Drupal\node\NodeInterface;

/**
 * An example controller.
 */
class DmApiController extends ControllerBase {

  /**
   * get project download list.
   *
   * Callback for `api/get_download` API method.
   */
  public function get_download(NodeInterface $node) {

    $version_id = $node->get('field_module_version')->value;
    $module_name = $node->get('field_module_short_name')->value;
    $release_info = ProjectHelper::LoadRelease($module_name, $version_id);

    if (!ProjectHelper::IsCoreModule($node) && isset($release_info['releases']) && !empty($release_info['releases'])) {
      $key = 0;
      $top_rows = array();
      $button_rows = array();
      foreach ($release_info['releases'] as $ver => $release) {
        $public = array();
        $public[] = format_size($release['filesize']);
        $public[] = date('Y-m-d', $release['date']);
        $public['localize'] = Link::fromTextAndUrl('翻译下载', Url::fromUri("http://ftp.drupal.org/files/translations/{$version_id}/{$module_name}/{$module_name}-{$release['version']}.zh-hans.po"));
        $public[] = Link::fromTextAndUrl("发布链接", Url::fromUri($release['release_link']));
        if ($ver == $release_info['recommended']) {
          //recommended_version
          $download_link = Link::fromTextAndUrl($release['name'] . ' 稳定版', Url::fromUri($release['download_link']));
          array_unshift($public, $download_link);
          $top_rows[$key] = array('data' => $public, 'class' => array('recommended_version'));
        }
        elseif (!empty($release['release_status']) && in_array('Development', $release['release_status'])) {
          $public['localize'] = '暂无';
          $download_link = Link::fromTextAndUrl($release['name'] . ' 开发版', Url::fromUri($release['download_link']));
          array_unshift($public, $download_link);
          $top_rows[$key] = array('data' => $public, 'class' => array('devel_version'));
        }
        else {
          $download_link = Link::fromTextAndUrl($release['name'], Url::fromUri($release['download_link']));
          array_unshift($public, $download_link);
          $button_rows[$key] = array('data' => $public, 'class' => array('other_version'));
        }
        $key++;
      }
      $header = array(
        '模块版本', '文件大小', '发布日期', '翻译下载', '详细信息'
      );
      $ele = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => array_merge($top_rows, $button_rows),
      ];
      $output = render($ele);
    }
    else {
      $output = '没有找到下载文件';
    }

    print render($output);
    exit();
  }
}
