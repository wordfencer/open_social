<?php

namespace Drupal\social_group_staging;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\StorageInterface;

/**
 * Class SocialEventManagersConfigOverride.
 */
class SocialGroupStagingConfigOverride implements ConfigFactoryOverrideInterface {

  /**
   * Load overrides.
   */
  public function loadOverrides($names) {
    $overrides = [];

    // List of views to override.
    $views = [
      'views.view.group_events' => [
        'displays' => ['default'],
        'handlers' => ['access'],
      ],
      'views.view.group_information' => [
        'displays' => ['default'],
        'handlers' => ['access'],
      ],
      'views.view.group_managers' => [
        'displays' => ['default'],
        'handlers' => ['access'],
      ],
      'views.view.group_members' => [
        'displays' => ['default'],
        'handlers' => ['access'],
      ],
      'views.view.group_topics' => [
        'displays' => ['default'],
        'handlers' => ['access'],
      ],
      'views.view.groups' => [
        'displays' => ['default'],
        'handlers' => ['filter'],
      ],
      'views.view.newest_groups' => [
        'displays' => ['default', 'page_all_groups'],
        'handlers' => ['filter'],
      ],
    ];

    foreach ($views as $config_name => $data) {
      if (in_array($config_name, $names)) {
        // Add the access handler to the displays.
        if (in_array('access', $data['handlers'])) {
          foreach ($data['displays'] as $display) {
            $overrides[$config_name]['display'][$display]['display_options']['access']['type'] = 'unpublished_group_permission';
          }
        }

        // Add the filter handler to the displays.
        if (in_array('filter', $data['handlers'])) {
          foreach ($data['displays'] as $display) {
            $overrides[$config_name]['display'][$display]['display_options']['filters']['group_access_status'] = [
              'id' => 'group_access_status',
              'table' => 'groups',
              'field' => 'group_access_status',
              'group_type' => 1,
              'entity_type' => 'group',
              'plugin_id' => 'group_access_status',
            ];
          }
        }

      }
    }

    return $overrides;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheSuffix() {
    return 'SocialGroupStagingConfigOverride';
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata($name) {
    return new CacheableMetadata();
  }

  /**
   * {@inheritdoc}
   */
  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
    return NULL;
  }

}
