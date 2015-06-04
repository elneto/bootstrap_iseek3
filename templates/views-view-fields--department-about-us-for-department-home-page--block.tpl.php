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

// get organigramme for contextual filter node if possible

$dept_node = node_load($view->args[0]);
// kpr($dept_node);

?>
<div class="row" id="department-about-us-for-department-home-page">
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
		<?php if (count($dept_node->field_departmental_organigram)) { ?>
			<div class="text-right" id="department_organigram"><a href="<?php print file_create_url($dept_node->field_departmental_organigram['und'][0]['uri']); ?>"><i class="fa fa-sitemap"></i> Organigramme</a></div>
		<?php } ?>

	</div>
</div>
