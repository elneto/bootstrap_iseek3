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
//kpr($fields);
?>
<div class="row">
	<?php if (isset($fields['field_photo'])): ?>
	<div class="col-md-3">
		<?php print $fields['field_photo']->content; ?>
	</div>
	<div class="col-md-9">
	<?php else: ?>
	<div class="col-md-12">
	<?php endif; ?>
		<div class="archives-size">
			<div class="archives-title">
				<?php print $fields['title']->content; ?>	
			</div>
			<div class="slug-archive">
				<?php print t('Category') . ': '. $fields['classified_category']->content; ?> <span>/</span>
				<?php if ($fields['field_ad_location']->content): print $fields['field_ad_location']->content; ?><?php endif; ?>
			</div>
			<div class="slug-archive">
				<?php print t('Created') . ': ' . $fields['created']->content; ?> 
			</div>

			<div class="archives-body">
				<?php print $fields['body']->content; ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<hr class="archives-hr">
	</div>
</div>
