<?php

namespace Drupal\Tests\social_embed\FunctionalJavascript;

use Drupal\Tests\social_core\FunctionalJavascript\JavascriptTestBase;

/**
 * Tests the embedding of a YouTube video in a post using WYSIWYG embed button.
 *
 * @group social
 */
class WYSIWYGEmbedTest extends JavascriptTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'social_embed'
  ];

  /**
   * Disable strict checking.
   *
   * @var bool
   */
  protected $strictConfigSchema = FALSE;

  /**
   * {@inheritdoc}
   */
  protected static $configSchemaCheckerExclusions = [
    'search_api.server.social_database',
    'search_api.index.social_content',
    'search_api.index.social_users',
    'search_api.index.social_groups',
    'search_api.index.social_all',
    'core.entity_view_display.activity.activity.default',
    'core.entity_view_display.activity.activity.notification',
    'core.entity_view_display.activity.activity.notification_default',
    'field.field.node.event.field_content_visibility',
    'core.entity_form_display.node.event.default',
    'core.entity_view_display.node.event.default',
    'core.entity_view_display.node.event.activity',
    'core.entity_view_display.node.event.activity_comment',
    'core.entity_view_display.node.event.featured',
    'core.entity_view_display.node.event.hero',
    'core.entity_view_display.node.event.search_index',
    'core.entity_view_display.node.event.search_teaser',
    'core.entity_view_display.node.event.small_teaser',
    'core.entity_view_display.node.event.teaser',
    'field.field.node.book.field_content_visibility',
    'core.entity_form_display.node.book.default',
    'core.entity_view_display.node.book.default',
    'core.entity_view_display.node.book.activity',
    'core.entity_view_display.node.book.activity_comment',
    'core.entity_view_display.node.book.featured',
    'core.entity_view_display.node.book.hero',
    'core.entity_view_display.node.book.search_index',
    'core.entity_view_display.node.book.search_teaser',
    'core.entity_view_display.node.book.small_teaser',
    'core.entity_view_display.node.book.teaser',
    'views.view.events',
    'views.view.upcoming_events',
    'views.view.group_events',
    'field.field.node.topic.field_content_visibility',
    'core.entity_form_display.node.topic.default',
    'core.entity_view_display.node.topic.default',
    'core.entity_view_display.node.topic.activity',
    'core.entity_view_display.node.topic.activity_comment',
    'core.entity_view_display.node.topic.featured',
    'core.entity_view_display.node.topic.hero',
    'core.entity_view_display.node.topic.search_index',
    'core.entity_view_display.node.topic.search_teaser',
    'core.entity_view_display.node.topic.small_teaser',
    'core.entity_view_display.node.topic.teaser',
    'field.field.node.page.field_content_visibility',
    'core.entity_form_display.node.page.default',
    'core.entity_view_display.node.page.default',
    'core.entity_view_display.node.page.activity',
    'core.entity_view_display.node.page.activity_comment',
    'core.entity_view_display.node.page.featured',
    'core.entity_view_display.node.page.hero',
    'core.entity_view_display.node.page.search_index',
    'core.entity_view_display.node.page.search_teaser',
    'core.entity_view_display.node.page.small_teaser',
    'core.entity_view_display.node.page.teaser',
    'field.field.node.landing_page.field_content_visibility',
    'core.entity_form_display.node.landing_page.default',
    'core.entity_view_display.node.landing_page.default',
    'core.entity_view_display.node.landing_page.activity',
    'core.entity_view_display.node.landing_page.activity_comment',
    'core.entity_view_display.node.landing_page.featured',
    'core.entity_view_display.node.landing_page.hero',
    'core.entity_view_display.node.landing_page.search_index',
    'core.entity_view_display.node.landing_page.search_teaser',
    'core.entity_view_display.node.landing_page.small_teaser',
    'core.entity_view_display.node.landing_page.teaser',
    'field.field.post.post.field_visibility',
    'core.entity_form_display.post.post.default',
    'core.entity_form_display.post.post.group',
    'core.entity_form_display.post.post.profile',
    'core.entity_view_display.post.post.default',
    'core.entity_view_display.post.post.activity',
    'core.entity_view_display.post.post.activity_comment',
    'core.entity_view_display.post.post.featured',
    'core.entity_view_display.post.post.hero',
    'core.entity_view_display.post.post.search_index',
    'core.entity_view_display.post.post.search_teaser',
    'core.entity_view_display.post.post.small_teaser',
    'core.entity_view_display.post.post.teaser',
    'views.view.user_admin_people',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $user = $this->createUser([], 'embed_1', FALSE);
    $this->drupalLogin($user);
  }

  public function testTopicEmbed() {
    // Given I am on "node/add/topic"
    $this->drupalGet('node/add/topic');

    // And I click radio button "Discussion"
    $this->getSession()->getPage()->checkField($this->r('Discussion'));

    // When I fill in the following:
    //   | Title | Embed WYSIWYG |
    $this->getSession()->getPage()->fillField($this->r('Title'), $this->r('Embed WYSIWYG'));

    // And I click on the embed icon in the WYSIWYG editor
    $this->clickEmbedIconInWysiwygEditor();

    // And I wait for AJAX to finish
    $this->iWaitForAjaxToFinish();

    // And I fill in "URL" with "https://www.youtube.com/watch?v=kgE9QNX8f3c"
    $this->getSession()->getPage()->fillField($this->r('URL'),'https://www.youtube.com/watch?v=kgE9QNX8f3c');

    // And I press "Embed" in the "WYSIWYG Embed dialog"
    $this->getSession()->getPage()->pressButton($this->r('Embed'));

    // And I wait for AJAX to finish
    $this->iWaitForAjaxToFinish();
    $this->iWaitForAjaxToFinish();

    // And I wait for "3" seconds
    // And I press "Save"
    $this->getSession()->getPage()->pressButton($this->r('Save'));

    // Then I should see "Topic Embed WYSIWYG has been created."
    $this->assertSession()->pageTextContains($this->r('Topic Embed WYSIWYG has been created.'));

    // And The iframe in the body description should have the src "https://www.youtube.com/embed/kgE9QNX8f3c?feature=oembed"
    $this->assertSession()->elementExists('css', 'iframe[src="https://www.youtube.com/embed/kgE9QNX8f3c?feature=oembed"]');
  }

  public function clickEmbedIconInWysiwygEditor() {
    $cssSelector = 'a.cke_button__social_embed';

    $session = $this->getSession();
    $element = $session->getPage()->find(
      'xpath',
      $session->getSelectorsHandler()->selectorToXpath('css', $cssSelector)
    );
    if (null === $element) {
      throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $cssSelector));
    }

    $element->click();
  }

  /**
   * Wait for AJAX to finish.
   *
   * @Given I wait for AJAX to finish
   */
  public function iWaitForAjaxToFinish() {
    $this->getSession()->wait(5000, '(typeof(jQuery)=="undefined" || (0 === jQuery.active && 0 === jQuery(\':animated\').length))');
  }

}