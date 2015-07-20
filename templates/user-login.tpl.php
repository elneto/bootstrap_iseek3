<?php
  /* print the variables if needed to allow for 
  individual field theming or breaking them up. */
  print '<pre>';
  print_r($variables);
  print '</pre>';

?>

<h3>name</h3>

<?php print drupal_render($form['name']); ?>

<h3>pass</h3>

<?php    print drupal_render($form['pass']); ?>

<h3>form_build_id</h3>

<?php    print drupal_render($form['form_build_id']); ?>

<h3>form_id</h3>

<?php    print drupal_render($form['form_id']); ?>

<h3>actions</h3>

<?php    print drupal_render($form['actions']); ?>

