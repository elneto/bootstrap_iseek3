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

$group = og_context();

$og_id = $group['gid'];

include('departmental_nodeload_and_menuload.inc');
include('departmental_get_parents.inc');
include('departmental_color_band.inc');
?>

<div class="row">
       	<div class="col-lg-12">
      		<div class="toolkit large-text">&nbsp;<?php echo $og_node->title; ?></div>
	</div>
	<div class="col-lg-12">
                <div class="dept-color-band" style="background-color:<?php echo $dept_color_band; ?>;"></div>
        </div>
</div>

<div class="row departmentalSubmenu">
        <div class="col-lg-12">
		<ul class="departmentalSubmenu-nav">
			<li class="first expanded dropdown">
				<span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><i class="fa fa-link"></i> Quicklinks <span class="caret"></span></span>
				<?php print views_embed_view('departmental_page_in_og', 'block', $og_id); ?>
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
		
			<?php print views_embed_view('departmental_faq_in_og', 'block', $og_id); ?>
			<?php
				if (count($og_node->field_departmental_contact_us)) {
			?>	
					<li><a href="<?php echo $og_node->field_departmental_contact_us['und'][0]['safe_value'] ?>"><i class="fa fa-envelope-o"></i> Contact us</a></li>
			<?php
				}
			?>
		</ul>
	</div>
</div>

<?php include('departmental_site_map.inc'); ?>

<?php include('departmental_breadcrumb.inc'); ?>


<div class="row">
	<div class="col-sm-12" id="departmental_faq_toc">
		<h2>FAQ</h2>

<?php
		if (count($node->field_faq_entry) ) {
?>
			<ul>
<?php
		        	foreach ($node->field_faq_entry['und'] as $field_faq_entry) {
		        	        $field_faq_item_entry = field_collection_field_get_entity($field_faq_entry);

					echo "<li><a href=\"#" . $field_faq_item_entry->item_id . "\">" . $field_faq_item_entry->field_faq_question['und'][0]['safe_value'] . "</a></li>"; 

				}
?>
			</ul>
<?php
		}
?>		

	</div>

	<div class="col-sm-12" id="departmental_faq_body">

<?php
                if (count($node->field_faq_entry) ) {

			$iter = 1;

                        foreach ($node->field_faq_entry['und'] as $field_faq_entry) {

				$oddeven = "odd";
				if ($iter % 2 == 0) {
					$oddeven = "even";
				}	

				echo "<div class=\"departmental_faq_body_entry_" . $oddeven . "\">";

                        	$field_faq_item_entry = field_collection_field_get_entity($field_faq_entry);
                        
                                echo "<a id=\"" . $field_faq_item_entry->item_id . "\"><i class=\"fa fa-caret-right\"></i> " . $field_faq_item_entry->field_faq_question['und'][0]['safe_value'] . "</a></li>";
				echo "<div>" . $field_faq_item_entry->field_faq_answer['und'][0]['safe_value']  . "</div>";			

				echo "</div>";

				$iter++;
                	}
                }
?>		

	</div>
</div>
