<?php

/**
 * @file
 * template.php
 */

/* code from visit.un.org to enable multiple levels for the menu tree */

// Provide < PHP 5.3 support for the __DIR__ constant.
if (!defined('__DIR__')) {
  define('__DIR__', dirname(__FILE__));
}
// require_once __DIR__ . '/includes/form.inc';
require_once __DIR__ . '/includes/menu.inc';

/**
 * @file template.php
 */

function bootstrap_iseek3_menu_tree(&$vars) {

  return '<ul class="nav navbar-nav">' . $vars['tree'] . '</ul>';

}

function bootstrap_iseek3_form_user_login_block_alter(&$form, &$form_state, $form_id) {

// print_r($form); //added meaningless comment

	// print "PRE";

	// print_r($form);

	$form['name']['#title'] = t('Login');
	$form['name']['#description'] = ''; 
        // $form['name']['#attributes']['placeholder'] = t('Enter your full name (e.g. Jane Doe)');
	$form['name']['#attributes']['placeholder'] = t('Webmail user name');
	$form['name']['#required'] = 0;

	$form['pass']['#title'] = '';
        $form['pass']['#description'] = '';
        // $form['pass']['#attributes']['placeholder'] = t('Enter your Webmail password');
	$form['pass']['#attributes']['placeholder'] = t('Webmail password');	
	$form['pass']['#required'] = 0;

	$form['actions']['submit']['#value'] = 'GO <i class="fa fa-angle-double-right"></i>';

	unset($form['links']);

	// print "POST";

	// print_r($form);
}



/**
 * Overrides theme_form_element().
 */
function bootstrap_iseek3_form_element(&$variables) {
  $element = &$variables['element'];
  $is_checkbox = FALSE;
  $is_radio = FALSE;

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }

  // Check for errors and set correct error class.
  if (isset($element['#parents']) && form_get_error($element)) {
    $attributes['class'][] = 'error';
  }

  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(
        ' ' => '-',
        '_' => '-',
        '[' => '-',
        ']' => '',
      ));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  if (!empty($element['#autocomplete_path']) && drupal_valid_path($element['#autocomplete_path'])) {
    $attributes['class'][] = 'form-autocomplete';
  }
  $attributes['class'][] = 'form-item';

  // See http://getbootstrap.com/css/#forms-controls.
  if (isset($element['#type'])) {
    if ($element['#type'] == "radio") {
      $attributes['class'][] = 'radio';
      $is_radio = TRUE;
    }
    elseif ($element['#type'] == "checkbox") {
      $attributes['class'][] = 'checkbox';
      $is_checkbox = TRUE;
    }
    else {
      $attributes['class'][] = 'form-group';
    }
  }

  $description = FALSE;
  $tooltip = FALSE;
  // Convert some descriptions to tooltips.
  // @see bootstrap_tooltip_descriptions setting in _bootstrap_settings_form()
  if (!empty($element['#description'])) {
    $description = $element['#description'];
    if (theme_get_setting('bootstrap_tooltip_enabled') && theme_get_setting('bootstrap_tooltip_descriptions') && $description === strip_tags($description) && strlen($description) <= 200) {
      $tooltip = TRUE;
      $attributes['data-toggle'] = 'tooltip';
      $attributes['title'] = $description;
    }
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }

  $prefix = '';
  $suffix = '';
  if (isset($element['#field_prefix']) || isset($element['#field_suffix'])) {
    // Determine if "#input_group" was specified.
    if (!empty($element['#input_group'])) {
      $prefix .= '<div class="input-group">';
      $prefix .= isset($element['#field_prefix']) ? '<span class="input-group-addon">' . $element['#field_prefix'] . '</span>' : '';
      $suffix .= isset($element['#field_suffix']) ? '<span class="input-group-addon">' . $element['#field_suffix'] . '</span>' : '';
      $suffix .= '</div>';
    }
    else {
      $prefix .= isset($element['#field_prefix']) ? $element['#field_prefix'] : '';
      $suffix .= isset($element['#field_suffix']) ? $element['#field_suffix'] : '';
    }
  }

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      if ($is_radio || $is_checkbox) {
        $output .= ' ' . $prefix . $element['#children'] . $suffix;
      }
      else {
        $variables['#children'] = ' ' . $prefix . $element['#children'] . $suffix;
      }
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

//  if ($description && !$tooltip) {
  if ($description) {	
    $output .= '<p class="help-block">' . $element['#description'] . "</p>\n";
  }

  $output .= "</div>\n";

  return $output;
}

// Full username fix for long names
// Implements THEME_preprocess_username().

/*

// commented out by eric - 1 june 2015

function bootstrap_iseek_preprocess_username(&$vars) {
  $vars['name'] = $vars['name_raw'];
}
*/

/**
 * Implements hook_js_alter().
 */
