<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php 
$iter = 0;
foreach ($rows as $id => $row): 
?>
	<div class="col-md-4 rpad5">
		<div class="main-thumbnail">
    			<?php print $row; ?>
		</div>
	</div>	
<?php 
	$iter++;
endforeach; 
?>
