<?php
  /* print the variables if needed to allow for 
  individual field theming or breaking them up. */
//  print '<pre>';
//  print_r($variables);
//  print '</pre>';

?>

<div class="row">
	<div class="col-lg-12">
		<div class="toolkit large-text" id="toolkit-anchor"> <?php echo t('Welcome to the United Nations Intranet');?></div>
	</div>
</div>

<div class="row">
        <div class="col-lg-12">
		<p id="user_login_intro">
                        <?php echo t('The United Nations Intranet, iSeek, was developed to encourage knowledge-sharing throughout the UN system.');?>
                        <br/>
                        <?php echo t('Log in now using your Lotus Notes webmail account and be a part of the discussion!');?>
                </p>
        </div>
</div>

<div class="row">
        <div class="col-lg-12" id="user_login_form">
		<?php print drupal_render($form['name']); ?>
		<?php print drupal_render($form['pass']); ?>
		<?php print drupal_render($form['form_build_id']); ?>
		<?php print drupal_render($form['form_id']); ?>
		<?php print drupal_render($form['actions']); ?>
	</div>
</div>

<div class="row">
        <div class="col-lg-12">
		<p id="user_login_intro">
			<?php echo t('* If you have difficulties accessing the system with your Lotus Notes webmail account or if you use Exchange or Outlook, please contact the UN Intranet Team.');?>
		</p>
        </div>
</div>
