<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<ul class="dropdown-menu">
	<?php foreach ($rows as $id => $row): ?>
	    <li class="leaf"><?php print $row; ?></li>
	<?php endforeach; ?>
</ul>
