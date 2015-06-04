<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */

/*
$caption_result = db_query(
        "select t1.field_caption_value from {field_data_field_caption} t1 join {file_usage} t2 on t1.entity_id = t2.fid where t2.id = :id",
        array(':id' => $fields['field_about_us_images']->raw)
);

$caption = "";
if ($caption_result) {
        while ($row = $caption_result->fetchAssoc()) {
                $caption = $row['field_caption_value'];
        }
}
*/
?>
<div class="row">

	<div class="col-md-12">
		<h4><?php echo $fields['title']->content; ?></h4>
		<div class="media">
			<div class="media-left">
				<?php print $fields['field_departmental_bio_image']->content; ?>
			</div>	
			<div class="media-body">
				<h5 class="media-heading"><?php print $fields['field_departmental_bio_image_cap']->content; ?></h5>
				<div id="field_departmental_bio_image_des"><?php print $fields['field_departmental_bio_image_des']->content; ?></div>
				<div id="field_departmental_home_page_bod"><?php print $fields['field_departmental_home_page_bod']->content; ?></div>
			</div>
		</div>		
	</div>
<?php
/*
	<?php if (isset($fields['field_about_us_images'])): ?>
		<div class="col-md-6">
			<?php print $fields['field_about_us_images']->content; ?>
			<div id="caption-mi">
			        <div id="caption-mi-title"><?php print $caption; ?></div>
			</div>
		</div>
	<?php endif; ?>
	<div class="col-md-6">
		<h2><?php print $fields['title']->content; ?></h2>
		<div class="dept_about_us_body"><?php print $fields['body']->content; ?></div>
	</div>
*/ ?>
</div>
