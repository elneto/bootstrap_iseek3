<?php

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>

<div class="row">
  <div class="col-lg-12">
    <div class="toolkit large-text"><?php print t('Classifieds');?></div>
  </div>
</div>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  
  <!-- The slug -->
  <?php if ($display_submitted): ?>
    <div class="meta submitted slug">
      <?php print $user_picture; ?>
      <?php 
      //kpr($content);
      print t('Category: ').$node->classified_category['und'][0]['taxonomy_term']->name
            .' | '. 
            t('Location: ').$node->field_ad_location['und'][0]['taxonomy_term']->name;
            ?>
      <br>
      <?php 
      print format_date($node->created, 'custom', 'l, j F Y').' | '.t('Submitted by ').$node->name;
      ?>
    </div>
  <?php endif; ?>

  <!-- The title -->
  <?php print render($title_prefix); ?>
          <h2 id="headline">
            <?php print $title; ?>
          </h2>
  <?php print render($title_suffix); ?>
  
  <!-- The image carousel -->
  <div class="row">
    <div class="col-lg-12">
      <?php print render($content['field_photo']); ?>
    </div>
  </div>  
  <!-- The body text -->
  <div class="row">
    <div class="col-lg-8">
      <?php print render($content['body']); ?>
    

  <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      //print render($content);
    ?>
  </div>

  <?php
    // Remove the "Add new comment" link on the teaser page or if the comment
    // form is being displayed on the same page.
    // Only display the wrapper div if there are links.
    $links = render($content['links']);
    if ($links):
  ?>
    <div class="link-wrapper">
      <?php print $links; ?>
    </div>
  <?php endif; ?>
	<?php
		// Implemented to show email address with ad author's name
		$ad_author_info = user_load($node->uid);
		$ad_author_email  = $ad_author_info->mail;
	?>
  
  <?php if (!user_is_logged_in()): ?>
  	<p class="classified_login_link">
      <?php print(t('If this is your listing !login_link to change or unpublish it.', array('!login_link' => l(t('Login'), "/user?destination=$node_url"))));?>
  	</p>
    <?php if (!($user->uid == $uid)): ?>
    <p><strong>Contact</strong> <a href="/user/<?php print $uid; ?>/contact?destination=<?php echo $node_url ?>"><?php print $name; ?></a> (<?php print $ad_author_email; ?>)</p>
    <?php endif; ?>

	<?php else:

      global $user;

      if ($user->uid == $uid):
        $iseek_ad_status = $node->workbench_moderation; ?>
        <div class="edit-classifieds">
          <div>
            <span class="classified-add">
              <a href="/node/<?php print $node->nid; ?>/edit" title="Edit your ad">Edit</a>
            </span>
            <?php if ($iseek_ad_status['current']->state == 'published'): ?> |
            <span class="classified-del"><a href="/node/<?php print $node->nid; ?>/moderation/<?php print $node->vid; ?>/unpublish" title="Unpublish your ad">Unpublish</a>
            </span>
          <?php endif; ?>
            <span>
              <?php
              // Print ad status for ad owner

              if (($iseek_ad_status['current']->state == 'needs_review') OR ($iseek_ad_status['current']->state == 'draft')): ?>
                | <span class="text-review"><i class="fa fa-refresh"></i> Under Review</span>
              <?php elseif ($iseek_ad_status['current']->state == 'published'): ?>
                | <span class="text-published"><i class="fa fa-globe"></i> Published</span>
              <?php elseif ($iseek_ad_status['current']->state == 'archived'): ?>
                | <span class="text-warning"><i class="fa fa-archive"></i> Archived</span>
              <?php endif; ?>
            </span>
          </div>
        </div>
      <?php
      else: 
			?>
			
        <p><strong><?php print(t('Contact'));?></strong> <a href="/user/<?php print $uid; ?>/contact?destination=<?php echo $node_url ?>"><?php print $name; ?></a> (<?php print $ad_author_email; ?>)</p>
        <p class="classified-add"><a href="/node/add/classified"><strong><?php print(t('Post an ad'));?></strong></a></p>
      <?php
      endif;
    endif; ?>

    <!-- For the comments: -->

    <hr>
      

          <?php if (flag_create_link('iseek_like', $node->nid)) { ?>
            <span id="iseek-likes"></span>
            <div class="iseek-like">
              <span>
                <i class="fa fa-thumbs-o-up"></i> 
                <?php print flag_create_link('iseek_like', $node->nid); ?>
              </span>
            </div>
          <?php } else { ?>
              <?php
                    if (!(user_is_logged_in()) && !($teaser)) {
                            $login_label = array('en' => 'Log in to post comments and like <i class="fa fa-thumbs-o-up"></i>', 'fr' => 'Identifiez-vous pour poster des commentaires & <i class="fa fa-thumbs-up"></i>');
                            $login_path = array('en' => '/user/login', 'fr' => '/fr/user/login');
              ?>
              <span id="iseek-likes"></span>
              <div class="iseek-like">
                      <span>
                              <a href="<?php print $login_path[$node->language]; ?>?destination=<?php print $node_url; ?>#comment-form"><?php print $login_label[$node->language]; ?></a> 
                      </span>
              </div>
              <?php
                    }
              ?>
            
          <?php } ?>

          <?php
          // Remove the "Add new comment" link on the teaser page or if the comment
          // form is being displayed on the same page.

          if ($teaser || !empty($content['comments']['comment_form'])) {
            // unset($content['links']['comment']['#links']['comment-add']);
            unset($content['links']['#links']['node-readmore']);
            unset($content['links']['node']['#links']['node-readmore']);
          }

          // remove translation links
              unset($content['links']['translation']);

          // Only display the wrapper div if there are links.
          $links = render($content['links']);

          if ($links):
          ?>
          <div class="link-wrapper">
            <ul class="links inline">
