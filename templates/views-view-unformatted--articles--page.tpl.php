<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
<div class="row">
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>> <!-- internal div -->
    <?php print $row; ?>
  	<!-- </div> --> <!-- The end of the col-md-2 started in views view-field-articles-page-comment template -->  
  </div> <!-- end of internal div -->
</div> <!-- end of row -->
<hr class="articles-division">
<?php endforeach; ?>
