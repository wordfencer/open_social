<?php

namespace Drupal\social_group_staging\Plugin\views\filter;

use Drupal\Core\Access\AccessResult;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\FilterPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Filters by given list of node title options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("group_access_status")
 */
class GroupStatusFilter extends FilterPluginBase {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = $this->t('Group access status');
  }

  /**
   * {@inheritdoc}
   */
  public function canExpose() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->ensureMyTable();

    // @todo add this via Dependency Injection.
    $account = \Drupal::currentUser();

    $permissions = [
      'bypass group access',
      'administer inactive groups',
    ];

    // Check if the user has access based on above permissions.
    if (!AccessResult::allowedIfHasPermissions($account, $permissions, 'OR')->isAllowed()) {
      $this->query->addWhere('AND', 'groups_field_data.group_access_status', 'active');
    }
  }

}