/* 
function bootstrap_iseek_js_alter(&$js) {
  // _bootstrap_alter is a "private" function of bootstrap base theme
  $excludes = _bootstrap_alter(bootstrap_theme_get_info('exclude'), 'js');
  $js = array_diff_key($js, $excludes);
}
*/

/*
Gets the content of a block given its machine_name, this name can be set in the custom user block thanks to the module 
Block Machine Name https://www.drupal.org/project/block_machine_name 
now block_delta is independent of local, dev or PROD
*/
function iseek_custom_block($machine_name, $retrieve){

  $result = db_query("SELECT bid FROM {fe_block_boxes} WHERE machine_name = :mn", array(':mn' => $machine_name));

  if ($result) {
    $row = $result->fetchAssoc();
    if ($row['bid']){//this returns false if nothing was fetched

      if($retrieve == 'title'){
        $block = block_load('block', $row['bid']);
        return t($block->title);
      }
      //else it returns the content
      $block = module_invoke('block', 'block_view', $row['bid']); 
      return t($block[$retrieve]); 
    }
    else{
      return t('Block not found, please add its machine name');
    }
  }

  return 'No result from query'; //this point should never be reached
  
}

/**
 * Provides menu links for the front page: page--front.tpl.php
 */

function bootstrap_iseek3_preprocess_page(&$variables){

  //put the toolkit menu links in vars
  $variables['menu_quicklinksNY'] = theme('links__menu-quick-links---ny', array('links' => menu_navigation_links('menu-quick-links---ny')));
  $variables['menu_ktt'] = theme('links__menu-key-tools-top', array('links' => menu_navigation_links('menu-key-tools-top')));
  $variables['menu_ktb'] = theme('links__menu-key-tools-bottom', array('links' => menu_navigation_links('menu-key-tools-bottom')));
  $variables['menu_staff'] = theme('links__menu-staff-development', array('links' => menu_navigation_links('menu-staff-development')));
  $variables['menu_pay'] = theme('links__menu-pay-benefits-insurance', array('links' => menu_navigation_links('menu-pay-benefits-insurance')));
  $variables['menu_security'] = theme('links__menu-security', array('links' => menu_navigation_links('menu-security')));
  $variables['menu_travel'] = theme('links__menu-travel', array('links' => menu_navigation_links('menu-travel')));
  $variables['menu_health'] = theme('links__menu-health-and-wellbeing', array('links' => menu_navigation_links('menu-health-and-wellbeing')));
  $variables['menu_rules'] = theme('links__menu-rules-and-regulations', array('links' => menu_navigation_links('menu-rules-and-regulations')));
  $variables['menu_reference'] = theme('links__menu-reference-and-manuals', array('links' => menu_navigation_links('menu-reference-and-manuals')));
  $variables['menu_ethics'] = theme('links__menu-ethics-internal-justice', array('links' => menu_navigation_links('menu-ethics-internal-justice')));
  $variables['menu_finance'] = theme('links__menu-finance-and-budget', array('links' => menu_navigation_links('menu-finance-and-budget')));
  //put the path to the footer in the logo
  $variables['path_logo_footer'] = '"'.drupal_get_path('theme', 'bootstrap_iseek3') . '/images/iseek-logo-white.png"';
  //blocks
  $variables['about_us_block'] = iseek_custom_block('about_us_footer_block', 'content'); 

  if (drupal_is_front_page()) //only in the homepage
  {
    //block views
    $block = module_invoke('weather', 'block_view', 'system_1');
    $variables['weather'] = $block['content'];

    $block = module_invoke('views', 'block_view', 'staff_union_block-block');
    $variables['staff_union_block'] = $block['content'];

    $block = module_invoke('views', 'block_view', 'recent_tjos-block');
    $variables['recent_tjos'] = $block['content'];

    $block = module_invoke('views', 'block_view', 'latest_zeekoslist-block');
    $variables['latest_zeekoslist'] = $block['content'];

    $block = module_invoke('views', 'block_view', 'latest_news-block');
    $variables['latest_news'] = $block['content'];

    $block = module_invoke('views', 'block_view', 'spotlight-block_1');
    $variables['spotlight'] = $block['content'];

    $variables['social_media_corner'] = iseek_custom_block('social_media_corner_block', 'content');
    //http://iseek/admin/structure/block/manage/views/latest_social_media_tip-block/configure
    $block = module_invoke('views', 'block_view', 'latest_social_media_tip-block');
    $variables['useful_tips'] = $block['content'];
    //menus
    $variables['menu_community'] = theme('links__menu-community', array('links' => menu_navigation_links('menu-community')));
  }
  
}

/*function bootstrap_iseek3_preprocess_views_view_fields(&$vars){
  $view = $vars['view'];
  if ($view->name == 'announcements'){
    $title = $vars['fields']['title'];
    $title->content == 'claseCHIDA';
  }
  //kpr($vars); die;
}*/