<!--
              <li class="comment-comments first">
                <a href="<?php print $node_url; ?>#comments"><?php if (isset($content['links']['#links']['comment-comments']['title'])) { print $content['links']['#links']['comment-comments']['title']; } ?></a>
              </li>

              <?php $flag = flag_get_flag('iseek_like');
                if (($flag->get_count($nid)) > 0): ?>
              <li>
                <div class="iseek-like-teaser">
                  <span><i class="fa fa-thumbs-up"></i>
                  <span class="flag-wrapper flag-iseek-like">
                      <?php print $flag->get_count($nid); ?>
                  </span>
                </div>
              </li>
              <?php endif; ?>

              <?php
              if (!(user_is_logged_in()) && !($teaser)) {
                $login_label = array('en' => 'Log in to post comments and like <i class="fa fa-thumbs-up"></i>', 'fr' => 'Identifiez-vous pour poster des commentaires & <i class="fa fa-thumbs-up"></i>');
                $login_path = array('en' => '/user/login', 'fr' => '/fr/user/login');
              ?>
              <li class="comment-add last">
                <a href="<?php print $login_path[$node->language]; ?>?destination=<?php print $node_url; ?>#comment-form"><?php print $login_label[$node->language]; ?></a>
              </li>
              <?php
              }
              ?>
-->
              <?php // Login prompt
              if (!(user_is_logged_in()) && ($teaser)): ?>
              <li>
                <?php
                  $login_label_teaser = array('en' => 'Log in to post comments and like', 'fr' => 'Connectez-vous pour poster un commentaire ou "J\'aime"');
                  $login_path_teaser = array('en' => '/user/login', 'fr' => '/fr/user/login');
                ?>

                  <a href="<?php print $login_path_teaser[$node->language]; ?>?destination=<?php print $node_url; ?>#comment-form"><?php print $login_label_teaser[$node->language]; ?></a>

              </li>
              <?php elseif ((user_is_logged_in()) && ($teaser)): ?>
              <li>
                <?php
                  $login_label_teaser = array('en' => 'Add a comment or like', 'fr' => 'Ajouter un commentaire ou "J\'aime"');
                  $login_path_teaser = array('en' => '/user/login', 'fr' => '/fr/user/login');
                ?>
                  <a href="<?php print $node_url; ?>#iseek-likes"><?php print $login_label_teaser[$node->language]; ?></a>
              </li>
              <?php endif; ?>
            </ul>

          </div>
          <?php endif; ?>

          <?php print render($content['comments']); ?>

        </div><!-- slug -->

        </div><!-- content -->
    </div>    

  </div>
</div>  

  <div class="row">
    <div class="col-lg-4">
      <!-- 4 columns of empty space here -->
    </div>
  </div>  

</div>