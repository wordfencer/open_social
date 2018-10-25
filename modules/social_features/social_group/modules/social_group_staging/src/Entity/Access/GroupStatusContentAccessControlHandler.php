<?php

namespace Drupal\social_group_staging\Entity\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\group\Entity\Access\GroupContentAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the Group entity.
 *
 * @see \Drupal\group\Entity\Group.
 */
class GroupStatusContentAccessControlHandler extends GroupContentAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    // Check if group is closed.
    if ($entity->getGroup()->get('group_access_status')->value === 'inactive') {
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
    // Check other access.
    else {
      /** @var \Drupal\group\Entity\GroupContentInterface $entity */
      return $entity->getContentPlugin()->checkAccess($entity, $operation, $account);
    }
  }

}
