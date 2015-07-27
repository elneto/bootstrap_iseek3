<?php
/**
 * @file
 * Template file for the example display.
 *
 * Variables available:
 * 
 * $plugin: The pager plugin object. This contains the view.
 *
 * $plugin->view
 *   The view object for this navigation.
 *
 * $nav_title
 *   The formatted title for this view. In the case of block
 *   views, it will be a link to the full view, otherwise it will
 *   be the formatted name of the year, month, day, or week.
 *
 * $prev_url
 * $next_url
 *   Urls for the previous and next calendar pages. The links are
 *   composed in the template to make it easier to change the text,
 *   add images, etc.
 *
 * $prev_options
 * $next_options
 *   Query strings and other options for the links that need to
 *   be used in the l() function, including rel=nofollow.
 */

//kpr($plugin->view->date_info->month);

function iseek_next_month($num){
  if($num >= 12)
    return 1;
  else
    return $num+1;
}

function iseek_prev_month($num){
  if($num <= 1)
    return 12;
  else
    return $num-1;
}

function iseek_num_to_month($monthNum){
  return date('F', mktime(0, 0, 0, $monthNum, 10));
}

$month = iseek_num_to_month($plugin->view->date_info->month);
$prevMonth = iseek_num_to_month(iseek_prev_month($plugin->view->date_info->month));
$nextMonth = iseek_num_to_month(iseek_next_month($plugin->view->date_info->month));

?>
<?php if (!empty($pager_prefix)) print $pager_prefix; ?>
<div class="date-nav-wrapper clearfix<?php if (!empty($extra_classes)) print $extra_classes; ?>">
  <div class="date-nav item-list">
    <div class="date-heading">
	  <h3>
      <span class="cal-month-name">
		  <?php	print l(t($prevMonth), $prev_url, $prev_options) .' | '. t($month) .' | '. l(t($nextMonth), $next_url, $next_options); ?> 
      </span>
	  </h3>
    </div>
    <ul class="pager">
    <?php if (!empty($prev_url)) : ?>
      <li class="date-prev">
        <?php print l('&laquo;' . ($mini ? '' : ' ' . t('Prev', array(), array('context' => 'date_nav'))), $prev_url, $prev_options); ?>
      </li>
    <?php endif; ?>
    
    <?php if (!empty($next_url)) : ?>
      <li class="date-next">
        <?php print l(($mini ? '' : t('Next', array(), array('context' => 'date_nav')) . ' ') . '&raquo;', $next_url, $next_options); ?>
      </li>
    <?php endif; ?>
    </ul>
  </div>
</div>

<div class="row">
  <div class="col-lg-12 text-center calendar-legend">
    <span id="legend-announcement"></span> <?php print t('Local event'); ?> &nbsp;&nbsp;<span id="legend-holiday"></span> <?php print t('Holiday'); ?> &nbsp;&nbsp;<span id="legend-global"></span> <?php print t('Global event');?>
  </div>    
</div>
