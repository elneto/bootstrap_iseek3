<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php 

$bootclass = array("rpad0", "lpad75 rpad75", "lpad0");

if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php 
$i = 0;
foreach ($rows as $id => $row): ?>

<div class="col-md-4 <?php echo $bootclass[$i];?>">
	<div class="spotlight-thumbnail">

  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>

	</div>
</div>

<?php 
$i+=1;
endforeach; ?>
