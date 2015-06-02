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

$divisions_menu_array = menu_navigation_links($menu_name)

?>

<div class="row">
       	<div class="col-lg-12">
      		<div class="toolkit large-text" id="toolkit-anchor">&nbsp;<?php echo $node->title; ?></div>
	</div>
	<div class="col-lg-12">
                <div style="background-color:yellow;height:10px;"></div>
        </div>
</div>

<div class="row departmentalSubmenu">
        <div class="col-lg-12">
		<ul class="departmentalSubmenu-nav">
			<li class="first expanded dropdown">
				<span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown">Quicklinks <span class="caret"></span></span>
				<?php print views_embed_view('departmental_page_in_og', 'block', $node->nid); ?>
			</li>
			<li>Site map</li>
			<?php 
				if ($menu_display_name) {
			?>
	
					<li class="expanded dropdown">
						<span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><?php echo $menu_display_name ?> <span class="caret"></span></span>
						<ul class="dropdown-menu">
							<?php
								foreach ($divisions_menu_array as $divisions_menu_array_item) { 
									echo "<li class=\"leaf\"><a href=\"" . $divisions_menu_array_item['href'] . "\">" . $divisions_menu_array_item['title'] . "</a></li>";
								}	
							?>
						</ul>		
					</li>
			<?php 	} ?>
		
			<li>FAQ</li>
			<li>Contact us</li>
		</ul>
	</div>
</div>

<div>
<?php
?>
</div>


