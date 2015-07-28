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
    </div> <!-- End comments -->