<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<div class="row">
	<div class="col-xs-12 col-md-12">
		<div class="dutyStationButtons">
			<!-- <button type="button" value="Bonn" class="btn btn-primary dutyStationBtn active">Bonn</button> -->
			<button type="button" value="60" class="btn btn-default dutyStationBtn">Addis Ababa</button>
			<button type="button" value="61" class="btn btn-default dutyStationBtn">Bangkok</button>
			<button type="button" value="62" class="btn btn-default dutyStationBtn">Beirut</button>
			<button type="button" value="131" class="btn btn-default dutyStationBtn">Geneva</button>
			<button type="button" value="63" class="btn btn-default dutyStationBtn">Nairobi</button>
			<button type="button" value="555" class="btn btn-default dutyStationBtn">New York</button>
			<button type="button" value="64" class="btn btn-default dutyStationBtn">Santiago</button>
			<button type="button" value="65" class="btn btn-default dutyStationBtn">Vienna</button>
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
