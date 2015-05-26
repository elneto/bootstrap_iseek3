<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */

/* 
preg_match('/(<a href="(.*?)">)(.*?)<\/a>+$/', $output, $matches); 

print "<p>" ;
print "matches :: " ;
print_r($matches); 
print " :: matches" ;
print "</p>" ;

// <a href="<?php echo $matches[0]; ?>"><font size="2" color="#4F4F4F" face="Verdana"><b><?php echo $matches[0]; ?></b></font></a>
// <a href="<?php echo $matches[2]; ?>"><font size="2" color="#4F4F4F" face="Verdana"><b><?php echo $matches[3]; ?></b></font></a>
*/

// print $output;
// <?php echo $row->_field_data['nid']['entity']->['path']['alias']; 
?>
<?php print_r($row); ?>
<br>
<a href="<?php echo "path"; ?>"><font size="2" color="#00648A" face="Verdana"><?php echo "path"; ?></font></a>