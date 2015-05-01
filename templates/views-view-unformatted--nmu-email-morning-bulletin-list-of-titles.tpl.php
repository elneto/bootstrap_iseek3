<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <p><font size="3" color="#0060A0" face="Verdana"><?php print $title; ?></font></p>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
    <font size="2" color="#00648A" face="Verdana"><?php print $row; ?></font>
	<br>
<?php endforeach; ?>