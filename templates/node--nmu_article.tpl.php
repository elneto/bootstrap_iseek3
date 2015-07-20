<?php

/**
 * @file
 * Default theme implementation to display a node.
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
 *
 * @ingroup themeable
 */

$nmu_type = $node->field_type['und'][0]['value']; 

// hardcoded department node id for NMU 
$og_id = 11426;

include('departmental_nodeload_and_menuload.inc');
include('departmental_get_parents.inc');
include('departmental_color_band.inc');

?>

<div class="row">
        <div class="col-lg-12">
                <div class="toolkit large-text">&nbsp;<?php echo $og_node->title; ?></div>
        </div>
        <div class="col-lg-12">
                <div class="dept-color-band" style="background-color:<?php echo $dept_color_band; ?>"></div>
        </div>
</div>

<?php include('departmental_nmu_submenu.inc'); ?>

<?php include('departmental_site_map.inc'); ?>

<?php include('departmental_breadcrumb.inc'); ?>


<div class="row">
	<div class="col-md-3">

		<?php 
		if ($nmu_type == 'Bulletin') { 
			print views_embed_view('nmu_bulletin_calendar', 'block_1'); 
		} elseif ($nmu_type == 'Clipping') { 
			print views_embed_view('nmu_clippings_calendar', 'block_1'); 	
		}
		?>

		<?php include('nmu_search_block.inc'); ?>

	</div>
	<div class="col-md-9">

		<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

			<div class="slug">

		  		<?php if ($nmu_type == 'Bulletin') { ?>
		  			<?php echo $node->field_bulletin_source['und'][0]['entity']->name; ?>. <?php echo date("j F Y", strtotime($node->field_published_date['und'][0]['value'])); ?></p> 
		  		<?php } elseif ($nmu_type == 'Clipping') { ?>
					<?php echo $node->field_clipping_source['und'][0]['entity']->name; ?>. [<?php echo $node->field_type_of_article['und'][0]['taxonomy_term']->name; ?>]. 
					<?php
					      $author_iter = 1;	
					      $author_to_print = "";	 
					      foreach ($node->field_clipping_author['und'] as $author) { 
							$author_to_print .= $author['entity']->title;
							if ($author_iter == count($node->field_clipping_author['und'])) {
								$author_to_print .= ". ";	
							} else {
								$author_to_print .= "; ";	
							}
							$author_iter++;
					      } 
					      echo $author_to_print;	
					?>
					<?php echo date("j F Y", strtotime($node->field_published_date['und'][0]['value'])); ?>.
		  		<?php } ?> 	

			</div>
	
			<h2><?php print $title; ?></h2>
	
  			<div class="content"<?php print $content_attributes; ?>>
			    <?php
				echo $node->body['und'][0]['safe_value'];
			    ?>
	  		</div>

		</div>

	</div>
</div>
