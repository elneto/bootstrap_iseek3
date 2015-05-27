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
?>
<li>
	<span class="calendar-date"><?php print $fields['field_date_with_end']->content; ?><?php print $fields['field_announcement_event_date']->content; ?></span>
	<?php
		$title_link = "";
		if ($row->node_type == "un_observances") {
			$title_link = $row->field_field_link[0]['raw']['safe_value'];	
                } elseif ($row->node_type == "announcements") {
			$title_link = drupal_get_path_alias("node/" . $row->nid);
		} elseif ($row->node_type == "holiday") {
		}

		if (strlen($title_link)) {
			echo "<a href=\"" . $title_link . "\">" . $fields['title']->content . "</a>";
		} else {
			echo $fields['title']->content ;
		}
	?>
</li>
