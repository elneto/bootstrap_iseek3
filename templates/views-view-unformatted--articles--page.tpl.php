<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
//kpr($rows);
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php 
//kpr(get_defined_vars());
//kpr($view->field->field_location);
foreach ($rows as $id => $row): ?>
<div class="row">
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>> <!-- internal div -->
    <?php print $row; 
    //kpr($row);
    //kpr($array);
    ?>
  	<!-- </div> --> <!-- The end of the col-md-2 started in views view-field-articles-page-comment template -->  
  </div> <!-- end of internal div -->
</div> <!-- end of row -->
<hr class="articles-division">
<?php endforeach; ?>
