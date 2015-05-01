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

<section class="clearfix container-fluid">
<div class="row">

	<aside class="col-sm-3" role="complementary">	

		<div class="region">

		<?php
			$group = og_context();
			// print_r($group);
			// print "gid1: " . $group['gid'];

			if (!(empty($group))) {


			?>


				<section class="block">
					<h2><?php print($content['field_og_group_ref3']['#object']->field_og_group_ref3['und'][0]['entity']->title); // print($content['field_og_group_ref3'][0]['#title']); ?></h2>
					<div class="content">
							<?php
								print views_embed_view('departmental_page_in_og', 'block', $group['gid']);
							?>
					</div>
				</section>

				<?php

					// $taxonomy_term_array = taxonomy_get_term_by_name($content['field_og_group_ref3'][0]['#title'], "departments");
					$taxonomy_term_array = taxonomy_get_term_by_name($content['field_og_group_ref3']['#object']->field_og_group_ref3['und'][0]['entity']->title, "departments");

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
					<h2><?php print($content['field_og_group_ref3']['#object']->field_og_group_ref3['und'][0]['entity']->title); ?>  sub-levels</h2>
					<div class="content">
						<ul class="menu">
							<?php
								foreach ($taxonomy_children_array as $child) {
							?>
									<li>


										<?php
										$query = new EntityFieldQuery();
										$entities = $query->entityCondition('entity_type', 'node')
											->propertyCondition('type', 'department')
											->propertyCondition('title', $child->name)
											->propertyCondition('status', 1)
											->range(0,1)
											->execute();

										if (!empty($entities['node'])) {
											$node = node_load(array_shift(array_keys($entities['node'])));
										?>
											<a href="<?php print url("node/" . $node->nid) ?>"><?php print $child->name; ?></a>
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

		<?php
			}
		?>

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

					if (!(empty($group))) {

						$taxonomy_term_array = taxonomy_get_term_by_name($content['field_og_group_ref3']['#object']->field_og_group_ref3['und'][0]['entity']->title, "departments");

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
					} /* if (!(empty($group))) */
				?>

				</div>

			  <?php print render($title_prefix); ?>
			  <?php if (!$page): ?>
				<h2<?php print $title_attributes; ?>>
				  <a href="<?php print $node_url; ?>"><?php print $title; ?></a>
				<?php echo $type; ?>
				</h2>
			  <?php endif; ?>
			  <?php print render($title_suffix); ?>

			  <?php if ($display_submitted): ?>
				<div class="meta submitted">
				  <?php print $user_picture; ?>
				  <?php print $submitted; ?>
				</div>
			  <?php endif; ?>

			  <div class="content clearfix"<?php print $content_attributes; ?>>

				<?php
				  // We hide the comments and links now so that we can render them later.
				  hide($content['comments']);
				  hide($content['links']);
				  hide($content['field_og_group_ref3']);
				  print render($content);

				  // print_r($content);


				?>
			  </div>

			  <?php
				// Remove the "Add new comment" link on the teaser page or if the comment
				// form is being displayed on the same page.
			/*
				if ($teaser || !empty($content['comments']['comment_form'])) {
				  unset($content['links']['comment']['#links']['comment-add']);
				}
			*/
				// Only display the wrapper div if there are links.
				$links = render($content['links']);
				if ($links):
			  ?>
				<div class="link-wrapper">
				  <?php print $links; ?>
				</div>
			  <?php endif; ?>

			  <?php print render($content['comments']); ?>

			</div>
		</div>
	</section>
	
</div>
</section>
