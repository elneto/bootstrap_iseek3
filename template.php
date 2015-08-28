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

function bootstrap_iseek3_theme() {
	$items = array();
  	// create custom user-login.tpl.php
  	$items['user_login'] = array(
  		'render element' => 'form',
  		'path' => drupal_get_path('theme', 'bootstrap_iseek3') . '/templates',
  		'template' => 'user-login',
  		'preprocess functions' => array(
  			'bootstrap_iseek3_preprocess_user_login'
  		),
 	);
	return $items;
}


function bootstrap_iseek3_menu_tree(&$vars) {

  return '<ul class="nav navbar-nav">' . $vars['tree'] . '</ul>';

}

function bootstrap_iseek3_form_user_login_block_alter(&$form, &$form_state, $form_id) {

	$form['name']['#title'] = t('Login');
	$form['name']['#description'] = ''; 
        // $form['name']['#attributes']['placeholder'] = t('Enter your full name (e.g. Jane Doe)');
	$form['name']['#attributes']['placeholder'] = t('Webmail user name');
	$form['name']['#required'] = 0;

	$form['pass']['#title'] = '';
  $form['pass']['#description'] = '';
        // $form['pass']['#attributes']['placeholder'] = t('Enter your Webmail password');
	$form['pass']['#attributes']['placeholder'] = t('Webmail password');	
  $form['pass']['#attributes']['aria-label'] = t('Webmail password');
	$form['pass']['#required'] = 0;

	$form['actions']['submit']['#value'] = 'GO <i class="fa fa-angle-double-right"></i>';

	unset($form['links']);

}


function bootstrap_iseek3_form_alter(&$form, &$form_state, $form_id) {

	if ($form_id == "user_login") {

		$form['name']['#description'] = t('Webmail user name');
		$form['name']['#attributes']['placeholder'] = t('Webmail user name');

		$form['pass']['#description'] = t('Webmail password');
		$form['pass']['#attributes']['placeholder'] = t('Webmail password');

	}

  //removes the exposed filter location select from the classified/% view
  if ($form['#id'] == 'views-exposed-form-zeekoslist-zeekoslist-page' and
      $form['#action'] == '/classified/all')
    { 
        unset($form['#info']['filter-field_ad_location_tid']);
        $form['loc']['#access'] = FALSE;
    }

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

/**
 * Gets menu children
 */
function iseek_custom_get_menu_children($name){

  $parameters = array(
    'min_depth' => 2,
  );

  $children = menu_build_tree($name, $parameters);

  //kpr($children); die;
  
  $menu_children = array();
  foreach($children as $child) {
    $menu_children['menu-' . $child['link']['mlid']] = array('alter'=>TRUE, 'href'=>$child['link']['href'], 'title'=>$child['link']['title']);
  }
  return $menu_children;
}

/**
 * Provides menu links for the front page: page--front.tpl.php
 */

function bootstrap_iseek3_preprocess_page(&$variables){
  
  // switch depending on domain
  // 555
  if (require_login_display_local('newyork')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-quick-links---ny"))));
  // 131
  } elseif (require_login_display_local('geneva')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-quick-links---gva"))));
  // 60
  } elseif (require_login_display_local('addisababa')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-addis-ababa-quicklinks"))));
  // 61
  } elseif (require_login_display_local('bangkok')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-bangkok-quicklinks"))));
  // 62
  } elseif (require_login_display_local('beirut')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-beirut-quicklinks"))));
  // 63
  } elseif (require_login_display_local('nairobi')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-nairobi-quicklinks"))));
  // 64
  } elseif (require_login_display_local('santiago')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-santiago-quicklinks"))));
  // 65
  } elseif (require_login_display_local('vienna')) {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-vienna-quicklinks"))));
  // external
  } else {
          $variables['menu_quicklinks'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-external-quicklinks"))));
  }

   $variables['menu_ktt'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---key-tools-top", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_ktb'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---key-tools-bottom", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_staff'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---staff-development", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_pay'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---pay-benefits-and-", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_security'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---security", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_travel'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---travel", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_health'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---health-and-wellbe", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_rules'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---rules-and-regulat", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_reference'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---references-and-ma", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_ethics'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---ethics-and-intern", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_finance'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---finance-and-budge", array('min_depth' => 2, 'max_depth' => 2 )))));
   $variables['menu_ict'] = preg_replace('/"nav navbar-nav"/', '"links"', render(menu_tree_output(menu_build_tree("menu-toolkit---ict", array('min_depth' => 2, 'max_depth' => 2 )))));

}
