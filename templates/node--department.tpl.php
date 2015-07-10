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


$menu_name = "";
$menu_display_name = "";
$query_menu_result = db_query(
        "SELECT menu_name FROM {og_menu} WHERE gid = :gid LIMIT 1",    
        array(':gid' => $node->nid)
);

if ($query_menu_result) {
        while ($row = $query_menu_result->fetchAssoc()) {
                $menu_name = $row['menu_name'];
		$menu_display_name = menu_load($menu_name)['title'];	
        }
}

$divisions_menu_array = menu_navigation_links($menu_name);

// kpr($node);
// kpr($content);

$field_departmental_theme_value = "";

if (count($node->field_departmental_theme)) {
	$field_departmental_theme_value = $node->field_departmental_theme['und'][0]['value']; 	
}

$taxonomy_term_array = taxonomy_get_term_by_name($node->title, "departments");

$taxonomy_id = key($taxonomy_term_array);

// get the parents

$full_parent_taxonomy_array = taxonomy_get_parents_all($taxonomy_id);

$depts_vid = 22;

$dept_site_map_array = array();
$ultimate_parent_name = "";

if ($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->name == 'Secretariat') {
        $dept_site_map_array = taxonomy_get_tree($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->vid, $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->tid);
        $ultimate_parent_name = $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->name;
} else {
        $dept_site_map_array = taxonomy_get_tree($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->vid, $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->tid);
        $ultimate_parent_name = $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->name;
}

include('departmental_color_band.inc');

?>

<div class="row">
       	<div class="col-lg-12">
      		<div class="toolkit large-text" id="toolkit-anchor">&nbsp;<?php echo $node->title; ?></div>
	</div>
	<div class="col-lg-12">
                <div class="dept-color-band" style="background-color: <?php echo $dept_color_band ?>;"></div>
        </div>
</div>

<div class="row departmentalSubmenu">
        <div class="col-lg-12">
		<ul class="departmentalSubmenu-nav">
			<li class="first expanded dropdown">
				<span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><i class="fa fa-link"></i> Quicklinks <span class="caret"></span></span>
				<?php print views_embed_view('departmental_page_in_og', 'block', $node->nid); ?>
			</li>
			<li><span data-toggle="modal" data-target="#deptSiteMapModal"><i class="fa fa-list-alt"></i> Site map</span></li>
			<?php 
				if ($menu_display_name) {
			?>
	
					<li class="expanded dropdown">
						<span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><i class="fa fa-sign-in"></i> <?php echo $menu_display_name ?> <span class="caret"></span></span>
						<ul class="dropdown-menu">
							<?php
								foreach ($divisions_menu_array as $divisions_menu_array_item) { 
									echo "<li class=\"leaf\"><a href=\"/" . drupal_get_path_alias($divisions_menu_array_item['href']) . "\">" . $divisions_menu_array_item['title'] . "</a></li>";
								}	
							?>
						</ul>		
					</li>
			<?php 	} ?>
		
			<?php print views_embed_view('departmental_faq_in_og', 'block', $node->nid); ?>
			<?php
				if (count($node->field_departmental_contact_us)) {
			?>	
					<li><a href="<?php echo $node->field_departmental_contact_us['und'][0]['safe_value'] ?>"><i class="fa fa-phone-square"></i> Contact us</a></li>
			<?php
				}
			?>
		</ul>
	</div>
</div>

<div>
<?php

$taxonomy_term_array = taxonomy_get_term_by_name($node->title, "departments");

$taxonomy_id = key($taxonomy_term_array);

// get the parents

$full_parent_taxonomy_array = taxonomy_get_parents_all($taxonomy_id);

$depts_vid = 22;

$dept_site_map_array = array();
$ultimate_parent_name = "";

if ($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->name == 'Secretariat') {
	$dept_site_map_array = taxonomy_get_tree($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->vid, $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->tid);
	$ultimate_parent_name = $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->name;	
} else {
	$dept_site_map_array = taxonomy_get_tree($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->vid, $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->tid);
	$ultimate_parent_name = $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->name;
}

