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

//kpr($monthName);

function iseek_url_num_to_month($url){
  $pattern = "/\d{2}$/"; //matches last two digits
//we find the previous and next month
  $subject = $url;
  preg_match($pattern, $subject, $matches);
  $monthNum  = $matches[0];
  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
  return  $dateObj->format('F'); 
}

$subject = $nav_title;
$pattern = '/ \w+/u'; //matches the month from the title (u for utf-8)
preg_match($pattern, $subject, $matches);
//kpr($matches[0]);
$month = substr($matches[0], 1);

$prevMonth = iseek_url_num_to_month($prev_url);
$nextMonth = iseek_url_num_to_month($next_url);

?>
<?php if (!empty($pager_prefix)) print $pager_prefix; ?>
<div class="date-nav-wrapper clearfix<?php if (!empty($extra_classes)) print $extra_classes; ?>">
  <div class="date-nav item-list">
    <div class="date-heading">
	  <h3>
      <span class="cal-month-name">
		  <?php	print l(t($prevMonth), $next_url, $next_options) .' | '. $month .' | '. l(t($nextMonth), $next_url, $next_options); ?> 
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
    <span id="legend-announcement"></span> <?php print t('Event'); ?> &nbsp;&nbsp;<span id="legend-holiday"></span> <?php print t('Holiday'); ?> &nbsp;&nbsp;<span id="legend-global"></span> <?php print t('Global event');?>
  </div>    
</div>
