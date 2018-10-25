<?php

/**
 * @file
 * Contains Views hooks.
 */

/**
 * Implements hook_views_data_alter().
 */
function social_group_staging_views_data_alter(array &$data) {
  $data['groups']['group_access_status'] = [
    'group' => t('Group'),
    'title' => t('Group status'),
    'filter' => [
      'title' => t('Group status'),
      'help' => t('Checks the group status and the users permission for access.'),
      'field' => 'group_access_status',
      'id' => 'group_access_status',
    ],
  ];
}