// kpr($dept_site_map_array);	


?>


<div class="modal fade" id="deptSiteMapModal" tabindex="-1" role="dialog" aria-labelledby="deptSiteMapModal" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content"> 
   <div class="modal-header">
	Site map
   </div>
   <div class="modal-post-header">
	<button type="button" class="close" data-dismiss="modal">Close <span aria-hidden="true">×</span></button>
   </div>
   <div class="modal-body">

     	<ul class="dept_site_map">
	
	<?php
	// first add the parent
                $ultimate_parent_query = new EntityFieldQuery();
                $ultimate_parent_entities = $ultimate_parent_query->entityCondition('entity_type', 'node')
                ->propertyCondition('type', 'department')
                ->propertyCondition('title', $ultimate_parent_name)
                ->propertyCondition('status', 1)
                ->range(0,1)
                ->execute();

                    $strong_start = "";     
                    $strong_end = "";
                    if ($node->title == $ultimate_parent_name) {
                            $strong_start = "<strong>";
                            $strong_end = "</strong>";
                    }


                if (!empty($ultimate_parent_entities['node'])) {
                        $child_node = node_load(array_shift(array_keys($ultimate_parent_entities['node'])));
        ?>
                                <li class="depth0"><a href="<?php print url("node/" . $child_node->nid) ?>"><?php echo $strong_start; ?><?php print $ultimate_parent_name; ?><?php echo $strong_end; ?></a></li>
                <?php
                } else {
                ?>
                                <li class="depth0"><?php print $ultimate_parent_name; ?></li>
                <?php
                }

	?>

 	<?php
	foreach ($dept_site_map_array as $dept_site_map_array_item) {
	?>
		<li class="depth<?php echo ($dept_site_map_array_item->depth + 1); ?>">	

		<?php	
			$dept_site_map_query = new EntityFieldQuery();
			$dept_site_map_entities = $dept_site_map_query->entityCondition('entity_type', 'node')
			->propertyCondition('type', 'department')
			->propertyCondition('title', $dept_site_map_array_item->name)
			->propertyCondition('status', 1)
			->range(0,1)
			->execute();

			$strong_start = "";	
			$strong_end = "";
			if ($node->title == $dept_site_map_array_item->name) {
				$strong_start = "<strong>";
				$strong_end = "</strong>";
			}


			if (!empty($dept_site_map_entities['node'])) {
				$child_node = node_load(array_shift(array_keys($dept_site_map_entities['node'])));

					
		?>
			                <a href="<?php print url("node/" . $child_node->nid) ?>"><?php echo $strong_start; ?><?php print $dept_site_map_array_item->name; ?><?php echo $strong_end; ?></a>
			<?php
			} else {
			?>
			                <?php echo $strong_start; ?><?php print $dept_site_map_array_item->name; ?><?php echo $strong_end; ?>
			<?php
			}
			?>		

		</li>	
	<?php
	}
	?>
	  </ul>
	</div>
	<div class="modal-footer">
		
	</div>
  </div>
 </div>
</div>



<div class="row">
	<div class="col-sm-12">



                    <div class="departmental_page_breadcrumb">

                    <?php

                            $taxonomy_term_array = taxonomy_get_term_by_name($node->title, "departments");

                            $taxonomy_id = key($taxonomy_term_array);

                            $taxonomy_parents_array = taxonomy_get_parents_all(key($taxonomy_term_array));

                            // reverse sort for display purposes
                            krsort($taxonomy_parents_array);

                            $i = 1;

                            foreach ($taxonomy_parents_array as $parent) {
                                    //$parent->tid

                                    // get path based on name

                                    $query = new EntityFieldQuery();
                                    $breadcrumb_entities = $query->entityCondition('entity_type', 'node')
                                            ->propertyCondition('type', 'department')
                                            ->propertyCondition('title', $parent->name)
                                            ->propertyCondition('status', 1)
                                            ->range(0,1)
                                            ->execute();

                                    if (!empty($breadcrumb_entities['node'])) {
                                            $breadcrumb_node = node_load(array_shift(array_keys($breadcrumb_entities['node'])));
                                    ?>

                                            <a href="<?php print url("node/" . $breadcrumb_node->nid) ?>"><?php print $parent->name; ?></a>
                                    <?php

                                    } else {

                                            print $parent->name ;

                                    }

                                    if ($i < count($taxonomy_parents_array)) {
                                            print " &gt; ";
                                    }

                                    $i++;
                            }
                    ?>

                    </div>

	</div>