<?php /*

<section class="clearfix container-fluid">
<div class="row">

	<aside class="col-sm-3" role="complementary">	

		<div class="region">
		
			<section class="block">
				<h2><?php echo $node->title; ?></h2>
				<div class="content">
					<!-- <ul class="menu"> -->
						<?php
							print views_embed_view('departmental_page_in_og', 'block', $node->nid);
						?>
					<!-- </ul> -->
				</div>
			</section>


			<?php

				$taxonomy_term_array = taxonomy_get_term_by_name($node->title, "departments");

				# print_r($taxonomy_term_array);

				$taxonomy_id = key($taxonomy_term_array);

				$taxonomy_term_array_shifted = array_shift($taxonomy_term_array);
				// $taxonomy_children_array = taxonomy_get_children(key($taxonomy_term_array));
				// echo "taxonomy_id: $taxonomy_id ";
				// print_r($taxonomy_term_array_shifted);
				// echo "taxonomy_term_array_shifted: " . $taxonomy_term_array_shifted->vid ;
				$taxonomy_children_array = taxonomy_get_tree($taxonomy_term_array_shifted->vid, $taxonomy_id, 1);
			?>

			<?php // print_r($taxonomy_children_array); ?>

			<section class="block">
				<h2><?php echo $node->title; ?> sub-levels</h2>
				<div class="content">
					<ul class="menu">
						<?php
							foreach ($taxonomy_children_array as $child) {
						?>
								<li>

									<?php // print_r($child); ?>

									<?php // print $child->name; ?> <?php // print $child->tid; ?>

									<?php
									$query = new EntityFieldQuery();
									$entities = $query->entityCondition('entity_type', 'node')
									->propertyCondition('type', 'department')
									->propertyCondition('title', $child->name)
									->propertyCondition('status', 1)
									->range(0,1)
									->execute();

									if (!empty($entities['node'])) {
									$child_node = node_load(array_shift(array_keys($entities['node'])));
									?>
											<a href="<?php print url("node/" . $child_node->nid) ?>"><?php print $child->name; ?></a>
									<?php
									} else {
									?>
											<?php print $child->name; ?>
									<?php
									}
									?>

								</li>
						<?php
							}
						?>
					</ul>
				</div>
			</section>

		</div>

	</aside>

	<section class="col-sm-9">
	
		<div id="content" class="column">

			 <a id="main-content"></a>
			  <?php print render($title_prefix); ?>
			  <?php if ($title): ?>
				<h1 class="title" id="page-title">
				  <?php print $title; ?>
				</h1>
			  <?php endif; ?>
			  <?php print render($title_suffix); ?>
			  <?php if ($tabs): ?>
				<div class="tabs">
				  <?php print render($tabs); ?>
				</div>
			  <?php endif; ?>
			  <?php print render($page['help']); ?>
			  <?php if ($action_links): ?>
				<ul class="action-links">
				  <?php print render($action_links); ?>
				</ul>
			  <?php endif; ?>


			<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

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
			
		  <?php
			// print_r($node);
			
			$field_departmental_theme_value = 0;
			
			$field_departmental_banner = field_get_items('node', $node, 'field_departmental_banner');	
			$field_departmental_head_image = field_get_items('node', $node, 'field_departmental_head_image');	
			$field_departmental_head_text = field_get_items('node', $node, 'field_departmental_head_text');	
			$field_departmental_about_us = field_get_items('node', $node, 'field_departmental_about_us');
			$field_departmental_resources = field_get_items('node', $node, 'field_departmental_resources');	
			$field_departmental_organigram = field_get_items('node', $node, 'field_departmental_organigram');
			$field_departmental_events_activi = field_get_items('node', $node, 'field_departmental_events_activi');
			$field_departmental_membership_le = field_get_items('node', $node, 'field_departmental_membership_le');
			$field_departmental_forum = field_get_items('node', $node, 'field_departmental_forum');
			
			$field_departmental_theme = field_get_items('node', $node, 'field_departmental_theme');	
			$field_departmental_theme_value = $field_departmental_theme[0]['value'];




			if ($field_departmental_theme_value == 1) {

		?>			

 			<img src="<?php echo image_style_url('large-article-image-style', $field_departmental_banner[0]['uri']) ?>" alt="<?php echo $field_departmental_banner[0]['field_file_image_alt_text']['und'][0]['safe_value']; ?>"/>

			<div class="row">
			
				<div class="col-sm-6">
				
					<h3>Mandate/About us</h3>
					<p>
						<?php echo($field_departmental_about_us[0]['safe_value']); ?>
					</p>
				
				</div>
			
				<div class="col-sm-6">
				
					<h3>Membership/Leadership</h3>
					<p>
						<?php echo($field_departmental_membership_le[0]['safe_value']); ?>					
					</p>
				
				</div>
			
			</div>
			
			<div class="row">
			
				<div class="col-sm-6">
				
					<h3>Schedule</h3>

					<?php 
						// print_r($field_departmental_events_activi); 
						// echo($field_departmental_events_activi[0]['safe_value']);					
					?>

					<?php
						print views_embed_view('departmental_schedule_items_in_og', 'block', $node->nid);
					?>
					
					
				</div>
			
				<div class="col-sm-6">
				
					<h3>Image carousel</h3>
				
					<?php
						print views_embed_view('departmental_images_in_og', 'block', $node->nid);
					?>

				</div>
			
			</div>
			  
			<div class="row">
			
				<div class="col-sm-6">
				
					<h3>Latest news</h3>

					<?php
						print views_embed_view('departmental_news_in_og', 'block', $node->nid);
					?>
				
				</div>

				<div class="col-sm-6">
				
					<h3>Club calendar</h3>
					
					<?php
						// print views_embed_view('departmental_event_calendar', 'block_1', '201502', $node->nid);
						print views_embed_view('departmental_event_calendar', 'page_1', '201502', $node->nid);
						// print views_embed_view('departmental_event_calendar', 'block');
					?>
					

				</div>
			
			</div>		

			<div class="row">
			
				<div class="col-sm-6">
				
					<h3>Resources</h3>

					<p>
						<?php echo($field_departmental_resources[0]['safe_value']); ?>
					</p>
				
				</div>

				<div class="col-sm-6">
				
					<h3>Newsletter</h3>

				</div>
			
			</div>		
			
			
			<div class="row">

				<div class="col-sm-6">

					<h3><a href="<?php echo $field_departmental_forum[0]['url']; ?>">Discussion forum</a></h3>
				
				</div>

				<div class="col-sm-6">
				
					<h3>Contact us</h3>
			
				</div>
			
			</div>			
		
		
		
			
		<?php
		
			} else if ($field_departmental_theme_value == 2) {
			
		  ?>

 			<img src="<?php echo image_style_url('large-article-image-style', $field_departmental_banner[0]['uri']) ?>" alt="<?php echo $field_departmental_banner[0]['field_file_image_alt_text']['und'][0]['safe_value']; ?>"/>

			<div class="row">
			
				<div class="col-sm-6">
				
					<h3>Department head</h3>
					<img style="width:100%" src="<?php echo image_style_url('large-article-image-style', $field_departmental_head_image[0]['uri']) ?>" alt="<?php // echo $field_departmental_head_image[0]['field_file_image_alt_text']['und'][0]['safe_value']; ?>"/>
				
					<p>
						<?php echo($field_departmental_head_text[0]['safe_value']); ?>
					</p>
				
				</div>
			
				<div class="col-sm-6">
				
					<h3>Mandate/About us</h3>
					<p>
						<?php echo($field_departmental_about_us[0]['safe_value']); ?>
					</p>
				
				</div>
			
			</div>
			
			<div class="row">
			
				<div class="col-sm-6">
				
					<h3>Latest news</h3>

					<?php
						print views_embed_view('departmental_news_in_og', 'block', $node->nid);
					?>
					
				</div>
			
				<div class="col-sm-6">
				
					<h3>Media carousel</h3>
				
				</div>
			
			</div>
			  
			<div class="row">
			
				<div class="col-sm-6">
				
					<h3>Resources</h3>

					<p>
						<?php echo($field_departmental_resources[0]['safe_value']); ?>
					</p>
				
				</div>

				<div class="col-sm-6">
				
					<h3>Organigram</h3>

					<p>
						<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
						<a href="<?php echo file_create_url($field_departmental_organigram[0]['uri']); ?>"><?php echo($field_departmental_organigram[0]['filename']); ?></a>
					</p>

				</div>
			
			</div>		

			<div class="row">
			
				<div class="col-sm-12">
				
					<h3>Contact us</h3>
			
				</div>
			
			</div>		
			
			
		<?php 
			} else {
			  
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
			}		
		?>


			</div>
		</div>	
	</section>		

</div>
</section>

*/ ?>
