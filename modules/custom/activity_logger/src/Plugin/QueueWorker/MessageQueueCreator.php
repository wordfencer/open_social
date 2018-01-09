<?php

namespace Drupal\activity_logger\Plugin\QueueWorker;

use Drupal\activity_creator\Plugin\ActivityActionManager;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A report worker.
 *
 * @QueueWorker(
 *   id = "activity_logger_message",
 *   title = @Translation("Process activity_logger_message queue."),
 *   cron = {"time" = 60}
 * )
 *
 * This QueueWorker is responsible for creating message items from the queue
 */
class MessageQueueCreator extends MessageQueueBase implements ContainerFactoryPluginInterface {
  protected $activityAction;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ActivityActionManager $activityAction) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->activityAction = $activityAction;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.activity_action.processor')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {

    // First make sure it's an actual entity.
    if ($entity = Node::load($data['entity_id'])) {
      // Check if it's created more than 20 seconds ago.
      $timestamp = $entity->getCreatedTime();
      // Current time.
      $now = time();
      $diff = abs($now - $timestamp);

      // Items must be at least 5 seconds old.
      if ($diff <= 5 && $now > $timestamp) {
        // Wait for 100 milliseconds.
        // We don't want to flood the DB with unprocessable queue items.
        usleep(100000);
        $queue = \Drupal::queue('activity_logger_message');
        $queue->createItem($data);
      }
      else {
        // Trigger the create action for enttites.
        $create_action = $this->activityAction->createInstance('create_entitiy_action');
        /** @var \Drupal\activity_basics\Plugin\ActivityAction\CreateActivityAction $create_action */
        $create_action->createMessage($entity);
      }
    }
  }

}
