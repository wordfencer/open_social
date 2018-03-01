<?php

namespace Drupal\Tests\social_core\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\JavascriptTestBase as BaseJavascriptTestBase;

/**
 * Base class for Open Social Functional Javascript tests.
 *
 * @package Drupal\Tests\social_core\FunctionalJavascript
 */
class JavascriptTestBase extends BaseJavascriptTestBase {

  /**
   * {@inheritdoc}
   */
  protected $profile = 'social';

  /**
   * {@inheritdoc}
   */
  protected static $configSchemaCheckerExclusions = [
    // We exclude bootstrap schema validation for all Open Social tests.
    // See: https://www.drupal.org/project/bootstrap/issues/2860072
    'bootstrap.settings',
    'socialbase.settings',
    'socialblue.settings',
  ];

  /**
   * @var \Drupal\social_core\TestHelper\SocialRenamer
   */
  protected $renamer;

  /**
   * {@inheritdoc}
   */
  public function __construct($name = NULL, array $data = [], $dataName = '') {
    parent::__construct($name, $data, $dataName);

    $renamer_module = getenv('SOCIAL_RENAMER');
    $this->loadRenamerClass($renamer_module);
  }

  protected function r($string) {
    return $this->renamer->getRenamedTerm($string);
  }

  protected function loadRenamerClass($renamer_module = FALSE) {
    // If no value is specified we just load the core renamer.
    if ($renamer_module === FALSE) {
      $renamer_module = 'social_core';
    }

    $renamer_class = "Drupal\\" . $renamer_module . "\\TestHelper\\SocialRenamer";

    if (!class_exists($renamer_class)) {
      throw new \Exception($renamer_class . " could not be found.");
    }

    $this->renamer = new $renamer_class();
  }

}
