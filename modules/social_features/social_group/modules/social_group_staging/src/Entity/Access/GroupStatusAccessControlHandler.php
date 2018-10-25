<?php

namespace Drupal\social_group_staging\Entity\Access;

use Drupal\group\Access\GroupAccessResult;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\group\Entity\Access\GroupAccessControlHandler;
use Drupal\group\Entity\Group;

/**
 * Access controller for the Group entity.
 *
 * @see \Drupal\group\Entity\Group.
 */
class GroupStatusAccessControlHandler extends GroupAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return $this->checkGroupStatusAccess($entity, $account, 'view group');

      case 'update':
        return $this->checkGroupStatusAccess($entity, $account, 'edit group');

      case 'delete':
        return $this->checkGroupStatusAccess($entity, $account, 'delete group');
    }

    return AccessResult::neutral();
  }

  /**
   * Check Group Access Status.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   Entity.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Account.
   * @param string $permission
   *   Permission.
   *
   * @return \Drupal\Core\Access\AccessResult|\Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultForbidden
   *   Return Access Result.
   */
  protected function checkGroupStatusAccess(EntityInterface $entity, AccountInterface $account, $permission) {
    $group_status = $entity->get('group_access_status')->value;

    // User need to have permission 'view group' if group status is active.
    if ($group_status === 'active') {
      return GroupAccessResult::allowedIfHasGroupPermission($entity, $account, $permission);
    }
    // If Group is inactive.
    elseif ($group_status === 'inactive') {
      $permissions = [
        'bypass group access',
        'administer inactive groups',
      ];

      // Check if the user has access based on above permissions.
      if (AccessResult::allowedIfHasPermissions($account, $permissions, 'OR')->isAllowed()) {
        return AccessResult::allowed();
      }
      else {
        return AccessResult::forbidden();
      }
    }
    else {
      // In other cases it is forbidden.
      return AccessResult::forbidden();
    }
  }

}
