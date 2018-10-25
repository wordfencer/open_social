<?php

/**
 * @file
 * Hooks specific to the Social Group Staging module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alter the views for the which the access and/or filter handlers are added.
 *
 * The keys are the config names of the views.
 *
 * For the displays you can add 'default' to alter all displays except any
 * overridden ones. You can add specific displays by adding their machinename to
 * the list.
 *
 * There are two handlers that can be added, one is *access*. This is useful for
 * pages that take a group as the argument. E.g. an overview in a group you want
 * to shield off.
 * The other one is *filter* which allows you to filter out non-active
 * groups in a list.
 *
 * @param array $views
 *   A list of views with data about which displays need to be altered.
 *
 * @see \Drupal\social_group_staging\SocialGroupStagingConfigOverride
 */
function hook_views_handlers_override_alter(array &$views) {
  unset($views['views.view.groups']);

  $views['views.view.group_members']['displays'][] = 'page_group_members';
  $views['views.view.group_members']['handlers'][] = 'filter';


  $views['views.view.greatest_groups'] = [
    'displays' => ['default', 'block_'],
    'handlers' => ['filter'],
  ];
}

/**
 * @} End of "addtogroup hooks".
 */
