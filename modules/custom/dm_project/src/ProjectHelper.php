<?php

namespace Drupal\dm_project;

use Drupal\field\Entity\FieldStorageConfig;

class ProjectHelper {

  /**
   * Check current is node.
   *
   * @return mixed|null
   */
  public static function IsNode() {
    return \Drupal::routeMatch()->getParameter('node');
  }

  /**
   * Check is core module.
   *
   * @param $category
   *
   * @return bool
   */
  public static function IsCoreModuleByCategory($category) {
    $cateids = array_column($category, 'target_id');
    return in_array(11, $cateids);
  }

  /**
   * Load version
   *
   * @param string $version
   *
   * @return mixed
   */
  function LoadVersion($version = '') {

    $allowed_versions = FieldStorageConfig::loadByName('node', 'field_module_version')
      ->getSetting('allowed_values');
    if ($version && isset($allowed_versions[$version])) {
      return $allowed_versions[$version];
    }
    return $allowed_versions;
  }

  /**
   * @param $html
   *
   * @return array
   */
  function AddIdToH2H3Tags($html, $entity) {
    // header('content-type:text/html;charset=utf-8');
    $dom = new \DOMDocument();
    $meta = '<meta content="text/html; charset=utf-8" http-equiv="Content-Type">';
    @$dom->loadHTML($meta . $html);
    $xpath = new \DomXPath($dom);
    $doms = $xpath->query("//h2|//h3");

    if ($doms->length == 0)
      return $html;
    foreach ($doms as $element) {
      if (!$element->getAttribute('id')) {
        $machine_readable = strtolower($entity->get('title')->value);
        $machine_readable = preg_replace('@[^a-z0-9_]+@', '_', $machine_readable);
        $element->setAttribute('id', $machine_readable . '-' . user_password(5));
      }
    }
    $new_html = $dom->saveHTML();
    $source_html = str_replace($meta, '', $new_html);
    return $source_html;
  }

  /**
   * Check is core module.
   *
   * @param $entity
   *
   * @return bool
   */
  public static function IsCoreModule($entity) {
    return self::IsCoreModuleByCategory($entity->get('field_module_category')
      ->getValue());
  }

  /**
   * Obtain releases for a project's xml as returned by the update service.
   *
   * @param $module
   * @param $vstring
   *
   * @return bool
   */
  public static function LoadRelease($module, $vstring) {
    static $result;

    if (!isset($result[$module][$vstring])) {
      $release_url = 'http://updates.drupal.org/release-history/';
      $cache_id = "drupal-release-module-{$module}-$vstring";
      if ($cached = \Drupal::cache()->get($cache_id)) {
        $result[$module][$vstring] = $cached->data;
      }
      else {
        $xml = @simplexml_load_file($release_url . $module . '/' . $vstring);
        if (!$xml OR $xml->xpath('/error')) {
          $result[$module][$vstring] = FALSE;
        }
        else {
          foreach (array(
                     'title',
                     'short_name',
                     'dc:creator',
                     'api_version',
                     'recommended_major',
                     'supported_majors',
                     'default_major',
                     'project_status',
                     'link',
                   ) as $item) {
            if (array_key_exists($item, $xml)) {
              $value = $xml->xpath($item);
              $project_info[$item] = (string) $value[0];
            }
          }
          $recommended_major = @$xml->xpath("/project/recommended_major");
          $recommended_major = empty($recommended_major) ? "" : (string) $recommended_major[0];
          $supported_majors = @$xml->xpath("/project/supported_majors");
          $supported_majors = empty($supported_majors) ? array() : array_flip(explode(',', (string) $supported_majors[0]));
          $releases_xml = @$xml->xpath("/project/releases/release[status='published']");
          $recommended_version = NULL;
          $latest_version = NULL;
          foreach ($releases_xml as $release) {
            $release_info = array();
            foreach (array(
                       'name',
                       'version',
                       'tag',
                       'version_major',
                       'version_extra',
                       'status',
                       'release_link',
                       'download_link',
                       'date',
                       'mdhash',
                       'filesize',
                     ) as $item) {
              if (array_key_exists($item, $release)) {
                $value = $release->xpath($item);
                $release_info[$item] = (string) $value[0];
              }
            }
            $statuses = array();
            if (array_key_exists($release_info['version_major'], $supported_majors)) {
              $statuses[] = "Supported";
              unset($supported_majors[$release_info['version_major']]);
            }
            if ($release_info['version_major'] == $recommended_major) {
              if (!isset($latest_version)) {
                $latest_version = $release_info['version'];
              }
              // The first stable version (no 'version extra') in the recommended major
              // is the recommended release
              if (empty($release_info['version_extra']) && (!isset($recommended_version))) {
                $statuses[] = "Recommended";
                $recommended_version = $release_info['version'];
              }
            }
            if (!empty($release_info['version_extra']) && ($release_info['version_extra'] == "dev")) {
              $statuses[] = "Development";
            }
            foreach ($release->xpath('terms/term/value') as $release_type) {
              // There are three kinds of release types that we recognize:
              // "Bug fixes", "New features" and "Security update".
              // We will add "Security" for security updates, and nothing
              // for the other kinds.
              if (strpos($release_type, "Security") !== FALSE) {
                $statuses[] = "Security";
              }
            }
            $release_info['release_status'] = $statuses;
            $releases[$release_info['version']] = $release_info;
          }
          // If there is no -stable- release in the recommended major,
          // then take the latest verion in the recommended major to be
          // the recommended release.
          if (!isset($recommended_version) && isset($latest_version)) {
            $recommended_version = $latest_version;
            $releases[$recommended_version]['release_status'][] = "Recommended";
          }

          $project_info['releases'] = $releases;
          $project_info['recommended'] = $recommended_version;
          $result[$module][$vstring] = $project_info;
        }
        \Drupal::cache()->set($cache_id, $result[$module][$vstring]);
      }
    }
    return $result[$module][$vstring];
  }
}
