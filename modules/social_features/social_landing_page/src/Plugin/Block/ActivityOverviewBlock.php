<?php

namespace Drupal\social_landing_page\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'ActivityOverviewBlock' block.
 *
 * @Block(
 *  id = "activity_overview_block",
 *  admin_label = @Translation("Activity overview"),
 * )
 */
class ActivityOverviewBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Connection definition.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * {@inheritdoc}
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    Connection $connection
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->connection = $connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node_counts = $this->getNodeCounts();
    $event_count = $node_counts['event']->count;
    $topic_count = $node_counts['topic']->count;

    $group_count = $this->getGroupsCount();
    $user_count  = $this->getUsersCount();
    $post_count  = $this->getPostsCount();
    $comment_count = $this->getCommentsCount();

    return [
      [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['activity-overview'],
        ],
        'event_info' => [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['event-info'],
          ],
          'event' => [
            'icon' => [
              '#markup' => '<svg class="teaser__content-type-icon"><use xlink:href="#icon-event"></use></svg>',
              '#allowed_tags' => ['use', 'svg'],
            ],
            'content' => [
              '#type' => 'container',
              '#attributes' => [
                'class' => ['info-wrapper'],
              ],
              'value' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $event_count,
                '#attributes' => [
                  'class' => ['value'],
                ],
              ],
              'name' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $this->t('events'),
                '#attributes' => [
                  'class' => ['name'],
                ],
              ],
            ],
          ],
        ],
        'topic_info' => [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['topic-info'],
          ],
          'topic' => [
            'icon' => [
              '#markup' => '<svg class="teaser__content-type-icon"><use xlink:href="#icon-topic"></use></svg>',
              '#allowed_tags' => ['use', 'svg'],
            ],
            'content' => [
              '#type' => 'container',
              '#attributes' => [
                'class' => ['info-wrapper'],
              ],
              'value' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $topic_count,
                '#attributes' => [
                  'class' => ['value'],
                ],
              ],
              'name' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $this->t('topics'),
                '#attributes' => [
                  'class' => ['name'],
                ],
              ],
            ],
          ],
        ],
        'group_info' => [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['group-info'],
          ],
          'group' => [
            'icon' => [
              '#markup' => '<svg class="teaser__content-type-icon"><use xlink:href="#icon-group"></use></svg>',
              '#allowed_tags' => ['use', 'svg'],
            ],
            'content' => [
              '#type' => 'container',
              '#attributes' => [
                'class' => ['info-wrapper'],
              ],
              'value' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $group_count,
                '#attributes' => [
                  'class' => ['value'],
                ],
              ],
              'name' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $this->t('groups'),
                '#attributes' => [
                  'class' => ['name'],
                ],
              ],
            ],
          ],
        ],
        'user_info' => [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['user-info'],
          ],
          'group' => [
            'icon' => [
              '#markup' => '<svg class="teaser__content-type-icon"><use xlink:href="#icon-account_circle"></use></svg>',
              '#allowed_tags' => ['use', 'svg'],
            ],
            'content' => [
              '#type' => 'container',
              '#attributes' => [
                'class' => ['info-wrapper'],
              ],
              'value' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $user_count,
                '#attributes' => [
                  'class' => ['value'],
                ],
              ],
              'name' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $this->t('users'),
                '#attributes' => [
                  'class' => ['name'],
                ],
              ],
            ],
          ],
        ],
        'post_info' => [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['post-info'],
          ],
          'post' => [
            'icon' => [
              '#markup' => '<svg class="teaser__content-type-icon"><use xlink:href="#icon-edit"></use></svg>',
              '#allowed_tags' => ['use', 'svg'],
            ],
            'content' => [
              '#type' => 'container',
              '#attributes' => [
                'class' => ['info-wrapper'],
              ],
              'value' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $post_count,
                '#attributes' => [
                  'class' => ['value'],
                ],
              ],
              'name' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $this->t('posts'),
                '#attributes' => [
                  'class' => ['name'],
                ],
              ],
            ],
          ],
        ],
        'comment_info' => [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['comment-info'],
          ],
          'comment' => [
            'icon' => [
              '#markup' => '<svg class="teaser__content-type-icon"><use xlink:href="#icon-comment"></use></svg>',
              '#allowed_tags' => ['use', 'svg'],
            ],
            'content' => [
              '#type' => 'container',
              '#attributes' => [
                'class' => ['info-wrapper'],
              ],
              'value' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $comment_count,
                '#attributes' => [
                  'class' => ['value'],
                ],
              ],
              'name' => [
                '#type' => 'html_tag',
                '#tag' => 'span',
                '#value' => $this->t('comments'),
                '#attributes' => [
                  'class' => ['name'],
                ],
              ],
            ],
          ],
        ],
      ],
      '#attached' => [
        'library' => [
          'social_landing_page/activity_overview',
        ],
      ],
    ];

  }

  /**
   * Get node counts.
   */
  protected function getNodeCounts() {
    $query = $this->connection->select('node_field_data', 'n');
    $query->addField('n', 'type');
    $query->addExpression('COUNT(*)', 'count');
    $query->condition('n.status', 1);
    $query->groupBy('n.type');
    return $query->execute()->fetchAllAssoc('type');
  }

  /**
   * Get total count of groups.
   */
  protected function getGroupsCount() {
    // There is no unpublished option for groups.
    $query = $this->connection->select('groups', 'g');
    $query->addExpression('COUNT(*)');
    return $query->execute()->fetchField();
  }

  /**
   * Get total count of users.
   */
  protected function getUsersCount() {
    // Skip blocked users and user 1.
    $query = $this->connection->select('users_field_data', 'u');
    $query->addExpression('COUNT(*)');
    $query->condition('u.status', 1);
    $query->condition('u.uid', 1, '<>');
    return $query->execute()->fetchField();
  }

  /**
   * Get total count of posts.
   */
  protected function getPostsCount() {
    $query = $this->connection->select('post_field_data', 'p');
    $query->addExpression('COUNT(*)');
    $query->condition('p.status', 1);
    return $query->execute()->fetchField();
  }

  /**
   * Get total count of comments.
   */
  protected function getCommentsCount() {
    // Count both comment and post_comment type.
    $query = $this->connection->select('comment_field_data', 'c');
    $query->addExpression('COUNT(*)');
    $query->condition('c.status', 1);
    return $query->execute()->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    // Ensure we don't recreate this block for a few minutes.s
    return 2 * 60;
  }
}
