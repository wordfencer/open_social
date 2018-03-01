<?php

namespace Drupal\sdgc_core\TestHelper;

use Drupal\social_core\TestHelper\SocialRenamer as BaseSocialRenamer;

/**
 * The SDGC test renamer class.
 *
 * @package Drupal\Tests\sdgc_core\Helper
 */
class SocialRenamer extends BaseSocialRenamer {

  /**
   * {@inheritdoc}
   */
  function getRenamedTerm($string) {
    $dictionary = [
      'Discussion' => 'Topic',
    ];

    // If we know how to rename this, do so. Otherwise, pass through.
    return isset($dictionary[$string]) ? $dictionary[$string] : $string;
  }
}
