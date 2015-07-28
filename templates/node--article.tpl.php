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
 *   - node-sticky: dddNodes ordered above other non-sticky nodes in teaser
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
		<div class="top-side-box"><i class="fa fa-newspaper-o"></i> <a href="<?php echo url('articles');?>"><?php print t('Staff stories and news');?> <i class="fa fa-angle-double-right"></i></a></div>
	</div>
</div>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

	<div class="row">
		<div class="col-lg-8 col-md-12">

			<div class="slug">
				<?php
					if ($node->language == "fr") {
						setlocale(LC_TIME, "fr_FR");
						echo ucfirst(utf8_encode(strftime('%A %e %B %G', strtotime($node->field_actual_posting_date['und'][0]['value']))));
					} else {
						echo utf8_encode(strftime('%A, %e %B %G', strtotime($node->field_actual_posting_date['und'][0]['value'])));
					}

					if (isset($node->field_location['und'][0]['tid'])) {
					  $term_field_location = taxonomy_term_load($node->field_location['und'][0]['tid']);
					  
					  if (isset($term_field_location->name)) {
						echo " | ";
						echo $term_field_location->name; 
					  } 
					}

					if (isset($node->field_office['und'][0]['tid'])) {
						$term_field_office = taxonomy_term_load($node->field_office['und'][0]['tid']);

						if (isset($term_field_office->name)) {
							echo " | ";
							echo $term_field_office->name; 
						} 
					}	
				?> 
				<?php if (isset($node->field_author_name['und'][0]['safe_value'])) { 
					echo " | "; 
					echo $node->field_author_name['und'][0]['safe_value'];
				} ?> 
			</div>

			  <?php print render($title_prefix); ?>
			    <h2 id="headline">
			      <?php print $title; ?>
			    </h2>
			  <?php print render($title_suffix); ?>

			  <?php if ($display_submitted): ?>
			    <div class="meta submitted">
			      <?php print $user_picture; ?>
			      <?php print $submitted; ?>
			    </div>
			  <?php endif; ?>

		</div>	
	</div>	

	<div class="row">
		<div class="col-lg-12">
			<?php print render($content['field_images']); ?>
		</div>
	</div>	

        <div class="row">
                <div class="col-lg-8 col-md-12">

			  <div class="content clearfix"<?php print $content_attributes; ?>>
			    <?php
			      // We hide the comments and links now so that we can render them later.
			      hide($content['comments']);
			      hide($content['links']);
			      // print render($content);
			    ?>



				<div class="content-body">
					<?php // print render($content['field_image']); ?>
					

					<!-------------------HS added below------------------------>
					<?php if (isset($content['field_video'])) { ?>
						<div class="flex-video widescreen">
							<?php print render($content['field_video']); ?>
						</div>
						<div class="video-caption">
							<?php print($node->field_video_description['und'][0]['safe_value']); ?>
						</div>
					<?php 
						}
						
						elseif (isset($content['field_bright_cove_video_id'])) { 
							
							?>
							<div class="flex-video widescreen">
							<div style="display:none">
							</div>
							<script language="JavaScript" type="text/javascript" src="https://sadmin.brightcove.com/js/BrightcoveExperiences.js"></script>
							<object id="myExperience" class="BrightcoveExperience">
								<param name="bgcolor" value="#FFFFFF" />
								<param name="secureConnections" value="true" />
								<param name="secureHTMLConnections" value="true" />
								<param name="width" value="100%" />
								<param name="height" value="100%" />
								<param name="playerID" value="4005339337001" />
								<param name="playerKey" value="AQ~~,AAABPSuWdxE~,UHaNXUUB06VgvRTiG_GhQXXPhev1OX58" />
								<param name="isVid" value="true" />
								<param name="isUI" value="true" />
								<param name="dynamicStreaming" value="true" />
								<param name="wmode" value="transparent">
								<param name="@videoPlayer" value="<?php print($node->field_bright_cove_video_id['und'][0]['safe_value']); ?>">
								<param name="captionLang" value="en" />
							</object>

							<script type="text/javascript">brightcove.createExperiences();</script>
							</div>
							<div class="video-caption">
								<?php print($node->field_video_description['und'][0]['safe_value']); ?>
							</div>
					<?php  
						 	
						 } 
						 else { // ((!(isset($content['field_video']))) and (!(isset($content['field_bright_cove_video_id'])))) { 
							// commented out by eric 26 may due to vertically-placed pager
							// print render($content['field_images']);
						}
						
					?>
					<!---------------------------->
					

					<?php print render($content['body']); ?>
					
					
					<!-------------------HS added below------------------------>
					<?php 
						if ((isset($content['field_video'])) or (isset($content['field_bright_cove_video_id']))) {
							print render($content['field_images']);
						}
						if (isset($content['field_files'])){
							print render($content['field_files']); 
						}
					?>		
					<!---------------------------->


					<!-- begin common comments -->
    				<?php include('sites/iseek.un.org/themes/bootstrap_iseek3/templates/common-comments.tpl.php'); ?>
    				<!-- end common comments -->
		<div class="col-lg-2 col-md-12">

		</div>	
	</div>		  
</div><!-- node -->
