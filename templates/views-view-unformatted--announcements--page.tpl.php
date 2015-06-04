<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */

$arg = arg(1);
?>

<div class="row">
	<div class="col-xs-12 col-md-12">
		<h4 class="page-title">Filter by duty station</h4>
		<div class="dutyStationButtons">
			<a href="<?php echo url('<front>').'announcements/addis-ababa'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==60 or $arg=='addis-ababa'){echo 'active';}?>">Addis Ababa</a>
			<a href="<?php echo url('<front>').'announcements/bangkok'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==61 or $arg=='bangkok'){echo 'active';}?>">Bangkok</a>
			<a href="<?php echo url('<front>').'announcements/beirut'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==62 or $arg=='beirut'){echo 'active';}?>">Beirut</a>
			<a href="<?php echo url('<front>').'announcements/geneva'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==131 or $arg=='geneva'){echo 'active';}?>">Geneva</a>
			<a href="<?php echo url('<front>').'announcements/nairobi'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==63 or $arg=='nairobi'){echo 'active';}?>">Nairobi</a>
			<a href="<?php echo url('<front>').'announcements/new-york'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==555 or $arg=='new-york'){echo 'active';}?>">New York</a>
			<a href="<?php echo url('<front>').'announcements/santiago'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==64 or $arg=='santiago'){echo 'active';}?>">Santiago</a>
			<a href="<?php echo url('<front>').'announcements/vienna'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==65 or $arg=='vienna'){echo 'active';}?>">Vienna</a>
		</div>
	</div>
</div>
<br><br>

<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
