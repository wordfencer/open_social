<?php

namespace Drupal\social_core\TestHelper;

/**
 * An empty base renamer.
 *
 * @TODO: Add interface for this class and inherit it.
 *
 * @package Drupal\Tests\social_core\Helper
 */
class SocialRenamer {

  /**
   * Provides a passthrough rename function for the distribution.
   *
   * This method can be used to change labels that might be changed in projects
   * using Open Social.
   *
   * For example if a 'Topic' is renamed to 'Discussion' then this function
   * would output 'Discussion' when it receives 'Topic'.
   *
   * @param $string
   *   The string to rename.
   *
   * @return string
   *   The altered string
   */
  function getRenamedTerm($string) {
    return $string;
  }
}
