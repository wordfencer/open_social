<?php

namespace Drupal\entity_renamer\Entity;

use Drupal\node\Entity\NodeType as NodeTypeBase;

/**
 * Class NodeType.
 *
 * Overwrites the Drupal Core NodeType to allow user configurable labels for
 * all content types.
 *
 * @package Drupal\entity_renamer\Entity
 * @see \Drupal\node\Entity\NodeType
 */
class NodeType extends NodeTypeBase {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // We overwrite all content type labels to the same string here. In practice
    // you would want to pull this from configuration based on the node type
    // machine name (id).
    // This method requires that the Content Type label is consistently used
    // throughout the platform.
    return "I'm a node type!";
  }

}
