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

//kpr($variables);

?>


<div id="top-bar">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-6 hidden-xs">
				<!-- eric: base_url needs to be i18n and domain aware: is not currently -->
				<img src="/sites/iseek.un.org/themes/bootstrap_iseek3/images/un-logo-top.png" border="0" id="un-top-logo" alt="United Nations logo"><a class="top-nav-item" href="<?php echo $GLOBALS['base_url']; ?>">Welcome to the United Nations Intranet</a>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6">
				<a class="top-nav-item" href="#">Low bandwidth | High contrast</a>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6">
				<?php
					$login_block = module_invoke('user', 'block_view', 'login');
					print render($login_block['content']);
                                        $user_menu_block = module_invoke('system', 'block_view', 'user-menu');
                                        print render($user_menu_block['content']);
				?>

<!--
				<span class="top-nav-item">Login</span>
				<input type="text" id="login-name" name="login-name" placeholder="Name">
				<input type="password" id="login-password" name="login-password" placeholder="Password">
				<button name="login-go" class="btn" id="go-button">GO <i class="fa fa-angle-double-right"></i></button>
-->
			</div>
			<div class="col-lg-2 col-md-6 col-sm-6">
                                <?php
                                        $block = module_invoke('locale', 'block_view', 'language');
                                        print render($block['content']);
                                ?>				
				<?php // print render($page['header']); ?>
			</div>
		</div>
	</div>
</div>

<!-- Main container -->
<div class="container">

	<div class="row">
		<div class="col-md-3 col-xs-6">
			<div class="row">
				<div class="col-md-10 col-xs-12">
					<a href="#">
						<img src="<?php print $logo; ?>" onerror="this.onerror=null; this.src='images/iseek-logo.png'" border="0" class="img-responsive img-logo-banner" alt="iseek logo" width="225"/>
					</a>
				</div>
				<div class="col-md-2 hidden-xs">
					<div id="banner-separation"></div>
				</div>
			</div>
		</div>
		<div class="col-md-7 col-xs-6">
			<div class="navbar-default" id="location-navbar">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span id="location-display">New York</span> <span class="caret"></span></a>
						<ul id="ul-location" class="dropdown-menu" role="menu">
							<li><a href="#">Addis Ababa</a></li>
							<li><a href="#">Bangkok</a></li>
							<li><a href="#">Beirut</a></li>
							<li><a href="#">Geneva</a></li>
							<li><a href="#">Nairobi</a></li>
							<li><a href="#">New York</a></li>
							<li><a href="#">Santiago</a></li>
							<li><a href="#">Vienna</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div>
		<div class="col-md-2 visible-md visible-lg">
			<img src="/sites/iseek.un.org/themes/bootstrap_iseek3/images/un-70.svg" onerror="this.onerror=null; this.src='/sites/iseek.un.org/themes/bootstrap_iseek3/images/un-70.png'" border="0" class="img-responsive img-logo-banner" alt="UN 70 logo" width="145">
		</div>
	</div>






</div>
<!-- /Main container -->

<div class="main-container container">

	<div class="row">

	<div class="col-sm-10">

		<?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['navigation'])): ?>
		  <div class="navbar-collapse collapse">
			<nav role="navigation">
			  <?php if (!empty($primary_nav)): ?>
				<?php print render($primary_nav); ?>
			  <?php endif; ?>
			  <?php if (!empty($secondary_nav)): ?>
				<?php print render($secondary_nav); ?>
			  <?php endif; ?>
			  <?php if (!empty($page['navigation'])): ?>
				<?php print render($page['navigation']); ?>
			  <?php endif; ?>
			</nav>
		  </div>
		<?php endif; ?>

	</div>

	
	<!-- <div class="col-sm-2 col-xs-12">
		<?php //print render($page['header']); //do we need this region? ?>
	</div> -->

  </div>
