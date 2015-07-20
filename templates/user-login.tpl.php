<?php
  /* print the variables if needed to allow for 
  individual field theming or breaking them up. */
//  print '<pre>';
//  print_r($variables);
//  print '</pre>';

?>

<div class="row">
	<div class="col-lg-12">
		<div class="top-side-box"> <?php echo t('Welcome to the United Nations Intranet');?></div>
	
		<p>
			<?php echo t('The United Nations Intranet, iSeek, was developed to encourage knowledge-sharing throughout the UN system.');?>
			<br/>
			<?php echo t('Log in now using your Lotus Notes webmail account and be a part of the discussion!');?> 
		</p>
	</div>
</div>



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


<div class="row">
        <div class="col-lg-12">
		<p>
			<?php echo t('If you have difficulties accessing the system with your Lotus Notes webmail account or if you use Exchange or Outlook, please contact the UN Intranet Team.');?>
		</p>
        </div>
</div>
