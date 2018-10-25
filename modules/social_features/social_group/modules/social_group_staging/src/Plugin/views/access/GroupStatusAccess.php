<?php

namespace Drupal\social_group_staging\Plugin\views\access;

use Drupal\group\Plugin\views\access\GroupPermission;
use Symfony\Component\Routing\Route;

/**
 * Access plugin that provides group permission-based access control.
 *
 * It also takes the status of the group into account.
 *
 * @ingroup views_access_plugins
 *
 * @ViewsAccess(
 *   id = "unpublished_group_permission",
 *   title = @Translation("Group permission (with group status)"),
 *   help = @Translation("Access will be granted to users with the specified group permission string.")
 * )
 */
class GroupStatusAccess extends GroupPermission {

  /**
   * {@inheritdoc}
   */
  public function alterRouteDefinition(Route $route) {
    $route->setRequirement('_group_status_permission', $this->options['group_permission']);

    // Upcast any %group path key the user may have configured so the
    // '_group_permission' access check will receive a properly loaded group.
    $route->setOption('parameters', ['group' => ['type' => 'entity:group']]);
  }

}
