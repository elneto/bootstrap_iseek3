<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php
$row_i = 1; 
foreach ($rows as $id => $row): 
	print $row;
	if ($row_i < count($rows)) {
		print ",";	
	}
	$row_i++;
endforeach; 
?>
