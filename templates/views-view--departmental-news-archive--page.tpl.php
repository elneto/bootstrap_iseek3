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

$og_id = $view->args[0];
$og_node = node_load($view->args[0]);

include('departmental_nodeload_and_menuload.inc');
include('departmental_get_parents.inc');
include('departmental_color_band.inc');
?>

<div class="row">
        <div class="col-lg-12">
                <div class="toolkit large-text">&nbsp;<?php echo $og_node->title; ?> | News</div>
        </div>
        <div class="col-lg-12">
                <div class="dept-color-band" style="background-color:<?php echo $dept_color_band; ?>;"></div>
        </div>
</div>

<div class="row departmentalSubmenu">
        <div class="col-lg-12">
                <ul class="departmentalSubmenu-nav">
                        <li class="first expanded dropdown">
                                <span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><i class="fa fa-link"></i> Quicklinks <span class="caret"></span></span>
                                <?php print views_embed_view('departmental_page_in_og', 'block', $og_id); ?>
                        </li>
                        <li><span data-toggle="modal" data-target="#deptSiteMapModal"><i class="fa fa-list-alt"></i> Site map</span></li>
                        <?php
                                if ($menu_display_name) {
                        ?>

                                        <li class="expanded dropdown">
                                                <span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><i class="fa fa-sign-in"></i> <?php echo $menu_display_name ?> <span class="caret"></span></span>
                                                <ul class="dropdown-menu">
                                                        <?php
                                                                foreach ($divisions_menu_array as $divisions_menu_array_item) {
                                                                        echo "<li class=\"leaf\"><a href=\"/" . drupal_get_path_alias($divisions_menu_array_item['href']) . "\">" . $divisions_menu_array_item['title'] . "</a></li>";
                                                                }
                                                        ?>
                                                </ul>
                                        </li>
                        <?php   } ?>

                        <?php print views_embed_view('departmental_faq_in_og', 'block', $og_id); ?>
                        <?php
                                if (count($og_node->field_departmental_contact_us)) {
                        ?>
                                        <li><a href="<?php echo $og_node->field_departmental_contact_us['und'][0]['safe_value'] ?>"><i class="fa fa-envelope-o"></i> Contact us</a></li>
                        <?php
                                }
                        ?>
                </ul>
        </div>
</div>


<?php include('departmental_site_map.inc'); ?>

<?php include('departmental_breadcrumb.inc'); ?>



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
