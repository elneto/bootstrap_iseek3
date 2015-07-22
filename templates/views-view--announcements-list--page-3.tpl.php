<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */

//kpr('views-view has been called');
$arg = arg(1);
?>

<div class="row">
  <div class="col-lg-12">
    <div class="toolkit large-text white-link"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php print t('Events');?></div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-lg-12">
    <div class="page-title calendar-view-link"><a href="<?php echo $GLOBALS['base_url'].'calendar/'; ?>"><?php print t('Calendar view'); ?> <i class="fa fa-angle-double-right"></i></a></div>
  </div>
</div>
<br>
<div class="row">
  <div class="col-xs-12 col-md-12">
    <h4 class="page-title"><?php print(t('Filter by duty station'));?></h4>
    <div class="dutyStationButtons">
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/60'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==60 or $arg=='addisababa'){echo 'active';}?>"><?php print(t('Addis Ababa'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/61'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==61 or $arg=='bangkok'){echo 'active';}?>"><?php print(t('Bangkok'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/62'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==62 or $arg=='beirut'){echo 'active';}?>"><?php print(t('Beirut'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/131'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==131 or $arg=='geneva'){echo 'active';}?>"><?php print(t('Geneva'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/63'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==63 or $arg=='nairobi'){echo 'active';}?>"><?php print(t('Nairobi'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/555'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==555 or $arg=='newyork'){echo 'active';}?>"><?php print(t('New York'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/64'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==64 or $arg=='santiago'){echo 'active';}?>"><?php print(t('Santiago'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/65'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==65 or $arg=='vienna'){echo 'active';}?>"><?php print(t('Vienna'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/global'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg=='global'){echo 'active';}?>"><?php print(t('Global'));?></a>
      <a href="<?php echo $GLOBALS['base_url'].'/events-list/'; ?>" class="btn btn-default dutyStationBtn <?php if ($arg==''){echo 'active';}?>"><?php print(t('All'));?></a>
    </div>
  </div>
</div>
<br><br>

<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>