</div>

<?php

if ($field_departmental_theme_value == "") {

		if (isset($node->field_home_page['und'][0]['entity']->body['und'][0]['value'])) {

			print($node->field_home_page['und'][0]['entity']->body['und'][0]['safe_value']);
			
		} else {
			$homepage_title = $node->title . " Homepage";

			$query = new EntityFieldQuery();
			$entities = $query->entityCondition('entity_type', 'node')
			->propertyCondition('type', 'departmental_page')
			->propertyCondition('title', $homepage_title)
			->propertyCondition('status', 1)
			->range(0,1)
			->execute();	

			if (!empty($entities['node'])) {
				$homepage_node = node_load(array_shift(array_keys($entities['node'])));
				
				print($homepage_node->body['und'][0]['safe_value']);

			}

		}

} else {
?>

	<div class="row" id="department-about-us-for-department-home-page">
	        <div class="col-md-6">

				<div id="departmental_about_us_carousel" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
					<?php 
	/*
	                                	$i = 0;
	                                	foreach ($content['field_departmental_about_us_imag']['#items'] as $about_us_image) { 
	                       	        ?>
							<li data-target="#departmental_about_us_carousel" data-slide-to="<?php echo $i ?>" <?php if ($i == 0) { echo "class=active"; } ?>></li>
	                          <?php 
	                                        	$i++;

	                               		} 
	*/
	                          ?>   
				  </ol>

				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" role="listbox">

				  <?php 
					$i = 0;	
					foreach ($content['field_departmental_about_us_imag']['#items'] as $about_us_image) { 
				?> 


				    		<div class="item <?php if ($i == 0) { echo "active"; } ?>">
							<img src="<?php print image_style_url('large-article-image-style-16-9', $about_us_image['uri']); ?>" />
				      			<div class="carousel-caption">
								<h3><?php echo $about_us_image['field_caption']['und'][0]['value']; ?> </h3>
				      			</div>
				    		</div>

				  <?php 
						$i++;
					} 
				  ?>

				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#departmental_about_us_carousel" role="button" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#departmental_about_us_carousel" role="button" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
	        </div>
	        <div class="col-md-6">
	                <h2>About us <?php // print render($content['field_departmental_about_us_labe']); ?></h2>
	                <div class="dept_about_us_body"><?php print render($content['field_departmental_about_us_body']); ?></div>
			<div>
				<?php if (count($node->field_departmental_about_us_link)) { ?>
					<a href="<?php echo $node->field_departmental_about_us_link['und'][0]['display_url']; ?>">Read more</a>
				<?php } ?>
			</div>
	                <?php if (count($node->field_departmental_organigram)) { ?>
	                        <div class="text-right" id="department_organigram"><a href="<?php print file_create_url($node->field_departmental_organigram['und'][0]['uri']); ?>"><i class="fa fa-sitemap"></i> Organigramme</a></div>
	                <?php } ?>

	        </div>
	</div>

<?php
	if ($field_departmental_theme_value == "sub") {
?>		

	<div class="row" id="departmental_home_page_blocks">
		<div class="col-md-4" id="col1">

			<div class="row">	

				<!-- bio -->	
				<div class="col-md-12">
					<h4><?php echo $node->field_departmental_bio_label['und'][0]['value'] ; ?></h4>
					<div class="departmental_home_page_block_fixed_container" id="bio">
						<?php // print views_embed_view('department_bio_for_department_home_page', 'block', $node->nid); ?>		
						<div class="row">
	        					<div class="col-md-12">
	                					<div class="media">
	                        					<div class="media-left">
										<?php print render($content['field_departmental_bio_image']) ; ?>
	                        					</div>
	                        					<div class="media-body">
	                                					<h5 class="media-heading"><?php print $node->field_departmental_bio_image_cap['und'][0]['value']; ?></h5>
	                                					<div id="field_departmental_bio_image_des"><?php print $node->field_departmental_bio_image_des['und'][0]['value']; ?></div>
	                                					<div id="field_departmental_home_page_bod"><?php print $node->field_departmental_bio_body['und'][0]['value']; ?></div>
	                        					</div>
	                					</div>
	        					</div>
						</div>	
					</div>
					<div class="departmental_home_page_block_bottom">
						<?php if (count($node->field_departmental_bio_link)) { ?>
							<a href="<?php print $node->field_departmental_bio_link['und'][0]['url']; ?>">Read more</a>
						<?php } ?>
					</div>	
				</div>	

				<!-- highlights -->	
                <div class="col-md-12">
                    <h4>Highlights</h4>
					<div class="departmental_home_page_block_fixed_container">
						<?php print views_embed_view('departmental_news_in_og', 'block', $node->nid); ?>
						<?php print views_embed_view('departmental_news_in_office', 'block', $node->field_departmental_offices_for_f['und'][0]['tid'] ); ?>
					</div>
					<div class="departmental_home_page_block_bottom">Read more</div>	
                </div>


			</div>		

		</div>
		<div class="col-md-4"  id="col1">

			<!-- what we do -->	
            	<h4>What we do</h4>
						
						<?php echo $node->field_departmental_what_we_do['und'][0]['value'] ; ?>
					<div class="departmental_home_page_block_bottom">
						<?php if (count($node->field_departmental_what_we_do_li)) { ?>
                                <a href="<?php print $node->field_departmental_what_we_do_li['und'][0]['url']; ?>">Read more</a>
                        <?php } ?>
					</div> 
			

		</div>
		<div class="col-md-4"  id="col1">

			<!-- resources -->	
					<h4>Resources</h4>
					<div class="departmental_home_page_resources_section">	
						<?php echo $node->field_departmental_resources['und'][0]['value'] ; ?>
					</div>
					<div class="departmental_home_page_block_bottom">
						<?php if (count($node->field_departmental_resources_lin)) { ?>
                        				<a href="<?php print $node->field_departmental_resources_lin['und'][0]['url']; ?>">Read more</a>
                       				<?php } ?>
					</div>
        </div>
	</div>	

<?php
	} elseif ($field_departmental_theme_value == "top") {
?>


		<div class="row" id="departmental_home_page_blocks">
		        <div class="col-md-4" id="col1">
				<div class="row">
					<div class="col-md-12">
						<h4><?php echo $node->field_departmental_bio_label['und'][0]['value'] ; ?></h4>
						<div class="departmental_home_page_block_fixed_container" id="bio">
							<?php // print views_embed_view('department_bio_for_department_home_page', 'block', $node->nid); ?>		
							
		                					<div class="media">
		                        					<div class="media-left">
											<?php print render($content['field_departmental_bio_image']) ; ?>
		                        					</div>
		                        					<div class="media-body">
		                                					<h5 class="media-heading"><?php print $node->field_departmental_bio_image_cap['und'][0]['value']; ?></h5>
		                                					<div id="field_departmental_bio_image_des"><?php print $node->field_departmental_bio_image_des['und'][0]['value']; ?></div>
		                                					<div id="field_departmental_home_page_bod"><?php print $node->field_departmental_bio_body['und'][0]['value']; ?></div>
		                        					</div>
		                			
							</div>	
						</div>
						<div class="departmental_home_page_block_bottom">
							<?php if (count($node->field_departmental_bio_link)) { ?>
								<a href="<?php print $node->field_departmental_bio_link['und'][0]['url']; ?>">Read more</a>
							<?php } ?>
						</div>	
					</div>	
				</div>
                <div class="row">
					<div class="col-md-12">
		               			<h4>What we do</h4>
						<div class="departmental_home_page_block_fixed_container">	
							<?php echo $node->field_departmental_what_we_do['und'][0]['value'] ; ?>
						</div>
						<div class="departmental_home_page_block_bottom">
							<?php if (count($node->field_departmental_what_we_do_li)) { ?>
                                    <a href="<?php print $node->field_departmental_what_we_do_li['und'][0]['url']; ?>">Read more</a>
                            <?php } ?>
						</div> 
					</div>
                </div>

			</div>
			<div class="col-md-4"  id="col1">
				<div class="row">
                    <div class="col-md-12">
                        <h4>Highlights</h4>
						<div class="departmental_home_page_block_fixed_container">
							<?php print views_embed_view('departmental_news_in_og', 'block', $node->nid); ?>
							<?php print views_embed_view('departmental_news_in_office', 'block', $node->field_departmental_offices_for_f['und'][0]['tid'] ); ?>
						</div>
						<div class="departmental_home_page_block_bottom">Read more</div>	
		                        </div>
		                </div>
		                <div class="row">
		                        <div class="col-md-12">
		                                <h4><?php echo $node->field_departmental_where_label['und'][0]['value'] ; ?></h4>
						<?php if (count($node->field_departmental_where_image)) { ?>
							<a href="<?php echo $node->field_departmental_where_link['und'][0]['url'] ; ?>">
								<img src="<?php print image_style_url('large-article-image-style-16-9', $content['field_departmental_where_image']); ?>" />
		                                                <?//php print render($content['field_departmental_where_image']) ; ?>
		                                        </a>
							<div class="departmental_home_page_block_bottom"><a href="<?php echo $node->field_departmental_where_link['und'][0]['url'] ; ?>">Read more</a></div>	
						<?php } else { ?>
							<div class="departmental_home_page_block_fixed_container">
								<?php print render($content['field_departmental_where_body']) ; ?>
							</div>
							<div class="departmental_home_page_block_bottom"><a href="<?php echo $node->field_departmental_where_link['und'][0]['url'] ; ?>">Read more</a></div>
						<?php } ?>

                    </div>
                </div>
			</div>
			<div class="col-md-4"  id="col1">
		                <h4>Resources</h4>
						<div class="departmental_home_page_resources_section">
							<?php echo $node->field_departmental_resources['und'][0]['value'] ; ?>
						</div>
						<div class="departmental_home_page_block_bottom">
							<?php if (count($node->field_departmental_resources_lin)) { ?>
		                                                <a href="<?php print $node->field_departmental_resources_lin['und'][0]['url']; ?>">Read more</a>
		                                        <?php } ?>
						</div>
		                <div class="row">
		                        <div class="col-md-12" id="departmental_home_page_social_media">
									<?php 
										if (count($node->field_departmental_social_media) ) {
											foreach ($node->field_departmental_social_media['und'] as $social_media_item) {
												$social_media_item_entity = field_collection_field_get_entity($social_media_item);		

												echo "<a href=\"" . $social_media_item_entity->field_social_media_url['und'][0]['display_url'] . "\">"; 

												if ($social_media_item_entity->field_social_media_type['und'][0]['value'] == "Facebook") {
													echo "<i class=\"fa fa-facebook-square\"></i>";			
												} elseif ($social_media_item_entity->field_social_media_type['und'][0]['value'] == "Twitter") {
													echo "<i class=\"fa fa-twitter-square\"></i>";
												} elseif ($social_media_item_entity->field_social_media_type['und'][0]['value'] == "YouTube") {
													echo "<i class=\"fa fa-youtube-square\"></i>";
												} elseif ($social_media_item_entity->field_social_media_type['und'][0]['value'] == "Google+") {
													echo "<i class=\"fa fa-google-plus-square\"></i>";
												} elseif ($social_media_item_entity->field_social_media_type['und'][0]['value'] == "Instagram") {
													echo "<i class=\"fa fa-instagram\"></i>";
												} elseif ($social_media_item_entity->field_social_media_type['und'][0]['value'] == "Other") {
													echo "<i class=\"fa fa-users\"></i>";
												}

												echo "</a>";

											}
										}

									?>
		                        </div>
		                </div>
		    </div>
		</div>

<?php 

	}
}

?>
