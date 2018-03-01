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
    'social_embed',
  ];

  /**
   * Disable strict checking.
   *
   * We do this because Open Social has quite a few missing or invalid
   * configuration schemas.
   *
   * @var bool
   */
  protected $strictConfigSchema = FALSE;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $user = $this->createUser([], 'embed_1', FALSE);
    $this->drupalLogin($user);
  }

  /**
   * Test oEmbed WYSIWYG button for topics.
   */
  public function testTopicEmbed() {
    // Given I am on "node/add/topic".
    $this->drupalGet('node/add/topic');
    $page = $this->getSession()->getPage();
    $assert_session = $this->assertSession();

    // And I click radio button "Discussion".
    $page->checkField($this->r('Discussion'));

    // When I fill in "Embed WSIWYG" in "Title".
    $page->fillField($this->r('Title'), $this->r('Embed WYSIWYG'));

    // And I click on the embed icon in the WYSIWYG editor.
    $this->clickLink('Media');

    // And I wait for AJAX to finish.
    $this->iWaitForAjaxToFinish();

    // And I fill in "URL" with "https://www.youtube.com/watch?v=kgE9QNX8f3c".
    $page->fillField($this->r('URL'), 'https://www.youtube.com/watch?v=kgE9QNX8f3c');

    // And I press "Embed" in the "WYSIWYG Embed dialog".
    $page->pressButton($this->r('Embed'));

    // And I wait for AJAX to finish.
    $this->iWaitForAjaxToFinish();

    // And I press "Save".
    $page->pressButton($this->r('Save'));

    // Then I should see "Topic Embed WYSIWYG has been created.".
    $assert_session->pageTextContains($this->r('Topic Embed WYSIWYG has been created.'));

    // And The iframe in the body description should have the src
    // "https://www.youtube.com/embed/kgE9QNX8f3c?feature=oembed".
    $assert_session->elementExists('css', 'iframe[src="https://www.youtube.com/embed/kgE9QNX8f3c?feature=oembed"]');
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