<!-- Urgent message -->
  	<div class="row">
		<div class="col-md-12">
		  <div class="alert alert-danger urgent-message" role="alert">
		    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		    <span class="sr-only">Urgent message:</span>
		    Urgent Message
		  </div>
		</div>
    </div>
<!-- Stories, search, events, announcements -->
      <div class="row">
        <div class="col-md-5 col-md-push-7">
            <h3 class="top-side-box nohoverfx top-boxes-margin">&nbsp;<i class="fa fa-search"></i>&nbsp;&nbsp;Search</h3>
            <div id="search-box">
            <form id="search-form">
              <div class="row">
                <div class="col-xs-12">
                  <label for="input-find-colleague">Find a colleague<span class="hidden-xs">... by name, department and more</span></label> <!--placeholder="Find a colleague"!--> 
                </div>
                <div class="col-lg-10 col-xs-9 search-rpad0">
                  <input type="text" name="find-colleague" class="search-input" id="input-find-colleague">
                </div>
                <div class="col-lg-2 col-xs-3 search-lpad0">
                  <button name="Search" class="search-button">Search</button>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <label for="input-search-iseek">Search iSeek or ODS</label> <!-- placeholder="Search the UN Intranet or ODS"  !-->
                </div>
                <div class="col-lg-8 col-md-7 col-xs-6 search-rpad0">
                  <input type="text" name="search-intranet" class="search-input" id="input-search-iseek">
                </div>
                <div class="col-lg-2 col-md-2 col-xs-3 search-lpad0 search-rpad0">
                  <select id="select-search" class="search-input">
                    <option>iSeek</option>
                    <option>ODS</option>
                  </select>
                </div>
                <div class="col-lg-2 col-md-3 col-xs-3 search-lpad0">
                  <button name="Search" class="search-button">Search</button>
                </div>
              </div>
              <div class="row ">
                <div class="col-md-12">
                  <div id="search-links">
                  <a href="#">Update my Information</a>  |
                  <a href="#">Advanced Search</a>  |
                  <a href="#">Additional Resources</a></div>
                </div>
              </div>
              
            </form>
          </div>
          
          <h3 class="top-side-box main-boxes-margin">&nbsp;<i class="fa fa-calendar"></i>&nbsp;&nbsp;<a href="#">Calendar of events <i class="fa fa-angle-double-right"></i></a></h3>
          <div id="calendar-box">
            <ul id="calendar-list">
              <li><span class="calendar-date">08 MAR</span><a href="#">International Women's Day UN observances</a></li>
              <li><span class="calendar-date">17 MAR</span><a href="#">St. Patrick's Day Holiday</a></li>
              <li><span class="calendar-date">20 MAR</span><a href="#">International Day of Happiness</a></li>
              <li><span class="calendar-date">24 OCT</span><a href="#">UN Day Celebration</a></li>
              <li><span class="calendar-date">08 MAR</span><a href="#">International Women's Day UN observances</a></li>
              <li><span class="calendar-date">17 MAR</span><a href="#">St. Patrick's Day Holiday</a></li>
              <li><span class="calendar-date">20 MAR</span><a href="#">International Day of Happiness</a></li>
              <li><span class="calendar-date">24 OCT</span><a href="#">UN Day Celebration</a></li>
            </ul>
          </div>
          
          <h3 class="top-side-box main-boxes-margin">&nbsp;<img src="images/announcements.png" border="0" alt="announcements icon" class="icon-top-bar"/>&nbsp;&nbsp;<a href="#">Announcements <i class="fa fa-angle-double-right"></i></a></h3>
          <div id="announcements-box">
            <ul id="announcements-list">
              <li><a href="#">Client Service at the Health &amp; Life Insurance Section</a></li>
              <li><a href="#">Commemoration of Human Rights Day, 9 December</a></li>
              <li><a href="#">Edward Elgar Ebooks online! Should the Library buy them?</a></li>
              <li><a href="#">Seasonal Flu Vaccine Campaign starts Friday, 21 November</a></li>
              <li><a href="#">Special Event of the GA Second Committee: ICT and E-Gov</a></li>
              <li><a href="#">Gym memberships at all time low</a></li>
            </ul>
            </div>
        </div>
        <!-- Stories -->
        <div class="col-md-7 col-md-pull-5">
          <h3 class="top-side-box top-boxes-margin">&nbsp;<i class="fa fa-newspaper-o"></i>&nbsp;&nbsp;<a href="#">Staff stories and news <i class="fa fa-angle-double-right"></i></a></h3>
          <div id="container-main-image">
            <img src="images/img16x9.jpg" border="0" id="image-main-story" class="img-responsive" alt="alternate text for main image"/>
            <div id="caption-mi">
              <a href="#">
                <div id="caption-mi-title">Secretary-General Holds UN Town Hall Meeting in Panama City</div>
                <div id="caption-mi-date">Friday, 24 April 2015</div>
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 rpad5">
              <div class="main-thumbnail">
                <img src="images/thumb1.jpg" border="0" alt="alternate text"/>
                <a href="#">Secretary-General meets staff at ECLAC’s headquarters</a>
              </div>
            </div>
            <div class="col-md-4 lpad5 rpad5">
              <div class="main-thumbnail lpad0 rpad0">
                <img src="images/thumb2.jpg" border="0" alt="alternate text"/>
                <a href="#">DPKO-DFS Field Occupational Safety Risk Management: Workplace Safety Training Video</a>
              </div>
            </div>
            <div class="col-md-4 lpad5">
              <div id="thumbnail-most-popular" class="main-thumbnail">
                <div id="most-popular-title">Most popular</div>
                <img src="images/thumb3.jpg" border="0" alt="alternate text"/>
                <a href="#">Snow hampers relief efforts this can go to three lines with more text</a>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div id="low-statement"><div class="arrow-right"></div><a href="#">SG travels to Mali</a></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="bottom-staff-stories"><a href="#">All staff stories and news <i class="fa fa-angle-double-right"></i></a></div>
            </div>
          </div>
        </div> <!-- END Stories -->
        
      </div> <!-- END Stories, search, events, announcements -->

      <!-- Spotlight -->
      
      <div class="row">
        <div class="col-md-12 zindex99">
          <h3 id="spotlight-box">&nbsp;<i class="fa fa-bullseye"></i>&nbsp;&nbsp;In the Spotlight</h3>
          <div class="row">
            <div class="col-md-4 rpad0">
              <div class="spotlight-thumbnail">
                <img src="images/spot1.png" border="0" alt="alternate text" class="img-responsive" width="375" height="211">
                <a href="#">Title</a>
              </div>
            </div>
            <div class="col-md-4 lpad75 rpad75">
              <div class="spotlight-thumbnail">
                <img src="images/spot2.jpg" border="0" alt="alternate text" class="img-responsive" width="375" height="211">
                <a href="#">Title</a>
              </div>
            </div>
            <div class="col-md-4 lpad0">
             <div class="spotlight-thumbnail">
                <!--<img src="images/spot3.jpg" border="0" alt="alternate text" class="img-responsive">-->
                <div class="embed-responsive embed-responsive-16by9">
                  <video controls width="375" height="211"> 
                    <source src="videos/small.ogv" type="video/ogg"> 
                    <source src="videos/small.mp4" type="video/mp4">
                  </video>
                </div>
                <a href="#">Title</a>
              </div>
            </div>
          </div>

          <!-- <div class="col-md-4"><h3 class="bb">Pic 1</h3>title</div>
          <div class="col-md-4"><h3 class="bb">Pic 2</h3>title</div>
          <div class="col-md-4"><h3 class="bb">Pic 3</h3>title</div> -->
        </div>
      </div>
      <!-- END Spotlight -->
     
      <!-- Submit -->
      <div class="row">
        <div class="col-lg-12 margin-submit">
          <div class="large-text submit-content">&nbsp;<i class="fa fa-pencil-square-o fa-lg"> </i>&nbsp;&nbsp;<a href="#">Submit content <i class="fa fa-angle-double-right"></i></a> <span class="less-large"><span class="hidden-xs">&nbsp;&nbsp;Share your articles, stories, photos, TJO's, ads and more.</span></span></div>
        </div>
      </div>
      <!-- END Submit -->
     <!-- ******************************************************************************************************
        * From here down is for Husain and up for Ernesto
        *********************************************************************************************************
      !-->
      <!-- News, Tips, Social Media -->
      <div class="row">      

        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-6"><div class="top-side-box large-text">&nbsp;<i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<a href="">UN in the news <i class="fa fa-angle-double-right"></i></a></div>
             <div class="un-news">
              <ul class="content-large-text">
                <li><a href="">'41 missing' in new Mediterranean migrant boat tragedy</a></li>
                <li><a href="">Over 30 reported killed in Saudi-led air raids in Yemen</a></li>
                <li><a href="">Guinea finds nine new Ebola cases near border with Sierra Leone</a></li>
                <li><a href="">Fresh anti-immigrant clashes in South Africa as Zuma condemns violence</a></li>
              </ul>
            </div>
              <div class="bottom-side-box content-large-text"></div>
            </div>
            <div class="col-md-6">
              <div class="top-side-box large-text">&nbsp;<i class="fa fa-lightbulb-o"></i>&nbsp;&nbsp;<a href="">Useful tips <i class="fa fa-angle-double-right"></i></a></div>
              <div class="tip-content"><img src="images/tweet-tip.png" class="img-responsive">
              <!--h5 class="bottom-side-box medium-text">More <i class="fa fa-caret-down"></i></h5-->
              <div class="content-large-text left">Latest Social Media Guidelines from the UN Social Media Team</div>
              </div>
              <div class="bottom-side-box content-large-text"></div>
            </div>
          </div>
          <!-- temp and classified -->
          <div class="staff-box">
          <div class="row">
            <div class="col-md-6 bpad15 wborr">
                <h4 class="tjo"><a href="">Temporary Job Openings <i class="fa fa-angle-double-right"></i></a></h4>
                <div class="tjo-content content-large-text">
                      <?php print render($recent_tjos); ?>
                </div>

            </div>
            <div class="col-md-6 bpad15">
              <h4 class="classifieds"><a href="">Classified ads <i class="fa fa-angle-double-right"></i></a></h4>
                <div class="classifieds-content content-large-text">
                    <?php print render($latest_zeekoslist); ?>
                </div>
            </div>
          </div>

          <!-- staff union and comm -->
          <div class="row">
            <div class="col-md-6 wborr">
                <h4 class="staffunion"><a href="">Staff Union <i class="fa fa-angle-double-right"></i></a></h4>
                <div class="staffunion-content content-large-text">
                    <?php print render($staff_union_block); ?>
                </div>
            </div>
            <div class="col-md-6">
              <h4 class="community"><a href="">Community <i class="fa fa-angle-double-right"></i></a></h4>
                <div class="community-content content-large-text">
                    <?php print $menu_community; ?>
                </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-lg-4">
          <h3 class="top-side-box nohoverfx">&nbsp;<i class="fa fa-rss"></i>&nbsp;&nbsp;Social media corner</h3>
          <div class="twitter-border fluid">
              <?php print render($social_media_corner); ?>
          </div>
        <div class="large-text social"> <a href=""><i class="fa fa-facebook-square fa-2x facebook"></i></a> <a href=""><i class="fa fa-twitter-square fa-2x twitter"></i></a> <a href=""><i class="fa fa-youtube-square fa-2x youtube"></i></a> <a href=""><i class="fa fa-google-plus-square fa-2x googleplus"></i></a> <a href=""><i class="fa fa-instagram fa-2x instagram"></i></a> </div>
        </div>
  
      </div>

<!-- Time zone and weather -->
<!-- We override weather.tpl.php in the templates folder -->
<?php echo $weather; ?>
<!-- Ends: Time zone and weather -->
