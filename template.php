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

	$form['name']['#description'] = ''; 
        $form['name']['#attributes']['placeholder'] = t('Enter your full name (e.g. Jane Doe)');
	$form['name']['#required'] = 0;

        $form['pass']['#description'] = '';
        $form['pass']['#attributes']['placeholder'] = t('Enter your Webmail password');	
	$form['pass']['#required'] = 0;

	$form['actions']['submit']['#value'] = 'GO <i class="fa fa-angle-double-right"></i>';

	unset($form['links']);
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

function bootstrap_iseek_preprocess_username(&$vars) {
  $vars['name'] = $vars['name_raw'];
}

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

/**
 * Provides menu links for the footer: region--page-bottom.tpl.php
 */

function bootstrap_iseek3_preprocess_region(&$vars) {
  //put the menu links in vars
  $vars['menu_quicklinksNY'] = theme('links__menu-quick-links---ny', array('links' => menu_navigation_links('menu-quick-links---ny')));
  $vars['menu_ktt'] = theme('links__menu-key-tools-top', array('links' => menu_navigation_links('menu-key-tools-top')));
  $vars['menu_ktb'] = theme('links__menu-key-tools-bottom', array('links' => menu_navigation_links('menu-key-tools-bottom')));
  $vars['menu_staff'] = theme('links__menu-staff-development', array('links' => menu_navigation_links('menu-staff-development')));
  $vars['menu_pay'] = theme('links__menu-pay-benefits-insurance', array('links' => menu_navigation_links('menu-pay-benefits-insurance')));
  $vars['menu_security'] = theme('links__menu-security', array('links' => menu_navigation_links('menu-security')));
  $vars['menu_travel'] = theme('links__menu-travel', array('links' => menu_navigation_links('menu-travel')));
  $vars['menu_health'] = theme('links__menu-health-and-wellbeing', array('links' => menu_navigation_links('menu-health-and-wellbeing')));
  $vars['menu_rules'] = theme('links__menu-rules-and-regulations', array('links' => menu_navigation_links('menu-rules-and-regulations')));
  $vars['menu_reference'] = theme('links__menu-reference-and-manuals', array('links' => menu_navigation_links('menu-reference-and-manuals')));
  $vars['menu_ethics'] = theme('links__menu-ethics-internal-justice', array('links' => menu_navigation_links('menu-ethics-internal-justice')));
  $vars['menu_finance'] = theme('links__menu-finance-and-budget', array('links' => menu_navigation_links('menu-finance-and-budget')));

  //put the path to needed images
  $vars['path_logo_footer'] = '"'.drupal_get_path('theme', 'bootstrap_iseek3') . '/images/iseek-logo-white.png"';

  //blocks
  $block = module_invoke('views', 'block_view', 'about_us_footer-block');
  $vars['about_us_block'] = $block['content'];

}

/*gets the delta of a block given its machine_name, this name can be set in the custom user block thanks to the module 
Block Machine Name https://www.drupal.org/project/block_machine_name */
function iseek_block_delta($machine_name){

  $result = db_query("SELECT bid FROM {block_machine_name_boxes} WHERE machine_name = :mn", array(':mn' => $machine_name));

  if ($result) {
    $row = $result->fetchAssoc();
    return $row['bid']; //this returns false if non was fetched
  }
  
}

function bootstrap_iseek3_preprocess_page(&$variables){
  //blocks
  $block = module_invoke('weather', 'block_view', 'system_1');
  $variables['weather'] = $block['content'];

  $block = module_invoke('views', 'block_view', 'staff_union_block-block');
  $variables['staff_union_block'] = $block['content'];

  $block = module_invoke('views', 'block_view', 'recent_tjos-block');
  $variables['recent_tjos'] = $block['content'];

  $block = module_invoke('views', 'block_view', 'latest_zeekoslist-block');
  $variables['latest_zeekoslist'] = $block['content'];

  $block_delta = iseek_block_delta('social_media_corner_block');
  if ($block_delta){
    $block = module_invoke('block', 'block_view', $block_delta); //131 local, change to 137 in PRODUCTION
    $variables['social_media_corner'] = $block['content']; //147 in DEV
  }
  else{
    $variables['social_media_corner'] = 'Block not found, please add its machine name';
  }
  
 

  //menus
  $variables['menu_community'] = theme('links__menu-community', array('links' => menu_navigation_links('menu-community')));
}

