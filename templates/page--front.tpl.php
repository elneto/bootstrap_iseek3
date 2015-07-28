<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */

?>

<!-- begin common header -->

<?php include('sites/iseek.un.org/themes/bootstrap_iseek3/templates/common-header.tpl.php'); ?>

<!-- end common header -->


<!-- Stories, search, events, announcements -->
      <div class="row">
        <div class="col-md-5 col-md-push-7">

		<!-- gcd overlay -->
		<?php include('sites/iseek.un.org/themes/bootstrap_iseek3/templates/search_include.tpl.php'); ?>	
		<?php include('sites/iseek.un.org/themes/bootstrap_iseek3/templates/homepage_search.tpl.php'); ?>
		<!-- /gcd overlay -->	

 
          <h3 class="top-side-box main-boxes-margin">&nbsp;<i class="fa fa-calendar"></i>&nbsp;&nbsp;<a href="events-list/"><?php print t('Events');?> <i class="fa fa-angle-double-right"></i></a>
          <a data-toggle="collapse" data-target="#calendar-box" aria-expanded="true" aria-controls="calendar-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>
          </h3>
          <div id="calendar-box" class="collapse in">
		        <?php echo views_embed_view('events_block_for_home_page','block'); ?>	
            
          </div>
          <div class="content-large-text bottom-box-opacity-down hidden-xs"></div>
          <h3 class="top-side-box main-boxes-margin">&nbsp;<i class="fa fa-list-ul"></i>&nbsp;&nbsp;<a href="announcements-list/"><?php print t('Announcements');?> <i class="fa fa-angle-double-right"></i></a>
          <a data-toggle="collapse" data-target="#announcements-box" aria-expanded="true" aria-controls="announcements-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
          </h3>
          <div id="announcements-box" class="collapse in">
        		<?php 
        			// switch depending on domain 
        			// 555 
        			if (require_login_display_local('newyork')) {
        				echo views_embed_view('announcements_block_for_home_page','block');
        			// 131 	
        			} elseif (require_login_display_local('geneva')) {
        				echo views_embed_view('announcements_block_for_home_page','block_1');
        			// 60
        			} elseif (require_login_display_local('addisababa')) {
        				echo views_embed_view('announcements_block_for_home_page','block_2');
        			// 61
                                } elseif (require_login_display_local('bangkok')) {
        				echo views_embed_view('announcements_block_for_home_page','block_3');
        			// 62
                                } elseif (require_login_display_local('beirut')) { 
        				echo views_embed_view('announcements_block_for_home_page','block_4');
        			// 63
                                } elseif (require_login_display_local('nairobi')) {
        				echo views_embed_view('announcements_block_for_home_page','block_5');
        			// 64 
                                } elseif (require_login_display_local('santiago')) {
        				echo views_embed_view('announcements_block_for_home_page','block_6');
        			// 65 
                                } elseif (require_login_display_local('vienna')) { 
        				echo views_embed_view('announcements_block_for_home_page','block_7');
        			// external?
        			} else {
        				echo views_embed_view('announcements_block_for_home_page','block');
        			}
        		?>
            
          </div>
          <div class="content-large-text bottom-box-opacity-down hidden-xs"></div>
        </div>
        <!-- Stories -->
        <div class="col-md-7 col-md-pull-5">
          <h3 class="top-side-box top-boxes-margin">&nbsp;<i class="fa fa-newspaper-o"></i>&nbsp;&nbsp;<a href="<?php echo url('articles');?>"><?php print t('Staff stories and news');?> <i class="fa fa-angle-double-right"></i></a>
          <a data-toggle="collapse" data-target="#all-stories-cont" aria-expanded="true" aria-controls="all-stories-cont" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
          </h3>
          <div id="all-stories-cont" class="collapse in">
            <div id="container-main-image">

  		        <?php echo views_embed_view('staff_stories_and_news_main','block'); ?>

            </div>
            <div class="row">

  	           <?php echo views_embed_view('staff_stories_and_news_submain','block'); ?>		

              <div class="col-md-4 lpad5">
            
  	      <div id="thumbnail-most-popular" class="main-thumbnail">
                  <div id="most-popular-title"><?php print t('Most popular');?></div>
                  <?php
                          // uses nodequeue module
                          echo views_embed_view('nodequeue_3','block'); 
                  ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                	<div id="low-statement"><div class="arrow-right"></div>
          			<?php echo views_embed_view('staff_stories_and_news_miniarticles','block'); ?>
          		</div>
              </div>
            </div>
          
            <div class="row">
              <div class="col-md-12">
                <div class="bottom-staff-stories"><a href="<?php echo url('articles');?>"><?php print t('All staff stories and news');?> <i class="fa fa-angle-double-right"></i></a></div>
              </div>
            </div>
          </div>  <!-- All stories cont --> 
        </div> <!-- END Stories -->
        
      </div> <!-- END Stories, search, events, announcements -->

      <!-- Spotlight -->
      
      <div class="row">
        <div class="col-md-12">
          <h3 id="spotlight-box">&nbsp;<i class="fa fa-bullseye"></i>&nbsp;&nbsp;<?php print t('In the Spotlight');?>
          <a data-toggle="collapse" data-target="#spotlight-box-content" aria-expanded="true" aria-controls="spotlight-box-content" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
          </h3>
          <div class="row collapse in" id="spotlight-box-content">
          	<?php print render($spotlight); ?>
          </div>
        </div>
      </div>
      <!-- END Spotlight -->
     
      <!-- Submit -->
      <div class="row">
        <div class="col-lg-12 margin-submit">
          <div class="large-text submit-content">&nbsp;<i class="fa fa-pencil-square-o fa-lg"> </i>&nbsp;&nbsp;<a href="/content/submit-content"><?php print t('Submit content');?> <i class="fa fa-angle-double-right"></i></a> <span class="less-large"><span class="hidden-xs">&nbsp;&nbsp;<?php print t("Share your articles, stories, photos, TJO's, ads and more."); ?></span></span></div>
        </div>
      </div>
      <!-- END Submit -->
      <!-- News, Tips, Social Media -->
      <div class="row">      

        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-6"><div class="top-side-box large-text">&nbsp;<i class="fa fa-file-text-o"></i>&nbsp;&nbsp;
		<a href="https://www.unumoja.net">
			<?php print t('Umoja');?> <i class="fa fa-angle-double-right"></i>
		</a>
            <a data-toggle="collapse" data-target="#un-news-box" aria-expanded="true" aria-controls="un-news-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
            </div>
             <div class="un-news content-large-text collapse in" id="un-news-box"> 
                <?php echo views_embed_view('news_centre_block_for_home_page','block_2'); ?>
            </div>
              <div class="bottom-side-box content-large-text"></div>
            </div>
            <div class="col-md-6">
              <div class="top-side-box large-text">&nbsp;<i class="fa fa-lightbulb-o"></i>&nbsp;&nbsp;<a href="useful-tips/"><?php print t('Useful tips');?> <i class="fa fa-angle-double-right"></i></a>
              <a data-toggle="collapse" data-target="#tip-content-box" aria-expanded="true" aria-controls="tip-content-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
              </div>
              <div class="tip-content collapse in" id="tip-content-box">
              <!-- <img src="images/tweet-tip.png" class="img-responsive">
              <div class="content-large-text left">Latest Social Media Guidelines from the UN Social Media Team</div> -->
              <?php print render($useful_tips); ?>
              </div>
              <div class="bottom-side-box content-large-text"></div>
            </div>
          </div>
          <!-- temp and classified -->
          <div class="staff-box">
          <div class="row">
            <div class="col-md-6 bpad15 wborr">
                <h4 class="tjo"><a href="inspira-tjos"><?php print t('Temporary Job Openings');?> <i class="fa fa-angle-double-right"></i></a>
                <a data-toggle="collapse" data-target="#tjo-content-box" aria-expanded="true" aria-controls="tjo-content-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
                </h4>
                <div class="tjo-content content-large-text collapse in" id="tjo-content-box">
                      	<?php // print render($recent_tjos); 
				echo views_embed_view('news_centre_block_for_home_page','block_3');
			?>
                </div>

            </div>
            <div class="col-md-6 bpad15">
              <h4 class="classifieds"><a href="classified/"><?php print t('Classified ads');?> <i class="fa fa-angle-double-right"></i></a>
              <a data-toggle="collapse" data-target="#classifieds-box" aria-expanded="true" aria-controls="classifieds-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
              </h4>
                <div class="classifieds-content content-large-text collapse in" id="classifieds-box">
                    <?php print render($latest_zeekoslist); ?>
                </div>
            </div>
          </div>

          <!-- staff union and comm -->
          <div class="row">
            <div class="col-md-6 wborr">
                <h4 class="staffunion"><a href="staff-union/"><?php print t('Staff Union');?> <i class="fa fa-angle-double-right"></i></a>
                <a data-toggle="collapse" data-target="#staffu-box" aria-expanded="true" aria-controls="staffu-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
                </h4>
                <div class="staffunion-content content-large-text collapse in" id="staffu-box">
                    <?php print render($staff_union_block); ?>
                </div>
            </div>
            <div class="col-md-6">
              <h4 class="community"><?php print t('Community');?> 
              <a data-toggle="collapse" data-target="#commu-box" aria-expanded="true" aria-controls="commu-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
              </h4>
                <div class="community-content content-large-text collapse in" id="commu-box">
                    <?php print $menu_community; ?>
                </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-lg-4">
          <h3 class="top-side-box nohoverfx">&nbsp;<i class="fa fa-rss"></i>&nbsp;&nbsp;<?php print t('Social media corner');?>
          <a data-toggle="collapse" data-target="#socialmedia-box" aria-expanded="true" aria-controls="socialmedia-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
          </h3>
          <div class="twitter-border fluid collapse in" id="socialmedia-box">
              <!-- <?php print render($social_media_corner); ?> -->
		<p><a class="twitter-timeline" data-chrome="nofooter noborders" data-widget-id="590192526923063296" height="670" href="https://twitter.com/UN" width="100%">Tweets by @UN</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></p>	
          </div>
        <div class="large-text social"> <a href="<?php print t('http://www.facebook.com/unitednations');?>" target="_blank"><i class="fa fa-facebook-square fa-2x facebook"></i></a> <a href="<?php print t('http://twitter.com/#!/un');?>"><i class="fa fa-twitter-square fa-2x twitter"></i></a> <a href="<?php print t('http://www.youtube.com/unitednations');?>"><i class="fa fa-youtube-square fa-2x youtube"></i></a> <a href="<?php print t('http://gplus.to/unitednations');?>"><i class="fa fa-google-plus-square fa-2x googleplus"></i></a> <a href="<?php print t('http://instagram.com/unitednations');?>"><i class="fa fa-instagram fa-2x instagram"></i></a> </div>
        </div>
  
      </div>

<!-- Time zone and weather -->
<!-- We override weather.tpl.php in the templates folder -->
<?php echo $weather; ?>
<!-- Ends: Time zone and weather -->

<!-- begin common footer -->

<?php include('sites/iseek.un.org/themes/bootstrap_iseek3/templates/common-footer.tpl.php'); ?>

<!-- end common footer -->
